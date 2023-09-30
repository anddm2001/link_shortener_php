<?php
declare(strict_types=1);

namespace app\services;

use app\repositories\UrlRepository;
use yii\web\HttpException;
use yii\base\BaseObject;
use app\models\ShortUrl;
use app\helpers\ValidatorUrlHelper;

class UrlService extends BaseObject
{
    private UrlRepository $repository;
    private HttpService $httpService;

    public const ALLOWED_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct(UrlRepository $repository, HttpService $httpService, $config = [])
    {
        parent::__construct($config);

        //ToDo Подключить логгер.
        $this->repository = $repository;
        $this->httpService = $httpService;
    }

    public function getByLongUrl(string $long_url): ?string
    {
        $res = $this->repository->findByLongUrl($long_url);

        if (!$res) {
            return '';
        }

        return $res;
    }

    public function createShortUrl(string $long_url): string
    {
        if (!ValidatorUrlHelper::check_start_with($long_url)) {
            $long_url = 'https://' . $long_url;
        }

        if (!ValidatorUrlHelper::check($long_url)) {
            throw new HttpException(418);
        }

        if (!$this->httpService->check_response($long_url)) {
            throw new HttpException(418);
        }

        $shortUrl = new ShortUrl();

        //ToDo Пока все пользователи неавторизованные.
        $shortUrl->user_id = ShortUrl::GUEST;
        $shortUrl->long_url = $long_url;

        $short_code = $this->generateShortUrl();

        $shortUrl->short_url = $short_code;
        $shortUrl->save();

        return $short_code;
    }

    private function generateShortUrl(): string
    {
        do {
            $shortCode = substr(str_shuffle(self::ALLOWED_CHARS), 0, 5);
        } while ($this->repository->countByShortUrl($shortCode));

        return $shortCode;
    }
}