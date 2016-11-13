<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::any('/login', function () {

    $api = new Iamstuartwilson\StravaApi(
        config('app.stravatistik.client_id'),
        config('app.stravatistik.client_secret')
    );

    if(request()->input('code'))
    {
        $obj = $api->tokenExchange(request()->input('code'));
        $token = $obj->access_token;
        session(['strava_token' => $token]);
        $api->setAccessToken($token);



        $foo = $api->get('athlete/activities');
        dd($foo);

    }else{

        $url = $api->authenticationUrl(request()->fullUrl(), $approvalPrompt = 'auto', $scope = null, $state = null);
        echo '<a href="'.$url.'">STRAVA LOGIN</a>';

    }


});



Route::get('/sync', function () {
    echo 'syyyyync';


    // list all activities since LAST_SYNC_ACTIVITY
    // si y a des resultats:
    //  foreach

    //return view('synch');
});
