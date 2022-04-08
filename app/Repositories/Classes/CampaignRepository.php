<?php

namespace App\Repositories\Classes;

use App\Http\Requests\Backstage\Campaigns\StoreRequest;
use App\Http\Requests\Backstage\Campaigns\UpdateRequest;
use App\Models\Campaign;
use App\Repositories\Interfaces\CampaignRepositoryInterface;
use App\Repositories\Repository;
use Carbon\Carbon;

class CampaignRepository extends Repository implements CampaignRepositoryInterface
{
    public function __construct()
    {
        $this->class='campaign';
    }

    private function create_array ($request){
        return array_merge(
            $request->toArray(),
            array(
                'starts_at' => Carbon::createFromFormat('d-m-Y H:i:s', $request->starts_at, $request->timezone)
                    ->setTimezone('UTC'),
                'ends_at' => Carbon::createFromFormat('d-m-Y H:i:s', $request->ends_at, $request->timezone)
                    ->setTimezone('UTC')
            )
        );
    }

    public function index()
    {
        return view('backstage.campaigns.index');
    }

    public function create()
    {
        return view('backstage.campaigns.create', [
            'campaign' => new Campaign(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        Campaign::create($this->create_array($request));
        $this->suc_flash($this->class,__FUNCTION__);
        return $this->index();
    }

    public function show($id)
    {
        dd(1);
    }

    public function edit(Campaign $campaign)
    {
        return view('backstage.campaigns.edit', compact('campaign'));
    }

    public function update(UpdateRequest $request, Campaign $campaign)
    {
        $campaign->update($this->create_array($request));
        $this->suc_flash($this->class,__FUNCTION__);
        return $this->index();
    }

    public function destroy(Campaign $campaign)
    {
        // TODO: Implement destroy() method.
    }

    public function use(Campaign $campaign)
    {
        // TODO: Implement use() method.
    }
}
