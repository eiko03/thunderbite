<?php

namespace App\Repositories\Classes;

use App\Http\Requests\Backstage\Symbols\StoreRequest;
use App\Http\Requests\Backstage\Symbols\UpdateRequest;
use App\Jobs\DeleteFile;
use App\Models\Symbol;
use App\Repositories\Interfaces\SymbolRepositoryInterface;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class SymbolRepository extends Repository implements SymbolRepositoryInterface
{
    public function __construct()
    {
        $this->class='symbol';
    }

    private function store_image($image){
        $path=Storage::disk('symbols')->put('/',$image);
        return array('image'=>'storage/symbols/'.$path);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backstage.symbols.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backstage.symbols.create', [
            'symbol' => new Symbol(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(StoreRequest $request)
    {
        try{
            Symbol::create(
                array_merge(
                    $request->toArray(),
                    $this->store_image($request->file('image'))
                )
            );
            $this->suc_flash($this->class,__FUNCTION__);
            return $this->index();
        }
        catch(\Exception $e){
            Log::critical('Failed ' . $e->getMessage());
            $this->error_flash($this->class,__FUNCTION__);
            return $this->index();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Symbol $symbol)
    {
        return view('backstage.symbols.edit', compact('symbol'));
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
        try{
            $request_image=null;

            if($request->hasFile('image')){
                $this->dispatch(new DeleteFile($symbol->image));
                $request_image = $this->store_image($request->file('image'));
            }

            $symbol->update(
                ($request_image)
                    ? array_merge($request->toArray(),$request_image)
                    :  $request->toArray()
            );

            $this->suc_flash($this->class,__FUNCTION__);
            return $this->index();
        }
        catch(\Exception $e) {
            Log::critical('Failed ' . $e->getMessage());
            $this->error_flash($this->class,__FUNCTION__);
            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Symbol $symbol)
    {
        try {
            $this->dispatch(new DeleteFile($symbol->image));
            $symbol->forceDelete();

            if (request()->ajax())
                return response()->json(['status' => 'success']);

            $this->suc_flash($this->class,__FUNCTION__);
            return $this->index();
        }
        catch(\Exception $e)
        {
            Log::critical('Failed ' . $e->getMessage());
            $this->error_flash($this->class,__FUNCTION__);
            return $this->index();
        }
    }
}
