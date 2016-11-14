<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\StravaApiRequest as StravaAPI;
use App\StravaActivity;


class Activity extends Model
{

    protected $table = 'activity';


    protected $guarded = [];



    public function scopeLastestFirst($query)
   {
       return $query->orderBy('date', 'DESC');
   }


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
            'pace' => round(((($stravaActivity->moving_time)) / ($stravaActivity->distance / 1000))),
            'date' => carbon($stravaActivity->start_date_local)->toDateTimeString(),
        ]);

        return $activity;

    }


    public static function exist($stravaId){
        $activity = self::where('strava_id', $stravaId)->first();
        return $activity && true;
    }

    public function getPace(){

        return gmdate('i:s', $this->pace);
    }


    public function raw()
    {
        return json_decode($this->strava_activity_raw);
    }


}
