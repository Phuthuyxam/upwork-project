<?php

namespace App\Modules\Taxonomy\Controllers;

use App\Core\Glosary\LocationConfigs;
use App\Core\Glosary\MetaKey;
use App\Core\Glosary\ResponeCode;
use App\Http\Controllers\Controller;
use App\Modules\Setting\Repositories\OptionRepository;
use App\Modules\Taxonomy\Repositories\TermMetaRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use App\Modules\Taxonomy\Repositories\TermTaxonomyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaxonomyController extends Controller
{

    protected $termRepository;
    protected $termTaxonomyRepository;
    protected $termMetaRepository;
    protected $optionRepository;
    protected $termRelationRepository;

    public function __construct(TermRepository $termRepository, TermTaxonomyRepository $termTaxonomyRepository,
                                TermMetaRepository $termMetaRepository , OptionRepository $optionRepository,
                                TermRelationRepository $termRelationRepository)
    {
        $this->termRepository = $termRepository;
        $this->termTaxonomyRepository = $termTaxonomyRepository;
        $this->termMetaRepository = $termMetaRepository;
        $this->optionRepository = $optionRepository;
        $this->termRelationRepository = $termRelationRepository;
    }

    public function index(Request $request)
    {
        $categories = $this->termRepository->getCategories();
        $slugs = $this->termRepository->getAllSlug();
        $defaultCategory = $this->optionRepository->getInstantModel()->where('option_key','default_category')->first();
        return view('Taxonomy::index', compact('categories', 'slugs','defaultCategory'));
    }

    public function add(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|max:191',
                'slug' => 'required|unique:terms',
            ]);
            $isFirstTerm = true;

            $dataTerm = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ];
            if (count($this->termRepository->getAll())) {
                $isFirstTerm = false;
            }
            $termId = $this->termRepository->create($dataTerm)->id;
            if ($termId) {
                $dataTermTax = [
                    'term_id' => $termId,
                    'taxonomy' => 0,
                    'description' => $request->input('description'),
                ];

                $dataTermMeta = [
                    'term_id' => $termId,
                    'meta_key' => MetaKey::BRAND_LOGO['VALUE'],
                    'meta_value' => $request->input('logo') ? json_encode($request->input('logo')) : ''
                ];
                if ($isFirstTerm) {
                    $this->optionRepository->create(['option_key' => 'default_category', 'option_value' => $termId]);
                }
                $this->termTaxonomyRepository->create($dataTermTax);
                $this->termMetaRepository->create($dataTermMeta);
            }
            Log::info('User '.Auth::id().' has create category '.$termId);
            return redirect()->back()->with('message', 'success|Successfully add "' . $request->input('name') . '" brand');
        }catch (\Throwable $th){
            return redirect()->back()->with('message', 'danger|Something wrong try again!');
        }
    }

    public function delete(Request $request)
    {
         $id = $request->input('id');
        try {
            if (isset($id) && !empty($id)) {
                if(count($this->termRelationRepository->getByTermId($id))) {
                    $defaultCategory = $this->optionRepository->getDefaultCategory();
                    $this->termRelationRepository->updateByCondition([['term_taxonomy_id','=',$id]],['term_taxonomy_id' => $defaultCategory->option_value]);
                }

                $this->termRepository->delete($id);
                $this->termTaxonomyRepository->deleteByTermId($id);
                $this->termMetaRepository->deleteByTermId($id);
            }
            Log::info('User '.Auth::id().' has deleted category '.$id);
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
            $logo = $this->termMetaRepository->getInstantModel()->where([['term_id','=',$id],['meta_key','=',MetaKey::BRAND_LOGO['VALUE']]])->first();
            return view('Taxonomy::edit',compact('slugs','result','taxonomy','logo'));
        }else{
            try {
                $validateRule = [
                    'name' => 'required|max:191',
                    'slug' => 'required|unique:terms,slug,'. $id,
                ];
                $prefixLanguage = generatePrefixLanguage();
                if(isset($prefixLanguage) && !empty($prefixLanguage) && LocationConfigs::checkLanguageCode(str_replace("/","",$prefixLanguage))
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
                    $dataTermMeta = [
                        'meta_key' => MetaKey::BRAND_LOGO['VALUE'],
                        'meta_value' => $request->input('logo') ? json_encode($request->input('logo')) : ''
                    ];
                    $this->termTaxonomyRepository->updateByTermId($id, $dataTermTax);
                    $this->termMetaRepository->updateByTermId($id, $dataTermMeta);
                }
                Log::info('User '.Auth::id().' has updated category '.$id);
                return redirect()->back()->with('message', 'success|Successfully update "' . $request->input('name') . '" category');
            }catch (\Throwable $th) {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }

    public function changeDefault(Request $request) {
        $id = $request->input('id');
        if ($id) {
            if ($this->optionRepository->getInstantModel()->where('option_key','default_category')->update(['option_value' => $id])) {
                Log::info('User '.Auth::id().' has changed default category to '.$id);
                return response(ResponeCode::SUCCESS['CODE']);
            }else{
                return response(ResponeCode::SERVERERROR['CODE']);
            }
        }else{
            return response(ResponeCode::SERVERERROR['CODE']);
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

                    $dataTermMeta = [
                        'term_id' => $id,
                        'meta_key' => MetaKey::BRAND_LOGO['VALUE'],
                        'meta_value' => $request->input('logo') ? json_encode($request->input('logo')) : ''
                    ];

                    if ($this->termTaxonomyRepository->create($dataTermTax) && $this->termMetaRepository->create($dataTermMeta)) {
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
                Log::info('User '.Auth::id().' has delete categories'.json_encode($data));
                return response(ResponeCode::SUCCESS['CODE']);
            }else{
                return response(ResponeCode::SERVERERROR['CODE']);
            }
        }else{
            return response(ResponeCode::BADREQUEST['CODE']);
        }
    }
}
