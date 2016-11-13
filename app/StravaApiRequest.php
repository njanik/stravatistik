<?php

namespace App;


class StravaApiRequest
{

    public static function send($endPoint, $options = [])
    {
        $api = new \Iamstuartwilson\StravaApi(
            config('app.stravatistik.client_id'),
            config('app.stravatistik.client_secret')
        );

        $api->setAccessToken(session('strava_token'));

        $res = $api->get($endPoint, $options);

        return $res;

    }

}
