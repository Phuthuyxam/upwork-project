<?php

namespace App\Modules\Taxonomy\Controllers;

use App\Core\Glosary\ResponeCode;
use App\Core\Glosary\TaxonomyType;
use App\Http\Controllers\Controller;
use App\Modules\Taxonomy\Repositories\TermRepository;
use App\Modules\Taxonomy\Repositories\TermTaxonomyRepository;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{

    protected $termRepository;
    protected $termTaxonomyRepository;

    public function __construct(TermRepository $termRepository, TermTaxonomyRepository $termTaxonomyRepository)
    {
        $this->termRepository = $termRepository;
        $this->termTaxonomyRepository = $termTaxonomyRepository;
    }

    public function index(Request $request)
    {
        $categories = $this->termRepository->getCategories();
        return view('Taxonomy::index',compact('categories'));
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')) {
            $validate = $request->validate([
                'name' => 'required|max:191',
                'slug' => 'required|unique:terms'
            ]);

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
                if ($this->termTaxonomyRepository->create($dataTermTax)) {
                    return redirect()->back()->with('message', 'success|Successfully add "'.$request->input('name').'" category');
                } else {
                    return redirect()->back()->with('message','danger|Something wrong try again!');
                }
            } else {
                return redirect()->back()->with('message','danger|Something wrong try again!');
            }
        }else{
            return view('Taxonomy::add');
        }

    }

    public function delete(Request $request) {
        $id = $request->input('id');
        try {
            if (isset($id) && !empty($id)) {
                $this->termRepository->delete($id);
                $this->termTaxonomyRepository->deleteByTermId($id);
            }
            return response(ResponeCode::SUCCESS['CODE']);
        }catch (\Throwable $th) {
           return response(ResponeCode::SERVERERROR['CODE']);
        }
    }
}
