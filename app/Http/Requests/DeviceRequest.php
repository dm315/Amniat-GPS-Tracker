<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
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
        $commonRules = [
            'name' => 'required|string|min:3|max:255',
            'model' => 'required|string|min:3|max:255',
            'phone_number' => 'nullable|numeric|digits:11',
            'user_id' => 'nullable|numeric|exists:users,id',
            'password' => 'nullable',
            'status' => 'required|numeric|in:0,1'
        ];

        $vehicleRules = [
            'required',
            'numeric',
            'exists:vehicles,id'
        ];

        if ($this->routeIs('device.store')) {
            $rules = array_merge($commonRules, [
                'serial' => 'required|numeric|min:10|unique:devices,serial',
                'brand' => 'required|string|in:sinotrack,wanway,concox',
                'personal' => 'nullable'
            ]);

        } else {
            $rules = array_merge($commonRules, [
                'serial' => 'required|numeric|min:10|unique:devices,serial,' . $this->device->id,
                'brand' => 'required|string|in:sinotrack,wanway,concox,qbit',
                'personal' => 'nullable'
            ]);

        }
        if (!$this->has('personal')) {
            $rules['vehicle_id'] = $vehicleRules;
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام دستگاه',
            'serial' => 'شماره سریال',
            'model' => 'مدل',
            'phone_number' => 'شماره سیم‌کارت',
            'vehicle_id' => 'وسیله نقلیه',
            'user_id' => 'خریدار',
            'brand' => 'برند'
        ];
    }
}
