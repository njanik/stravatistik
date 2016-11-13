<?php

namespace App;

use App\StravaApiRequest as StravaAPI;


class StravaActivity
{

    public static function fromStravaId($id)
    {
        $res = StravaApi::send('activities/'.$id);
        $stravaActivity = castObj('App\StravaActivity', $res);
        return $stravaActivity;
    }


}
