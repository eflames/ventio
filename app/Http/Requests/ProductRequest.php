<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'identifier' => 'required|max:255|unique:products,identifier,' .$this->id,
            'name' => 'required|max:255',
            'product_category_id' => 'required',
            'description' => 'max:255',
            'warehouse_id' => 'required_if:add_stock,1',
            'qty' => 'required_if:add_stock,1',
            'price' => 'required_if:add_stock,1',
            'cost_price' => 'required_if:add_stock,1',
        ];
    }
}
