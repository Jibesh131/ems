<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name'        => 'required|string|max:255',
            'email'       => "required|email|max:255|unique:users,email,$id",
            'phone'       => 'required|string',
            'password'    => $id
                ? 'nullable|string|min:8'
                : 'required|string|min:8',
            'status'      => 'required|in:active,inactive',

            'subjects'    => 'nullable|array',
            'subjects.*'  => 'nullable|integer|distinct|exists:subjects,id',

            'fees'        => 'nullable|array',
            'fees.*'      => 'nullable|numeric|min:1',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $subjects = $this->input('subjects', []);
            $fees     = $this->input('fees', []);

            foreach ($subjects as $i => $subject) {
                $fee = $fees[$i] ?? null;

                if ($subject && (!$fee || $fee < 1)) {
                    $validator->errors()->add(
                        "fees.$i",
                        'Session fee is required and must be at least 1.'
                    );
                }

                if ($fee && !$subject) {
                    $validator->errors()->add(
                        "subjects.$i",
                        'Subject is required when a session fee is provided.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'profile_pic.image' => 'The profile picture must be a valid image.',
            'profile_pic.mimes' => 'The profile picture must be a JPG or PNG file.',
            'profile_pic.max'   => 'The profile picture must not exceed 2MB.',

            'name.required' => 'The name field is required.',
            'name.string'   => 'The name must be a valid text value.',
            'name.max'      => 'The name may not exceed 255 characters.',

            'email.required' => 'The email address is required.',
            'email.email'    => 'Please provide a valid email address.',
            'email.max'      => 'The email address may not exceed 255 characters.',
            'email.unique'   => 'This email address is already in use.',

            'phone.required' => 'The phone number is required.',
            'phone.string'   => 'The phone number must be a valid text value.',

            'password.required' => 'The password field is required.',
            'password.string'   => 'The password must be a valid text value.',
            'password.min'      => 'The password must be at least 8 characters long.',

            'status.required' => 'The status field is required.',
            'status.in'       => 'The selected status is invalid.',

            'subjects.array'        => 'Subjects must be provided as a valid list.',
            'subjects.*.integer'    => 'Each subject selection must be valid.',
            'subjects.*.distinct'   => 'Each subject may only be selected once.',
            'subjects.*.exists'     => 'One or more selected subjects are invalid.',

            'fees.array'        => 'Session fees must be provided as a valid list.',
            'fees.*.numeric'    => 'Each session fee must be a numeric value.',
            'fees.*.min'        => 'Each session fee must be at least 1.',
        ];
    }
}
