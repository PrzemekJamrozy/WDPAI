<?php

namespace Utils\Helpers;

class RouterHelpers
{
    /**
     * @param string $url
     * @param array $actions
     * @return array
     */
    public static function findRequest(string $url, array $actions): array
    {
        $result = array_filter($actions, function (array $action) use ($url) {
            return $action[0] === $url;
        });

        return array_values($result)[0];
    }
}
