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
            'file.*' => 'required|mimes:jpg,png,gif',
            'title' => 'required',
            'description' => 'required'
        ]);

        $dataTerm = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ];

        $termId = $this->termRepository->create($dataTerm)->id;
        if ($termId) {
            $files = [];
            $file = $request->file('file');
            if ($request->hasFile('file')) {
                foreach ($file as $value) {
                    $fileName = $value->getClientOriginalName();
                    $value->storeAs('public/categories/'.$termId.'_'.$request->input('name'), $fileName);
                    $files[] = 'storage/categories/'.$termId.'_'.$request->input('name').'/'.$fileName;
                }
            }


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
                    'meta_value' => json_encode($files),
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
                'slug' => 'required|unique:terms,slug,'. $id,
                'file' => 'mimes:jpg,png,gif',
                'title' => 'required',
                'description' => 'required'
            ]);

            $name = $request->input('name');
            $result = false;
            $file = $request->file('files');
            if ($request->hasFile('files')) {
                $condition = [['term_id','=',$id],['meta_key' ,'=', MetaKey::BANNER['VALUE']]];
                $termMeta = $this->termMetaRepository->getByCondition($condition);
                $slideMeta = json_decode($termMeta['meta_value']);

                foreach ($file as $key => $value) {
                    $value->storeAs('public/categories/' . $id . '_' . $name . '/slides', $value->getClientOriginalName());
                    $slideMeta[$key] = 'storage/categories/' . $id . '_' . $name . '/slides/' . $value->getClientOriginalName();
                }
                $dataTermMeta = [
                    'meta_value' => json_encode($slideMeta)
                ];

                if ($this->termMetaRepository->updateByCondition($condition,$dataTermMeta)) {
                    $result = true;
                }
            }else{
                $imageMap = $request->input('banner');
                if (!empty($imageMap)) {
                    $condition = [['term_id','=',$id],['meta_key' ,'=', MetaKey::SLIDE['VALUE']]];
                    $dataPostMeta = [
                        'meta_value' => json_encode($imageMap)
                    ];

                    if ($this->termMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }
            }

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

    public function deleteImage(Request $request) {
        $termId = $request->input('termId');
        $data = $request->input('data');
        $result = false;
        if ($termId && $termId != '' && $data && $data != '') {

            $condition = [
                ['term_id' ,'=', $termId],
                ['meta_key','=', MetaKey::BANNER['VALUE']]
            ];
            $termMeta = $this->termMetaRepository->getByCondition($condition);
            $metaValue = json_decode($termMeta['meta_value']);

            $key = array_search($data, $metaValue);
            if ($key !== false) {
                $metaValue[$key] = "";
                if ($this->termMetaRepository->update($termMeta['id'],['meta_value' => json_encode($metaValue)])) {
                    $result = true;
                }
            }

            if ($result) {
                return response(ResponeCode::SUCCESS['CODE']);
            }else{
                return response(ResponeCode::SERVERERROR['CODE']);
            }
        }else {
            return response(ResponeCode::SERVERERROR['CODE']);
        }
    }

    public function deleteMany(Request $request) {
        $data = $request->input('ids');
        if ($data != '') {
            $valid = false;
            $ids = explode(',',$data);
            if ($this->termRepository->deleteMany('id',$ids)) $valid = true;
            if ($this->termTaxonomyRepository->deleteMany('term_id',$ids)) $valid = true;
            if ($this->termMetaRepository->deleteMany('term_id',$ids)) $valid = true;
            if ($valid) {
                return response(ResponeCode::SUCCESS['CODE']);
            }else{
                return response(ResponeCode::SERVERERROR['CODE']);
            }
        }else{
            return response(ResponeCode::BADREQUEST['CODE']);
        }
    }
}
