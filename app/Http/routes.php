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
     * Organization forget password.
     */
    Route::get('/password_organization/reset','OrganizationPasswordController@getEmail');
    Route::post('/password_organization/email','OrganizationPasswordController@sendResetLinkEmail');
    Route::get('/password_organization/reset/{token}','OrganizationPasswordController@getReset');
    Route::post('/password_organization/reset','OrganizationPasswordController@reset');
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
    Route::get('organization/{id}/reviews' , 'OrganizationReviewController@index');
    Route::get('organization/{id}/review/{r_id}/report', 'OrganizationReviewController@report');
    Route::resource('organization/{id}/review', 'OrganizationReviewController');

    /**
     * Organizaton Blocking.
     */
    Route::get('organization/{id}/block','OrganizationController@block');
    Route::get('organization/{id}/unblock','OrganizationController@unblock');

    /**
     * Organization Events.
     */
    Route::get('organization/{id}/events', 'EventController@index');

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
    Route::get('volunteer/challenge', 'ChallengeController@index');
    Route::get('volunteer/challenge/create', 'ChallengeController@create');
    Route::post('volunteer/challenge', 'ChallengeController@store');
    Route::get('volunteer/challenge/edit', 'ChallengeController@edit');
    Route::patch('volunteer/challenge', 'ChallengeController@update');
    Route::get('volunteer/challenge/achieved',
                'ChallengeController@viewCurrentYearAttendedEvents');

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
        'show', 'edit', 'update'
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
     * Event Attendance Confirmation.
     */
    Route::get('event/{id}/confirm' , 'EventController@confirm');
    Route::get('event/{id}/attend' , 'EventController@attend');
    Route::get('event/{id}/unattend' , 'EventController@unattend');

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
    Route::resource('event','EventController', ['except' => 'index']);

/*
|-----------------------
| Admin Routes
|-----------------------
*/
    /**
     * Admin Assign  Validator.
     */
    Route::post('volunteer/{id}/validate','AdminController@adminAssignValidator');
});


/*
|--------------------------
| Organizations API Routes
|--------------------------
*/

    /**
    *  get a list of all organizations
    */
    Route::get('api/organization/list' , 'OrganizationAPIController@showList');

