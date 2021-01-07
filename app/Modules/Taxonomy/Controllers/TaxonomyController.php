<?php

namespace App\Modules\Taxonomy\Controllers;

use App\Core\Glosary\MetaKey;
use App\Core\Glosary\ResponeCode;
use App\Core\Glosary\TaxonomyType;
use App\Http\Controllers\Controller;
use App\Modules\Taxonomy\Repositories\TermMetaRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use App\Modules\Taxonomy\Repositories\TermTaxonomyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaxonomyController extends Controller
{

    protected $termRepository;
    protected $termTaxonomyRepository;
    protected $termMetaRepository;

    public function __construct(TermRepository $termRepository, TermTaxonomyRepository $termTaxonomyRepository, TermMetaRepository $termMetaRepository)
    {
        $this->termRepository = $termRepository;
        $this->termTaxonomyRepository = $termTaxonomyRepository;
        $this->termMetaRepository = $termMetaRepository;
    }

    public function index(Request $request)
    {
        $categories = $this->termRepository->getCategories();
        $slugs = $this->termRepository->getAllSlug();
        return view('Taxonomy::index', compact('categories', 'slugs'));
    }

    public function add(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:191',
            'slug' => 'required|unique:terms',
            'file' => 'required|mimes:jpg,png,gif',
            'title' => 'required',
            'description' => 'required'
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('public/categories', $fileName);
        $dataTerm = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ];

        $termId = $this->termRepository->create($dataTerm)->id;
        if ($termId) {
            $dataTermTax = [
                'term_id' => $termId,
                'taxonomy' => TaxonomyType::CATEGORY['VALUE'],
                'description' => $request->input('description'),
                'parent' => $request->input('parent') < 0 ? null : $request->input('parent')
            ];
            $metaList = [
                [
                    'term_id' => $termId,
                    'meta_key' => MetaKey::BANNER['VALUE'],
                    'meta_value' => $fileName,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'term_id' => $termId,
                    'meta_key' => MetaKey::TITLE['VALUE'],
                    'meta_value' => $request->input('title'),
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'term_id' => $termId,
                    'meta_key' => MetaKey::DESCRIPTION['VALUE'],
                    'meta_value' => $request->input('description'),
                    'created_at' => date('Y-m-d H:i:s')
                ],
            ];
            if ($this->termTaxonomyRepository->create($dataTermTax) && $this->termMetaRepository->insert($metaList)) {
                return redirect()->back()->with('message', 'success|Successfully add "' . $request->input('name') . '" category');
            } else {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        } else {
            return redirect()->back()->with('message', 'danger|Something wrong try again!');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        try {
            if (isset($id) && !empty($id)) {
                $this->termRepository->delete($id);
                $this->termTaxonomyRepository->deleteByTermId($id);
                $this->termMetaRepository->deleteByTermId($id);
            }
            return response(ResponeCode::SUCCESS['CODE']);
        } catch (\Throwable $th) {
            return response(ResponeCode::SERVERERROR['CODE']);
        }
    }

    public function edit(Request $request,$id) {
        if ($request->isMethod('get')) {
            $term = $this->termRepository->find($id);
            $termMeta = $term->termMeta->toArray();
            $result = [
                'id' => $term->id,
                'name' => $term->name,
                'slug' => $term->slug,
            ];
            foreach ($termMeta as $value) {
                $result[MetaKey::display($value['meta_key'])] = $value['meta_value'];
            }
            $slugs = $this->termRepository->getAllSlug();

            return view('Taxonomy::edit',compact('slugs','result'));
        }else{
            $validate = $request->validate([
                'name' => 'required|max:191',
                'slug' => 'required|unique:terms',
                'file' => 'required|mimes:jpg,png,gif',
                'title' => 'required',
                'description' => 'required'
            ]);

            $result = false;
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('public/categories', $fileName);
            $dataTerm = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ];

            if ($this->termRepository->update($id,$dataTerm)) {
                $result = false;
                $dataTermTax = [
                    'description' => $request->input('description'),
                    'parent' => $request->input('parent') < 0 ? null : $request->input('parent')
                ];
                if ($this->termTaxonomyRepository->updateByTermId($id,$dataTermTax)) {
                    $result = true;
                }
                $metaList = [
                    [
                        'meta_key' => MetaKey::BANNER['VALUE'],
                        'meta_value' => $fileName,
                    ],
                    [
                        'meta_key' => MetaKey::TITLE['VALUE'],
                        'meta_value' => $request->input('title'),
                    ],
                    [
                        'meta_key' => MetaKey::DESCRIPTION['VALUE'],
                        'meta_value' => $request->input('description'),
                    ],
                ];
                foreach ($metaList as $value) {
                    if ($this->termMetaRepository->updateByTermId($id,$value)) {
                        $result = true;
                    }
                }
                if ($result) {
                    return redirect()->back()->with('message', 'success|Successfully update "' . $request->input('name') . '" category');
                } else {
                    return redirect()->back()->with('message', 'danger|Something wrong try again!');
                }
            } else {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }
}
