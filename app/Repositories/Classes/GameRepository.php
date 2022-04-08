<?php

namespace App\Repositories\Classes;

use App\Http\Requests\Backstage\Games\StoreRequest;
use App\Repositories\Interfaces\GameRepositoryInterface;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Log;



class GameRepository extends Repository implements GameRepositoryInterface
{
    public function __construct()
    {
        $this->class='game';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        try{
            return view('backstage.games.index');
        }
        catch(\Exception $e){
            Log::critical('Failed ' . $e->getMessage());
            $this->error_flash($this->class,__FUNCTION__);
        }
    }


}
