<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LeaveCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (Request::routeIs('leave_category.store'))
        {
            return [
                'name' => 'required|unique:leave_categories,name',
                'leave_total' => 'required|integer',
                'status' => 'required|max:1|min:0'
            ];
        }

        if (Request::routeIs('leave_category.update'))
        {
            return [
                'name' => 'required|unique:leave_categories,name',
                'leave_total' => 'required|integer',
                'status' => 'max:1|min:0'
            ];
        }

        return [];

    }
}
