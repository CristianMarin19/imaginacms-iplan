<?php

namespace Modules\Iplan\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplan\Entities\Planuser;
use Modules\Iplan\Http\Requests\CreatePlanuserRequest;
use Modules\Iplan\Http\Requests\UpdatePlanuserRequest;
use Modules\Iplan\Repositories\PlanuserRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PlanuserController extends AdminBaseController
{
    /**
     * @var PlanuserRepository
     */
    private $planuser;

    public function __construct(PlanuserRepository $planuser)
    {
        parent::__construct();

        $this->planuser = $planuser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$planusers = $this->planuser->all();

        return view('iplan::admin.planusers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iplan::admin.planusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlanuserRequest $request
     * @return Response
     */
    public function store(CreatePlanuserRequest $request)
    {
        $this->planuser->create($request->all());

        return redirect()->route('admin.iplan.planuser.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplan::planusers.title.planusers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Planuser $planuser
     * @return Response
     */
    public function edit(Planuser $planuser)
    {
        return view('iplan::admin.planusers.edit', compact('planuser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Planuser $planuser
     * @param  UpdatePlanuserRequest $request
     * @return Response
     */
    public function update(Planuser $planuser, UpdatePlanuserRequest $request)
    {
        $this->planuser->update($planuser, $request->all());

        return redirect()->route('admin.Iplan.planuser.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplan::planusers.title.planusers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Planuser $planuser
     * @return Response
     */
    public function destroy(Planuser $planuser)
    {
        $this->planuser->destroy($planuser);

        return redirect()->route('admin.Iplan.planuser.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplan::planusers.title.planusers')]));
    }
}
