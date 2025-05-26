<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateProductRequest extends ProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        
        $id = $this->route('product');
        
        $rules['name'] = [
            'sometimes',
            'string',
            'max:255',
            Rule::unique('products', 'name')->ignore($id)
        ];

        // Torna todos os campos opcionais no update
        foreach ($rules as $field => &$rule) {
            if ($field !== 'name') {
                array_unshift($rule, 'sometimes');
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'name.unique' => 'Já existe um produto com esse nome.',
        ]);
    }
} 