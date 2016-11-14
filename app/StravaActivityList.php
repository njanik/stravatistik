<?php

namespace App;


use App\StravaApiRequest as StravaAPI;



class StravaActivityList
{

    public static function get($page = 1){
        return StravaApi::send('athlete/activities', ['per_page' => 200, 'page' => $page]);
    }



}
