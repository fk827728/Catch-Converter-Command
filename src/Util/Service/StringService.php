<?php

namespace App\Util\Service;

class StringService
{
    /**
     * To Snake String
     *
     * @param string $camelString
     * @return string
     */
    public static function toSnakeString(string $camelString): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $camelString, $matches);
        $result = $matches[0];
        foreach ($result as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $result);
    }
}
