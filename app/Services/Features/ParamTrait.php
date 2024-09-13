<?php

namespace App\Services\Features;

trait ParamTrait
{
    #TODO сильно упрощенная реализация ...
    public static function getParamType(mixed $param = []): string
    {
        if (is_numeric($param)) {
            return 'id';
        }

        if ([] === $param) {
            return 'all';
        }

        if (is_array($param) && array_key_exists('filter', $param)) {
            return 'filter';
        }

        if (is_array($param) && array_key_exists('relation-filter', $param)) {
            return 'relation-filter';
        }

        return '';
    }
}
