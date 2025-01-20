<?php

namespace Utils\Helpers;

class RouterHelpers
{
    /**
     * @param string $url
     * @param array $actions
     * @return array|false
     */
    public static function findRequest(string $url, array $actions): array|false
    {
        $result = array_filter($actions, function (array $action) use ($url) {
            return $action[0] === $url;
        });
        if (count(array_values($result)) !== 0) {
            return array_values($result)[0];
        }
        return false;
    }
}
