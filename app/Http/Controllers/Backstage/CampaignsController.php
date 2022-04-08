<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backstage\Campaigns\StoreRequest;
use App\Http\Requests\Backstage\Campaigns\UpdateRequest;
use App\Models\Campaign;
use App\Models\Game;
use App\Models\Symbol;
use App\Repositories\Interfaces\CampaignRepositoryInterface;
use Carbon\Carbon;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public CampaignRepositoryInterface $campRepo;
    public function __construct(CampaignRepositoryInterface $campRepo)
    {
        $this->campRepo = $campRepo;
    }
    public function index()
    {
        $this->campRepo->index();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->campRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $this->campRepo->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->campRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Campaign $campaign)
    {
        $this->campRepo->edit($campaign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request,Campaign $campaign)
    {
        $this->campRepo->update($request,$campaign);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Campaign $campaign)
    {
        $this->campRepo->destroy($campaign);
    }

    public function use(Campaign $campaign)
    {
        $now = Carbon::now();
        if(Carbon::parse($campaign->starts_at)->gt($now)){
            session()->flash('error', 'The campaign did not started yet');
        }else if ( Carbon::parse($campaign->ends_at)->lt($now) ){
            session()->flash('error', 'The campaign already ended');
        }else if( Symbol::count() > 10 ){
            session()->flash('error', 'A maximum of 10 symbols should be existed. but it has '.Symbol::count());
        }else if( Symbol::count() < 6 ){
            session()->flash('error', 'A minimum of 6 symbols should be existed. but it has '.Symbol::count());
        }else if ( Game::where('account', auth()->user()->username)->whereBetween('created_at', [Carbon::now()->startOfDay()->toDateTimeString(), Carbon::now()->endOfDay()->toDateTimeString()])->count() > 0 ){
            session()->flash('error', 'you can only create 1 game per day');
        }else{
            session()->put('activeCampaign', $campaign->id);
            $game = new Game();
            $game->campaign_id = $campaign->id;
            $game->account = auth()->user()->username;
            $game->save();
            session()->put('gameId', $game->id);
        }
        return redirect()->route('backstage.campaigns.index');
    }
}
