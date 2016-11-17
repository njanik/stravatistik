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


    public function scopeSums($query)
    {
        return $query
            ->select(\DB::raw('sum(distance) AS total_distance'));
    }

    public function scopeExtractDate($query)
    {
        return $query->addSelect([
            \DB::raw('DATE_FORMAT(date, "%Y-%u") as week'),
            // \DB::raw('DATE_FORMAT(date, "%Y-%m") as yyyymm'),
            // \DB::raw('DATE_FORMAT(date, "%Y-%m") as yyyymm'),

        ]);
    }

    public function scopeCurrentYear($query)
    {
        return $query
            ->whereYear('date', carbon()->now()->year);
    }

    public function scopeGroupDay($query)
    {
        return $query
            ->addSelect(\DB::raw('DATE_FORMAT(date, "%Y-%m-%d") as group_date'))
            ->groupBy(\DB::raw('DATE_FORMAT(date, "%Y-%m-%d")'));
    }

    public function scopeGroupMonth($query)
    {
        return $query
            ->addSelect(\DB::raw('DATE_FORMAT(date, "%Y-%m") as group_date'))
            ->groupBy(\DB::raw('DATE_FORMAT(date, "%Y-%m")'));
    }

    public function scopeGroupWeek($query)
    {
        return $query
            ->addSelect(\DB::raw('DATE_FORMAT(date, "%Y-%u") as week'))
            ->groupBy('week');
    }



    public function scope10k($query)
    {
       return $query->where('distance', 'DESC');
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
