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

Route::group(['middleware' => ['web']], function () {

    /**
     *  Welcome page (for not logged-in volunteers/organizations)
     */
    Route::get('/', function () {
        if(Auth::user() || auth()->guard('organization')->check())
            return view('home');
        return view('welcome');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes are related to the authentication of volunteers and organizations
|
*/
    /**
     *  Login page for organizations
     */
    Route::get('login_organization',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        if(isset($errors))
            var_dump($errors);
       return view('auth.login_organization');
    });

    /**
     *  Login an organization with a request containing email and password
     */
    Route::post('/login_organization','LoginController@organizationLogin');

    /**
     *  Register page for organizations
     */
    Route::get('/register_organization',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
        return view('auth.register_organization');
    });

    /**
     *  Register an organization with a request containing name, email and password
     */
    Route::post('/register_organization','OrganizationController@register');

    /**
     *  Logout organization
     */
    Route::get('/logout_organization','OrganizationController@logout');

    /**
     *  Authentication related to the user (volunteer)
     */
    Route::auth();

    /**
     *  Login a user(volunteer) - Added to guard from a logged in user
     *  or organization
     */
    Route::get('/login',function(){
        if(Auth::user() || auth()->guard('organization')->check())
            return redirect('home');
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

    Route::get('/unread', function(){
        $notifications = Auth::user()->notifications()->read()->get();
        foreach($notifications as $notification)
        {
            $notification->pivot->read = 0;
            $notification->push();
        }
    });
    /**
     *  Homepage (for logged-in volunteers/organizations)
     */
    Route::get('home', 'HomeController@index');

    /**
     * Send feed back to the admin (for logged-in volunteers/organizations)
     */
    Route::get('feedback' , 'HomeController@sendFeedback');
    Route::post('fpeedback' , 'HomeController@storeFeedback');

    /**
     * Reports Routes
     */
    Route::post('organization/{id}/review/{r_id}/report', 'VolunteerController@reportOrganizationReview');
    Route::post('event/{id}/review/{r_id}/report', 'VolunteerController@reportEventReview');

    /*
    |-----------------------
    | Organization Routes
    |-----------------------
    */

    /**
     *	Organization Subscription
     */
    Route::get('organization/{id}/subscribe', 'VolunteerController@subscribe');
    Route::get('organization/{id}/unsubscribe', 'VolunteerController@unsubscribe');

    /**
     *	Organization Recommendation
     */
    Route::get('organization/{id}/recommend' , 'OrganizationController@recommend');
    Route::post('organization/{id}/recommend' , 'OrganizationController@storeRecommendation');
    Route::get('organization/{id}/recommendations', 'OrganizationController@viewRecommendations');
    /**
     *	Organization Review
     */
    Route::get('organization/{id}/review','OrganizationController@createReview');
    Route::post('organization/{id}/review','OrganizationController@storeReview');


    Route::resource('organization', 'OrganizationController', ['only' => [
        'show', 'edit', 'update',
    ]]);
    Route::get('/home', 'HomeController@index');
    Route::get('volunteer/{id}','VolunteerController@show');

   /*
    *  block an organization
    */

    Route::post('organization/{id}/block','VolunteerController@blockAnOrganization');

    /*
    |-----------------------
    | Volunteer Routes
    |-----------------------
    */
    /**
     * Notification Routes
     */
    Route::get('notifications', 'VolunteerController@showNotifications');
    Route::post('notifications', 'VolunteerController@unreadNotification');

    /**
     *  Challenges Routes
     */
    Route::get('volunteer/challenge/create' , 'VolunteerController@createChallenge');
    Route::post('volunteer/challenge' , 'VolunteerController@storeChallenge');
    Route::get('volunteer/challenge/edit' , 'VolunteerController@editChallenge');
    Route::patch('volunteer/challenge/edit' , 'VolunteerController@updateChallenge');

    Route::resource('volunteer','VolunteerController', ['only' => [
        'show'
    ]]);


    /*
    |-----------------------
    | Event Routes
    |-----------------------
    */
    /**
     * Question Routes
     */
    Route::get('event/{id}/question/ask', 'EventController@askQuestion');
    Route::post('event/{id}/question/ask', 'EventController@storeQuestion');
    Route::get('event/{id}/question/answer', 'EventController@viewUnansweredQuestions');
    Route::post('event/{id}/question/{q_id}', 'EventController@answerQuestion');
    Route::get('event/{id}/question/{q_id}', 'EventController@showQuestion');

     /**
     *  Post Routes
     */
    Route::get('/event/{event_id}/post/create','EventController@createPost');
    Route::post('/event/{event_id}/post','EventController@storePost');

    /**
     *	Event Following
     */
    Route::get('event/{id}/follow', 'EventController@follow');
    Route::get('event/{id}/unfollow', 'EventController@unfollow');

    /**
     *	Event Registeration
     */
    Route::get('event/{id}/register', 'EventController@register');
    Route::get('event/{id}/unregister', 'EventController@unregister');
    Route::resource('event','EventController', ['only' => [
         'create','store','show'
    ]]);

    /**
     *  Routes related to the event
     */
    Route::resource('event','EventController', ['only' => [
         'show', 'create', 'edit', 'update'
     ]]);
     /**
      *	Routes related to the Event Review
      */
     Route::resource('event/{id}/review','EventReviewController', ['only' => [
          'index' , 'create' ,'store'
      ]]);

});
