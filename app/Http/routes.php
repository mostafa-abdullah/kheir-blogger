<?php
/*
|==========================================================================
| Application Routes
|==========================================================================
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    /**
     * Homepage for logged-in volunteers/organizations or Welcome page for others.
     */
    Route::get('/', function () {
        if(Auth::user() || auth()->guard('organization')->check())
            return view('home');
        return view('welcome');
    });

/*
|==========================================================================
| Authentication Routes
|==========================================================================
|
| These routes are related to the authentication of volunteers/organizations.
|
*/
    /**
     * Organization login page.
     */
    Route::get('login_organization',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('/');
       return view('auth.login_organization');
    });

    /**
     * Organization login request.
     */
    Route::post('login_organization','OrganizationAuthController@login');

    /**
     * Organization register page.
     */
    Route::get('register_organization',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('/');
        return view('auth.register_organization');
    });

    /**
     * Organization register request.
     */
    Route::post('register_organization','OrganizationAuthController@register');

    /**
     * Organization logout request.
     */
    Route::get('logout_organization','OrganizationAuthController@logout');

    /**
     *  Volunteer Authentication (register/login/logout)
     */
    Route::auth();

    /**
     *  Volunteer Login Page.
     */
    Route::get('login',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('/');
        return view('auth.login');
    });

/*
|==========================================================================
| Functional Routes
|==========================================================================
|
| These routes are related to the main actions of the applications
| associated with volunteers, organizations or events.
| For the resource, use the following functions:
|       index   => view page for all models
|       show    => view page for a single model
|       create  => view page for creating a model
|       store   => create a model with the passed request
|       edit    => view page for updating a model
|       update  => update a model with the passed request
|       destroy => delete a model
*/

/*
|-----------------------
| Organization Routes
|-----------------------
*/

    /**
     * Organization Subscription.
     */
    Route::get('organization/{id}/subscribe', 'OrganizationController@subscribe');
    Route::get('organization/{id}/unsubscribe', 'OrganizationController@unsubscribe');

    /**
     * Organization Recommendation.
     */
    Route::get('organization/{id}/recommend' , 'OrganizationController@recommend');
    Route::post('organization/{id}/recommend' , 'OrganizationController@storeRecommendation');
    Route::get('organization/{id}/recommendations', 'OrganizationController@viewRecommendations');

    /**
     * Organization Reviewing.
     */
    Route::get('organization/{id}/review/{r_id}/report', 'OrganizationReviewController@report');
    Route::resource('organization/{id}/review', 'OrganizationReviewController');

    /**
     * Organizaton Blocking.
     */
    Route::post('organization/{id}/block','OrganizationController@block');

    /**
     * Organization CRUD.
     */
    Route::resource('organization', 'OrganizationController', ['only' => [
        'show', 'edit', 'update',
    ]]);

/*
|-----------------------
| Volunteer Routes
|-----------------------
*/
    /**
     *  Challenges Routes.
     */
     Route::get('volunteer/challenge/view' , 'VolunteerController@viewChallenges');
     Route::get('volunteer/challenge/attended' , 'VolunteerController@viewAttendedEvents');
    Route::resource('volunteer/challenge', 'ChallengeController' ['except' => [
        'show', 'destroy'
    );

    /**
     * Notification Routes.
     */
    Route::get('notifications', 'VolunteerController@showNotifications');
    Route::post('notifications', 'VolunteerController@unreadNotification');

    /**
     * Send feedback to the admin.
     */
    Route::get('feedback' , 'VolunteerController@createFeedback');
    Route::post('feedback' , 'VolunteerController@storeFeedback');

    /**
     * Volunteer CRUD.
     */
    Route::resource('volunteer','VolunteerController', ['only' => [
        'show',
    ]]);

/*
|-----------------------
| Event Routes
|-----------------------
*/
    /**
     *	Event Following.
     */
    Route::get('event/{id}/follow', 'EventController@follow');
    Route::get('event/{id}/unfollow', 'EventController@unfollow');

    /**
     *	Event Registeration.
     */
    Route::get('event/{id}/register', 'EventController@register');
    Route::get('event/{id}/unregister', 'EventController@unregister');

    /**
     * Event Post.
     */
    Route::resource('/event/{id}/post','EventPostController');

    /**
     * Event Question.
     */
    Route::get('event/{id}/question/answer', 'EventQuestionController@viewUnansweredQuestions');
    Route::post('event/{id}/question/{q_id}/answer', 'EventQuestionController@answer');
    Route::resource('event/{id}/question', 'EventQuestionController');

    /**
     * Event Reviewing.
     */
    Route::get('event/{id}/review/{r_id}/report', 'EventReviewController@report');
    Route::resource('event/{id}/review','EventReviewController');

    /**
     *  Event CRUD.
     */
    Route::resource('event','EventController', ['only' => [
<<<<<<< HEAD
         'show', 'create', 'store', 'edit', 'update'
=======
         'show', 'create', 'edit', 'update','destroy'
>>>>>>> origin/master
     ]]);
});
