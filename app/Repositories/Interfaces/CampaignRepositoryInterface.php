<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Backstage\Campaigns\StoreRequest;
use App\Http\Requests\Backstage\Campaigns\UpdateRequest;
use App\Models\Campaign;

interface CampaignRepositoryInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index();

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create();

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request);

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id);

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Campaign $campaign);

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request,Campaign $campaign);

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Campaign $campaign);

    public function use(Campaign $campaign);
}
