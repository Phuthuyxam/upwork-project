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
                return response(ResponeCode::SUCCESS['CODE']);
            } else {
                return response(ResponeCode::SUCCESS['CODE']);
            }
        } else {
            return response(ResponeCode::COMMON_SAVE_FAIL['VALUE']);
        }
    }
}
