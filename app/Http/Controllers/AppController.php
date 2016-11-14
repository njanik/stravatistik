<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\StravaActivityList;
use App\StravaActivity;
use App\Activity;


class AppController extends Controller
{

    public function __construct()
    {
        $this->middleware('stravaAuth')->except('login');
    }


    public function sync(){

        $res = StravaActivityList::get();

        //dd($res);

        foreach($res as $summaryActivity){

            if($summaryActivity->type != 'Run' || Activity::exist($summaryActivity->id)){
                continue;
            }

            $stravaId = $summaryActivity->id;
            $stravaActivity = StravaActivity::fromStravaId($stravaId);
            $activity = Activity::fromStravaActivity($stravaActivity);
            $activity->save();
        }

    }


    public function index(){
        echo 'coucou';
    }

    public function login()
    {

        $api = resolve('API');

        if(request()->input('code'))
        {
            $obj = $api->tokenExchange(request()->input('code'));
            $token = $obj->access_token;
            session(['strava_token' => $token]);
            $api->setAccessToken($token);


            echo 'token ok';

            //
            // $foo = $api->get('athlete/activities', [
            //     'per_page' => 200,
            //     'page' => 1,
            // ]);
            //

        }else{

            $url = $api->authenticationUrl(request()->fullUrl(), $approvalPrompt = 'auto', $scope = null, $state = null);
            echo '<a href="'.$url.'">STRAVA LOGIN</a>';

        }
    }
}
