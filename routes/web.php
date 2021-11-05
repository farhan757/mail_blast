<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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


Route::get('/send-mail', function () {
   
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    \Mail::to('farhan@xptlp.co.id')->send(new \App\Mail\SendingMail($details));
   
    dd("Email is Sent.");
});
/*Route::get('/ipinfo2', function (Request $request) {
    //$location_text = "The IP address {}.";
    return print_r($request->ipinfo->all);
});*/

Auth::routes();
Route::group(['prefix' => '', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::middleware('auth:web')->group(function () {



    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logout','Auth\LoginController@logout');
    Route::get('/getProject/{id?}','Controller@getProject')->name('getproject');
    Route::get('/getMasterData','Controller@getMasterData')->name('getmasterdata');
    Route::get('/getdashboard','HomeController@dashboard')->name('getdata.dashboard');
    Route::get('/gencode','Controller@gencode')->name('gencode');
    Route::get('/getset','Controller@getset')->name('getset');
    Route::get('/menus/{id?}','Settings\MenuController@childs');

    Route::group(['prefix'=>'startemail'], function(){
        Route::get('/upload','StartEmail\UploadController@index')->name('startemail.upload');
        Route::post('/upload/pro','StartEmail\UploadController@upload')->name('startemail.upload.save');
        Route::get('/listupload','StartEmail\ListUploadController@index')->name('startemail.listupload');
        Route::post('/listupload/detail/{id}','StartEmail\ListUploadController@detail');
        Route::post('/listupload/delete/{id}','StartEmail\ListUploadController@delete');
    });

    Route::group(['prefix'=>'proses'], function(){
        Route::get('/approval','Proses\ApprovalController@index')->name('proses.approval');
        Route::post('/approval/appWithid','Proses\ApprovalController@approvedWithid');
        Route::post('/approval/NoappWithid/{id}','Proses\ApprovalController@NoapprovedWithid');
        Route::get('/approval/downloadPdf/{id}','Proses\ApprovalController@downloadPdf')->name('proses.approval.downloadpf');

        Route::get('/noapproval','Proses\NotSentController@index')->name('proses.noapproval');
        Route::post('/noapproval/detail/{id}','Proses\NotSentController@detail');
    });

    Route::group(['prefix'=>'progress'], function(){
        Route::get('/sending','Progress\SendingController@index')->name('progress.sending');
        Route::post('/sending/detail/{id}','Progress\SendingController@detail');
        Route::post('/sending/resend','Progress\SendingController@resend');
    });

    Route::group(['prefix'=>'report'], function(){
        Route::get('/summary','Report\SummaryController@index')->name('report.summary');
        Route::post('/summary/export','Report\SummaryController@export')->name('report.summary.export');

        Route::get('/detail','Report\DetailController@index')->name('report.detail');
        Route::post('/detail/export','Report\DetailController@export')->name('report.detail.export');
    });

    Route::group(['prefix'=>'settings'], function(){
        Route::get('/body-email','Settings\BodyEmailController@index')->name('settings.bodyemail');
        Route::get('/body-email/show','Settings\BodyEmailController@show')->name('settings.bodyemail.show');
        Route::post('/body-email','Settings\BodyEmailController@save')->name('settings.bodyemail.save');
        Route::get('/body-email/{id}','Settings\BodyEmailController@showid')->name('settings.bodyemail.showid');
        Route::post('/body-email/{id}','Settings\BodyEmailController@update')->name('settings.bodyemail.update');
        Route::post('/body-email/delete/{id}','Settings\BodyEmailController@delete');

        Route::get('/project','Settings\ProjectController@index')->name('settings.project');
        Route::get('/project/show','Settings\ProjectController@form')->name('settings.project.form');
        Route::get('/project/{id}','Settings\ProjectController@formEdit')->name('settings.project.edit');
        Route::get('/project/getbodyEmail/{id}','Settings\ProjectController@getbodyEmail');
        Route::post('/project/save','Settings\ProjectController@save')->name('settings.project.save');
        Route::post('/project/update/{id}','Settings\ProjectController@update')->name('settings.project.update');
        Route::post('/project/delete/{id}','Settings\ProjectController@delete');

        Route::get('/customer','Settings\CustomerController@index')->name('settings.customer');
        Route::get('/customer/show','Settings\CustomerController@form')->name('settings.customer.form');
        Route::get('/customer/{id}','Settings\CustomerController@formEdit')->name('settings.customer.edit');        
        Route::post('/customer/save','Settings\CustomerController@save')->name('settings.customer.save');
        Route::post('/customer/update/{id}','Settings\CustomerController@update')->name('settings.customer.update');
        Route::post('/customer/delete/{id}','Settings\CustomerController@delete');  
        
        Route::get('/variable-field','Settings\FieldController@index')->name('settings.varfil');
        Route::get('/variable-field/show','Settings\FieldController@form')->name('settings.varfil.form');
        Route::post('/variable-field/save','Settings\FieldController@save')->name('settings.varfil.save');
        Route::post('/variable-field/cancel','Settings\FieldController@cancel')->name('settings.varfil.cancel');
        Route::post('/variable-field/deleteItem','Settings\FieldController@deleteItem')->name('settings.varfil.deleteItem');

        Route::get('/User','Settings\UserController@index')->name('settings.user');
        Route::get('/User/show','Settings\UserController@form')->name('settings.user.form');
        Route::get('/User/delete','Settings\UserController@delete')->name('settings.user.delete');
    });

    
});


