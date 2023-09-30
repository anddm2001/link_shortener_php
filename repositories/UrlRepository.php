<?php
declare(strict_types=1);

namespace app\repositories;

use app\models\ShortUrl;

class UrlRepository
{
    public function findByLongUrl(string $long_url)
    {
        $shortUrl = ShortUrl::find()->where(['long_url' => $long_url])->one();

        /**
         * @var ShortUrl $shortUrl
         */
        if (!$shortUrl) {
            return false;
        }

        return $shortUrl->short_url;
    }

    public function countByShortUrl(string $short_url): int
    {
        return (int)ShortUrl::find()->where(['short_url' => $short_url])->count();
    }
}