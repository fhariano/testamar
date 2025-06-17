<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SalePriceRule implements Rule
{
    protected $costPrice;

    public function __construct($costPrice)
    {
        $this->costPrice = $costPrice;
    }

    public function passes($attribute, $value)
    {
        return $value >= ($this->costPrice * 1.10);
    }

    public function message()
    {
        return 'O preço de venda deve ser pelo menos 10% maior que o custo.';
    }
}
