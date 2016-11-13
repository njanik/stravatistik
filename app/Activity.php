<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\StravaApiRequest as StravaAPI;
use App\StravaActivity;


class Activity extends Model
{

    protected $table = 'activity';


    protected $guarded = [];

    public static function fromStravaActivity(StravaActivity $stravaActivity)
    {

        $activity = new Activity;

        $activity->fill([
            'strava_id' => $stravaActivity->id,
            'athlete_id' => '99999',
            'name' => $stravaActivity->name,
            'distance' => $stravaActivity->distance,
            'moving_time' => $stravaActivity->moving_time,
            'elapsed_time' => $stravaActivity->elapsed_time,
            'elevation' => $stravaActivity->total_elevation_gain,
            'strava_activity_raw' => json_encode($stravaActivity),
        ]);

        return $activity;

    }




}
