<?php

namespace App\Http\Requests;

use App\Models\CompanyInfo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCompanyInfoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('company_info_create');
    }

    public function rules()
    {
        return [
            'name_en' => [
                'string',
                'required',
                'unique:company_infos',
            ],
        ];
    }
}
