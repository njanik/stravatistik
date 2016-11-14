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


    public function getBestTimeForDistance($distance)
    {
        $splits = $this->get1kSplits();
        if(count($splits) < $distance){
            return null;
        }

        //calcul nb de "distance possible"
        //exemple: si on veut calculer le meilleurs 5k dans un 9km,
        //on va avoir fait 5x 5k complet dans ce 9km
        //le split 1 a 5, 2 a 6, 3 a 7, 4 a 8 et 5 a 9

        $foo = $splits->count() - $distance + 1;

        $times = [];

        for($i=0; $i<$foo; $i++){
            $totalTime = 0;
            for($splitIndex = $i; $splitIndex < $distance+$i; $splitIndex++){
                $split = $splits->get($splitIndex);
                $totalTime += $split->elapsed_time;
            }
            $times[] = $totalTime;
        }

        // foreach($times as $sec){
        //     dump(timeFromSec($sec));
        // }

        sort($times);
        return array_shift($times);
    }


    public function getSplits()
    {
        return collect($this->splits_metric);
    }

    public function get1kSplits()
    {
        return $this->getSplits()
            ->filter(function($split){
                return $split->distance > 988;
            });
    }


}
