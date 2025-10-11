<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title.' . app()->getFallbackLocale() => 'required',
            'title.*' => 'nullable',
            'description.*' => 'nullable',
            'features.*' => 'nullable',
            'video' => 'nullable|active_url',
            'model3D' => 'nullable',
            'order' => 'required|numeric|min:0',
            'status' => 'required',
            'category_id' => 'nullable|numeric',
            "process_status" => 'required',
            'image' => 'image|mimes:png,jpeg,jpg,gif',
        ];
    }

    public function attributes(): array
    {
        return [
            'title.' . app()->getFallbackLocale() => __("admin/{$this->folder}.form_title"),
            'title.*' => __("admin/{$this->folder}.form_title"),
            'description.*' => __("admin/{$this->folder}.form_description"),
            'features.*' => __("admin/{$this->folder}.form_features"),
            'video' => __("admin/{$this->folder}.form_video"),
            'model3D' => __("admin/{$this->folder}.form_3d"),
            'order' => __('admin/general.order'),
            'status' => __('admin/general.status'),
            'process_status' => __("admin/project.form_process_status"),
            'category_id' => __("admin/{$this->folder}.form_category"),
            'image' => __("admin/{$this->folder}.form_image"),
        ];
    }
}
