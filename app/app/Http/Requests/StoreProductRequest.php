<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class StoreProductRequest extends ProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['name'] = array_merge($rules['name'], [Rule::unique('products', 'name')]);
        
        return $rules;
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'name.unique' => 'Já existe um produto com esse nome.',
        ]);
    }
} 