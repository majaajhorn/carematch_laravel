<?php

namespace App\Http\Requests;

use App\Enums\EmploymentType;
use App\Enums\SalaryPeriod;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
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
        return [
            'title' => ['required'],
            'salary' => ['required'],
            'salary_period' => ['required', Rule::enum(SalaryPeriod::class)], 
            'employment_type' => ['required', Rule::enum(EmploymentType::class)],
            'location' => ['required'],
            'description' => ['required', 'string', 'max:5000'], 
            'requirements' => ['nullable']
        ];
    }


}
