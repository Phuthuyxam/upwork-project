<?php

namespace App\Modules\Seo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seo\Repositories\SeoRepository;
use Illuminate\Http\Request;

class SeoController extends Controller
{

    protected $seoRepository;

    public function __construct(SeoRepository $seoRepository)
    {
        $this->seoRepository = $seoRepository;
    }

    public function getData($objectId, $seoType)
    {
        $result = [];
        $seoOptions = $getSeoOption = $this->seoRepository->filter([['object_id', $objectId] , ['seo_type', $seoType]]);
        if($seoOptions && $seoOptions->isNotEmpty()) {
            foreach ($seoOptions as $seo) {
                $result[$seo->seo_key] = $seo->seo_value;
            }
        }
        return response()->json($result);
    }

    public function add($objectId, $seoType, Request $request)
    {
        try {
            $getSeoOption = $this->seoRepository->filter([['object_id', $objectId] , ['seo_type', $seoType]]);
            if($getSeoOption && $getSeoOption->isNotEmpty()) {
                // delete
                $this->seoRepository->getInstantModel()->where([['object_id', $objectId] , ['seo_type', $seoType]])->delete();
            }

            $arraySave = [];

            foreach ($request->all() as $key => $field) {
                if($key != '_token'){
                    $field = $field == 'on' ? 1 : $field;
                    $arraySave[] = [
                        'object_id' => $objectId,
                        'seo_key' => $key,
                        'seo_value' => $field,
                        'seo_type' => $seoType
                    ];
                }
            }

            $this->seoRepository->getInstantModel()->insert($arraySave);
            return redirect()->back()->with('message', 'success|Seo option save success.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'danger|Seo option save something wrong try again!');
        }
    }
}
