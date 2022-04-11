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
        return $this->campRepo->index();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return $this->campRepo->create();
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
        return $this->campRepo->store($request);
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
        return $this->campRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Campaign $campaign)
    {
        return $this->campRepo->edit($campaign);
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
        return $this->campRepo->update($request,$campaign);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Campaign $campaign)
    {
        return $this->campRepo->destroy($campaign);
    }

    private function is_timed($date, $check){
        $carbon = Carbon::parse($date);
        if($check==1)
            return $carbon->lt(Carbon::now());
        else
            return $carbon->gt(Carbon::now());
    }

    public function use(Campaign $campaign)
    {
        if($this->is_timed($campaign->starts_at,1))
            session()->flash('error', 'The campaign did not started yet');

        else if ( $this->is_timed($campaign->ends_at,0))
            session()->flash('error', 'The campaign already ended');

        else if( Symbol::count() > 10 )
            session()->flash('error', 'A maximum of 10 symbols  existed. but it has '.Symbol::count());

        else if( Symbol::count() < 6 )
            session()->flash('error', 'A minimum of 6 symbols should existed. but it has '.Symbol::count());

        else if (Game::is_daily_limit_exceeded() ){
            session()->flash('error', 'you can create 1 game per day');
        }else{
            session()->put('activeCampaign', $campaign->id);
            session()->put('gameId', Game::create([
                'campaign_id'=>$campaign->id,
                'account' => auth()->user()->username
            ])->id);
        }
        return redirect()->route('backstage.campaigns.index');
    }
}
