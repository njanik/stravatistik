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




Route::any('/', 'AppController@index')->name('home');

Route::any('/login', 'AppController@login')->name('login');


Route::get('/sync', 'AppController@sync')->name('sync');


Route::get('/test', function(){


    $groups = \App\Activity::sums()
        ->groupMonth()
        ->get()
        ->pluck('total_distance', 'group_date');

    //dd($groups);

    $chart = Charts::create('bar', 'highcharts')
        //->setView('custom.line.chart.view') // Use this if you want to use your own template
        ->setTitle('My nice chart')
        ->setLabels($groups->keys())
        ->setValues($groups->values())
        //->setDimensions(1000,500)
        ->setResponsive(false);
    return view('test', ['chart' => $chart]);
    //dump($groups);


});
//
// Route::get('/sync', function () {
//     echo 'sync';

    // $res = \App\StravaActivity::getList();
    // dump($res);
    //
    // $stravaActivity = \App\StravaActivity::getFromId(771523953);
    //
    // $activity = \App\Activity::fromStravaActivity($stravaActivity);
    // dump($activity);


    // list all activities since LAST_SYNC_ACTIVITY
    // si y a des resultats:
    //  foreach

    //return view('synch');
// });
