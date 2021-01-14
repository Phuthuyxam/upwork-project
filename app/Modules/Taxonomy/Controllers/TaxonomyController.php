<?php

namespace App\Modules\Taxonomy\Controllers;

use App\Core\Glosary\LocationConfigs;
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
            'description' => 'required'
        ]);

//        $terms = $this->termRepository->getAll();
        $dataTerm = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ];

        $termId = $this->termRepository->create($dataTerm)->id;
        if ($termId) {
            $dataTermTax = [
                'term_id' => $termId,
                'taxonomy' => 0,
                'description' => $request->input('description'),
            ];

            if ($this->termTaxonomyRepository->create($dataTermTax)) {
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
            $result = [
                'id' => $term->id,
                'name' => $term->name,
                'slug' => $term->slug,
            ];
            $taxonomy = $this->termTaxonomyRepository->getByTermId($id);
            $slugs = $this->termRepository->getAllSlug();
            return view('Taxonomy::edit',compact('slugs','result','taxonomy'));
        }else{
            $validateRule = [
                'name' => 'required|max:191',
                'slug' => 'required|unique:terms,slug,'. $id,
                'description' => 'required',
            ];
            $prefixLanguage = generatePrefixLanguage();
            if($prefixLanguage && !empty($prefixLanguage) && LocationConfigs::checkLanguageCode(str_replace("/","",$prefixLanguage))
                && LocationConfigs::getLanguageDefault()['VALUE'] != str_replace("/","",$prefixLanguage))
                $validateRule['slug'] = "required|unique:terms_". str_replace("/","",$prefixLanguage) .",slug," . $id;
            $validate = $request->validate($validateRule);
            // make translation
            if(isset($request->translation) && !empty($request->translation) && LocationConfigs::checkLanguageCode($request->translation)) {
                $translation = $this->translationSave($request);
                if($translation) return redirect()->to($translation['redirect_url'])->with('message', $translation['message']);
                return redirect()->back()->with('message', 'danger|Something wrong when make a translation record try again!');
            }
            $name = $request->input('name');

            $dataTerm = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ];

            if ($this->termRepository->update($id,$dataTerm)) {
                $result = false;
                $dataTermTax = [
                    'description' => $request->input('description'),
                ];
                if ($this->termTaxonomyRepository->updateByTermId($id,$dataTermTax)) {
                    $result = true;
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

    // Translation
    public function translationSave($request) {
        app()->setLocale($request->translation);
        $this->termRepository->setModel();
        $this->termMetaRepository->setModel();
        $this->termTaxonomyRepository->setModel();
//                $transUrl = renderTranslationUrl(url()->current(), $request->translation);
        $slug = $request->input('slug');

        $translationRecord = $this->termRepository->filter([['slug' , $slug]]);
        if($translationRecord && $translationRecord->isNotEmpty()) {
            // update
            $transUrl = renderTranslationUrl(route('taxonomy.edit', ['id' => $translationRecord[0]->id]), $request->translation);
            return [ 'redirect_url' => $transUrl, 'message' => 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.' ];
        } else {
            // insert
            $dataInsert = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug')
            ];
            try {
                $id = $this->termRepository->create($dataInsert)->id;
                if($id) {
                    $dataTermTax = [
                        'description' => $request->input('description'),
                    ];

                    $dataTermTax = [
                        'term_id' => $id,
                        'taxonomy' => 0,
                        'description' => $request->input('description'),
                    ];

                    if ($this->termTaxonomyRepository->create($dataTermTax)) {
                        $transUrl = renderTranslationUrl(route('taxonomy.edit', ['id' => $id]), $request->translation);

                        return [ 'redirect_url' => $transUrl,
                                 'message' => 'success|Successfully add a Translation"' . $request->input('name') . '" category'
                                ];
                    } else {
                        return false;
                    }
                }
            } catch (\Throwable $th) {
                return false;
            }
        }
    }

    public function deleteMany(Request $request) {
        $data = $request->input('ids');
        if ($data != '') {
            $valid = false;
            $ids = explode(',',$data);
            if ($this->termRepository->deleteMany('id',$ids)) $valid = true;
            if ($this->termTaxonomyRepository->deleteMany('term_id',$ids)) $valid = true;
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
