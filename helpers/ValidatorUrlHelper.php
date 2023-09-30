<?php
declare(strict_types=1);

namespace app\helpers;

/**
 * Класс для валидации строки url, полученной от пользователя.
 */
class ValidatorUrlHelper
{
    /**
     * @param string $url
     * @return bool
     * Проверка формата url.
     */
    public static function check(string $url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {

            return false;
        }

        return true;
    }

    public static function check_start_with(string $url): bool
    {
        if (is_numeric(strpos($url, "https://")) || is_numeric(strpos($url, "http://"))) {

            return true;
        }

        return false;
    }
}