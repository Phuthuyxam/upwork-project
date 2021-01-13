<?php


namespace App\Modules\Debug\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\Setting\Repositories\OptionRepository;

class FixController extends Controller
{
    protected $optionRepository;

    public function __construct(OptionRepository $optionRepository) {
        $this->optionRepository = $optionRepository;
    }

    public function index() {
        $this->optionRepository->translationModel();
    }
}
