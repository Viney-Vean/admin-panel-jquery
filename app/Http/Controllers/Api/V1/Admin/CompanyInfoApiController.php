<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyInfoRequest;
use App\Http\Requests\UpdateCompanyInfoRequest;
use App\Http\Resources\Admin\CompanyInfoResource;
use App\Models\CompanyInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyInfoApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('company_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CompanyInfoResource(CompanyInfo::all());
    }

    public function store(StoreCompanyInfoRequest $request)
    {
        $companyInfo = CompanyInfo::create($request->all());

        return (new CompanyInfoResource($companyInfo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CompanyInfo $companyInfo)
    {
        abort_if(Gate::denies('company_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CompanyInfoResource($companyInfo);
    }

    public function update(UpdateCompanyInfoRequest $request, CompanyInfo $companyInfo)
    {
        $companyInfo->update($request->all());

        return (new CompanyInfoResource($companyInfo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CompanyInfo $companyInfo)
    {
        abort_if(Gate::denies('company_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyInfo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
