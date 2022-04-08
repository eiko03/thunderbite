<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\GameRepositoryInterface;

class GameController extends Controller
{
    public GameRepositoryInterface $gameRepo;
    public function __construct(GameRepositoryInterface $gameRepo)
    {
        $this->gameRepo = $gameRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->gameRepo->index();
    }


}
