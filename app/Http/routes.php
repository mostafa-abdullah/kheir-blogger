<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//Route::group(['middleware' => ['web']], function () {
//    //
//});


Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('login_organization',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        if(isset($errors))
            var_dump($errors);
       return view('auth.login_organization');
    });
    Route::get('/register_organization',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        return view('auth.register_organization');
    });
    Route::post('/register_organization','OrganizationController@register');
//    Route::post('/login_user','LoginController@userLogin');
    Route::post('/login_organization','LoginController@organizationLogin');
    Route::get('/logout_organization','OrganizationController@logout');
    Route::auth();
    Route::get('/login',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        return view('auth.login');
    });
    Route::resource('organization', 'OrganizationController', ['only' => [
        'update', 'edit','show'
    ]]);
    Route::get('/home', 'HomeController@index');
    Route::get('volunteer/{id}','VolunteerController@show');
});
