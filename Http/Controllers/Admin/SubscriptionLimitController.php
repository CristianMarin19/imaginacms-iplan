<?php

namespace Modules\Iplan\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplan\Entities\SubscriptionLimit;
use Modules\Iplan\Http\Requests\CreateSubscriptionLimitRequest;
use Modules\Iplan\Http\Requests\UpdateSubscriptionLimitRequest;
use Modules\Iplan\Repositories\SubscriptionLimitRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SubscriptionLimitController extends AdminBaseController
{
    /**
     * @var SubscriptionLimitRepository
     */
    private $subscriptionlimit;

    public function __construct(SubscriptionLimitRepository $subscriptionlimit)
    {
        parent::__construct();

        $this->subscriptionlimit = $subscriptionlimit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$subscriptionlimits = $this->subscriptionlimit->all();

        return view('iplan::admin.subscriptionlimits.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iplan::admin.subscriptionlimits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSubscriptionLimitRequest $request
     * @return Response
     */
    public function store(CreateSubscriptionLimitRequest $request)
    {
        $this->subscriptionlimit->create($request->all());

        return redirect()->route('admin.iplan.subscriptionlimit.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplan::subscriptionlimits.title.subscriptionlimits')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SubscriptionLimit $subscriptionlimit
     * @return Response
     */
    public function edit(SubscriptionLimit $subscriptionlimit)
    {
        return view('iplan::admin.subscriptionlimits.edit', compact('subscriptionlimit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SubscriptionLimit $subscriptionlimit
     * @param  UpdateSubscriptionLimitRequest $request
     * @return Response
     */
    public function update(SubscriptionLimit $subscriptionlimit, UpdateSubscriptionLimitRequest $request)
    {
        $this->subscriptionlimit->update($subscriptionlimit, $request->all());

        return redirect()->route('admin.Iplan.subscriptionlimit.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplan::subscriptionlimits.title.subscriptionlimits')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SubscriptionLimit $subscriptionlimit
     * @return Response
     */
    public function destroy(SubscriptionLimit $subscriptionlimit)
    {
        $this->subscriptionlimit->destroy($subscriptionlimit);

        return redirect()->route('admin.Iplan.subscriptionlimit.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplan::subscriptionlimits.title.subscriptionlimits')]));
    }
}
