<?php

namespace App\Http\Requests;

use App\Enums\EmploymentType;
use App\Enums\EnglishLevel;
use App\Enums\Gender;
use App\Enums\LiveInExperience;
use App\Enums\SalaryPeriod;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreProfileRequest extends FormRequest
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
        $userId = $this->user()->id ?? null;

        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'location' => ['required'],
            'contact' => ['required'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'english_level' => ['required', Rule::enum(EnglishLevel::class)],
            'live_in_experience' => ['required', Rule::enum(LiveInExperience::class)],
            'driving_license' => ['required'],
            'about_yourself' => ['required', 'string', 'max:5000'],
        ];
    }


}