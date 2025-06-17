<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SalePriceRule;
use App\Rules\HtmlTagsRule;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:45',
            'description' => ['required', new HtmlTagsRule()],
            'sale_price' => ['required', 'numeric', new SalePriceRule($this->cost_price)],
            'cost_price' => 'required|numeric|min:0.1',
            'images.*' => 'nullable|image|mimes:jpg,png|max:2048',
        ];
    }
}
