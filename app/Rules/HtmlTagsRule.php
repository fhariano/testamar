<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HtmlTagsRule implements Rule
{
    protected array $allowedTags = ['p', 'br', 'b', 'strong'];

    public function passes($attribute, $value): bool
    {
        // Verifica se é string
        if (!is_string($value)) {
            return false;
        }

        // Remove as tags permitidas temporariamente
        $allowed = implode('|', $this->allowedTags);

        // Regex para capturar todas as tags
        preg_match_all('/<([a-zA-Z0-9]+)(\s[^>]*)?>/i', $value, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $tag) {
                if (!preg_match('/^(' . $allowed . ')$/i', $tag)) {
                    return false; // Tag não permitida encontrada
                }
            }
        }

        // Verifica se existem tags de fechamento inválidas
        preg_match_all('/<\/([a-zA-Z0-9]+)>/i', $value, $closingTags);

        if (!empty($closingTags[1])) {
            foreach ($closingTags[1] as $tag) {
                if (!preg_match('/^(' . $allowed . ')$/i', $tag)) {
                    return false; // Tag de fechamento não permitida encontrada
                }
            }
        }

        return true;
    }

    public function message(): string
    {
        return 'O campo :attribute contém tags HTML não permitidas. Permitidas: <p>, <br>, <b> e <strong>.';
    }
}

