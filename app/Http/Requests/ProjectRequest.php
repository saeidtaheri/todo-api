<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:projects|min:3',
        ];
    }

    public function project()
    {
        $project = new Project();
        $project->user_id = $this->user()->id;
        $project->name = $this->name;
        $project->description = $this->description;

        return $project;
    }
}
