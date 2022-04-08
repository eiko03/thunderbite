<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backstage\Symbols\StoreRequest;
use App\Http\Requests\Backstage\Symbols\UpdateRequest;
use App\Models\Symbol;
use App\Repositories\Interfaces\SymbolRepositoryInterface;



class SymbolController extends Controller
{
    private SymbolRepositoryInterface $symbolRepo;

    public function __construct(SymbolRepositoryInterface $symbolRepo)
    {
        $this->symbolRepo = $symbolRepo;
    }

    public function index()
    {
        return $this->symbolRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return $this->symbolRepo->create();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(StoreRequest $request)
    {
        return $this->symbolRepo->store( $request);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Symbol $symbol)
    {
        return $this->symbolRepo->edit( $symbol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Symbol $symbol
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update(UpdateRequest $request, Symbol $symbol)
    {
        return $this->symbolRepo->update( $request,$symbol);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Symbol $symbol)
    {
        return $this->symbolRepo->destroy( $symbol);
    }
}
