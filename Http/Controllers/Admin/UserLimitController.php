<?php

namespace Modules\Iplan\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplan\Entities\UserLimit;
use Modules\Iplan\Http\Requests\CreateUserLimitRequest;
use Modules\Iplan\Http\Requests\UpdateUserLimitRequest;
use Modules\Iplan\Repositories\UserLimitRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UserLimitController extends AdminBaseController
{
    /**
     * @var UserLimitRepository
     */
    private $userlimit;

    public function __construct(UserLimitRepository $userlimit)
    {
        parent::__construct();

        $this->userlimit = $userlimit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$userlimits = $this->userlimit->all();

        return view('iplan::admin.userlimits.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iplan::admin.userlimits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserLimitRequest $request
     * @return Response
     */
    public function store(CreateUserLimitRequest $request)
    {
        $this->userlimit->create($request->all());

        return redirect()->route('admin.iplan.userlimit.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplan::userlimits.title.userlimits')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserLimit $userlimit
     * @return Response
     */
    public function edit(UserLimit $userlimit)
    {
        return view('iplan::admin.userlimits.edit', compact('userlimit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserLimit $userlimit
     * @param  UpdateUserLimitRequest $request
     * @return Response
     */
    public function update(UserLimit $userlimit, UpdateUserLimitRequest $request)
    {
        $this->userlimit->update($userlimit, $request->all());

        return redirect()->route('admin.iplan.userlimit.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplan::userlimits.title.userlimits')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserLimit $userlimit
     * @return Response
     */
    public function destroy(UserLimit $userlimit)
    {
        $this->userlimit->destroy($userlimit);

        return redirect()->route('admin.iplan.userlimit.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplan::userlimits.title.userlimits')]));
    }
}
