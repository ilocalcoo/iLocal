<?php

namespace app\components;

use Yii;
use yii\authclient\AuthAction;
use yii\web\NotFoundHttpException;


class ExtendedAuthAction extends AuthAction
{
    public function run()
    {
        $clientId = Yii::$app->getRequest()->getQueryParam($this->clientIdGetParamName);
        if (!empty($clientId)) {
            /* @var $collection \yii\authclient\Collection */
            $collection = Yii::$app->get($this->clientCollection);
            if (!$collection->hasClient($clientId)) {
                throw new NotFoundHttpException("Unknown auth client '{$clientId}'");
            }
            $client = $collection->getClient($clientId);

            if ($client->getName() == 'facebook') {
                if (!isset($_SERVER['HTTPS'])) {
                    $_SERVER['HTTPS'] = 1;
                }
            }

            return $this->auth($client);
        }

        throw new NotFoundHttpException();
    }


}