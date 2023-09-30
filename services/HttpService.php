<?php
declare(strict_types=1);

namespace app\services;

use linslin\yii2\curl;
use yii\base\BaseObject;

class HttpService extends BaseObject
{
    /**
     * @param string $url
     * @return bool
     * Проверяем, что ссылка работающая.
     */
    public function check_response(string $url): bool
    {
        $curl = new curl\Curl();

        $curl->setOption(CURLOPT_SSL_VERIFYHOST, false);
        $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setOption(CURLOPT_FOLLOWLOCATION, true);
        $curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $curl->setOption(CURLOPT_AUTOREFERER, true);
        $curl->setOption(CURLOPT_CONNECTTIMEOUT, 60);
        $curl->setOption(CURLOPT_TIMEOUT, 30);
        $curl->setOption(CURLOPT_MAXREDIRS, 10);
        $curl->setOption(
            CURLOPT_USERAGENT,
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'
        );

        $curl->get($url);

        if ($curl->responseCode != 200) {
            return false;
        }

        return true;
    }
}