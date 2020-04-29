<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends FormRequest
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
        $rules = [
            'name' => 'required|unique:categories',
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['name'] = ['required', Rule::unique('categories')->ignore($this->category)];
        }

        return $rules;
    }

    public function createCategory()
    {
        return Category::create([
            'title' => $this->name,
        ]);
    }

    public function updateCategory($category)
    {
        $category->update($this->all());

        return $category;
    }
}
