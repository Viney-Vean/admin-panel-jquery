<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCompanyInfoRequest;
use App\Http\Requests\StoreCompanyInfoRequest;
use App\Http\Requests\UpdateCompanyInfoRequest;
use App\Models\CompanyInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyInfoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('company_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyInfos = CompanyInfo::all();

        return view('admin.companyInfos.index', compact('companyInfos'));
    }

    public function create()
    {
        abort_if(Gate::denies('company_info_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companyInfos.create');
    }

    public function store(StoreCompanyInfoRequest $request)
    {
        $companyInfo = CompanyInfo::create($request->all());

        return redirect()->route('admin.company-infos.index');
    }

    public function edit(CompanyInfo $companyInfo)
    {
        abort_if(Gate::denies('company_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companyInfos.edit', compact('companyInfo'));
    }

    public function update(UpdateCompanyInfoRequest $request, CompanyInfo $companyInfo)
    {
        $companyInfo->update($request->all());

        return redirect()->route('admin.company-infos.index');
    }

    public function show(CompanyInfo $companyInfo)
    {
        abort_if(Gate::denies('company_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companyInfos.show', compact('companyInfo'));
    }

    public function destroy(CompanyInfo $companyInfo)
    {
        abort_if(Gate::denies('company_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyInfo->delete();

        return back();
    }

    public function massDestroy(MassDestroyCompanyInfoRequest $request)
    {
        CompanyInfo::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
