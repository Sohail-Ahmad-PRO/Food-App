<?php

namespace App\Http\Requests;

/**
 * Class OrderRequest
 * @package App\Http\Requests
 */
class OrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|gte:1',
        ];
    }

    public function messages(): array
    {
        return [
            'products' => 'Please specify valid products in order to place an order',
            'products.*.product_id.exists' => 'One of the products you mentioned does not exists in the system',
            'products.*.quantity.gte' => 'A product must have quantity of at least one',
        ];
    }
}
