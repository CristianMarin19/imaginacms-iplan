<?php

namespace Modules\Iplan\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplan\Entities\Limit;
use Modules\Iplan\Http\Requests\CreateLimitRequest;
use Modules\Iplan\Http\Requests\UpdateLimitRequest;
use Modules\Iplan\Repositories\LimitRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class LimitController extends AdminBaseController
{
    /**
     * @var LimitRepository
     */
    private $limit;

    public function __construct(LimitRepository $limit)
    {
        parent::__construct();

        $this->limit = $limit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$limits = $this->limit->all();

        return view('iplan::admin.limits.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iplan::admin.limits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateLimitRequest $request
     * @return Response
     */
    public function store(CreateLimitRequest $request)
    {
        $this->limit->create($request->all());

        return redirect()->route('admin.iplan.limit.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplan::limits.title.limits')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Limit $limit
     * @return Response
     */
    public function edit(Limit $limit)
    {
        return view('iplan::admin.limits.edit', compact('limit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Limit $limit
     * @param  UpdateLimitRequest $request
     * @return Response
     */
    public function update(Limit $limit, UpdateLimitRequest $request)
    {
        $this->limit->update($limit, $request->all());

        return redirect()->route('admin.iplan.limit.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplan::limits.title.limits')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Limit $limit
     * @return Response
     */
    public function destroy(Limit $limit)
    {
        $this->limit->destroy($limit);

        return redirect()->route('admin.Iplan.limit.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplan::limits.title.limits')]));
    }
}
