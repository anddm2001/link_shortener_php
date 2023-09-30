<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\services\UrlService;
use app\models\ShortUrl;
use app\models\UserInfo;

class SiteController extends Controller
{
    private UrlService $urlService;

    public function __construct($id, $module, UrlService $urlService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->urlService = $urlService;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSendUrl()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->post()) {
            return ['error' => 400, 'message' => 'Некорректный http запрос'];
        }

        $data = Yii::$app->request->post();
        $url = trim($data['url']);

        $short_url = $this->urlService->getByLongUrl($url);

        if ($short_url) {

            return [
                'short_url' => $short_url
            ];
        }

        $short_url = $this->urlService->createShortUrl($url);

        return [
            'short_url' => $short_url
        ];
    }

    /**
     * @throws \HttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionForward($code): Response
    {
        $model_info = new UserInfo();

        $url = ShortUrl::validateShortCode($code);
        $url->updateCounters(['counter' => 1]);

        $user_info = parse_user_agent();
        $user_ip = Yii::$app->geoip->ip();

        $model_info->setAttributes(
            [
                'short_url_id' => $url['id'],
                'user_platform' => $user_info['platform'],
                'user_agent' => $user_info['browser'],
                'user_refer' => Yii::$app->request->referrer,
                'user_ip' => Yii::$app->request->userIP,
                'user_country' => $user_ip->country,
                'user_city' => $user_ip->city,
            ]
        );
        $model_info->save();

        return $this->redirect($url['long_url']);
    }
}
