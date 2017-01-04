<?php

/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends BaseController
{

    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'));
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {

        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

        if ($user->id) {

            Mail::send(
                Config::get('confide::email_account_confirmation'),
                compact('user'),
                function($message) use ($user){
                    $message
                        ->to($user->email, $user->username)
                        ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                }
            );


            $rout=$this->getRoute(Input::get('user_type'));
            return Redirect::action($rout.'Controller@index')
                ->with('notice', Lang::get('confide::confide.alerts.account_created'));
        } else {
            $error = $user->errors()->all(':message');
            Session::flash('message', $error);
            Session::flash('alert-class', 'alert-danger');

            $rout=$this->getRoute(Input::get('user_type'));
            return Redirect::action($rout.'Controller@create')
                ->withInput(Input::except('password'));
             
        }
    }


    private function getRoute($user){

      
        switch ($user) {
            case 'adminrole':
                return 'AdminUsers';
                break;
            case 'centerrole':
                return 'CenterUsers';
                break;
            default:
                return 'NormalUsers';
                break;
        }

    }



    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            return View::make(Config::get('confide::login_form'));
        }
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        $user_type=Input::get('u_t');
        $match=true;


        if ($repo->login($input)) {
           
           if(Confide::user()->blocked==1){ 

                Confide::logout();
                Session::flash('message', 'Your account has been blocked.');
                Session::flash('alert-class', 'alert-danger');  
                return Redirect::action('UsersController@login');
            }
           
            switch ($user_type) {
                case 'admin':
                    if(!Entrust::hasRole('Admin')){
                        $match=false;
                    }
                break;
                case 'center':
                     if(!Entrust::hasRole('Center_User')){
                        $match=false;
                    }

                break;

                case 'normal':
                   
                     if(!Entrust::hasRole('Normal_User')){
                        $match=false;
                    }

                break;
                default:
                    
                    break;
            }


            if(!$match){

                Confide::logout();
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
                Session::flash('message', $err_msg);
                Session::flash('alert-class', 'alert-danger');

                return Redirect::action('UsersController@login')
                    ->withInput(Input::except('password'));
            }

            return Redirect::intended('/');

        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            Session::flash('message', $err_msg);
            Session::flash('alert-class', 'alert-danger');

            return Redirect::action('UsersController@login')
                ->withInput(Input::except('password'));
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            Session::flash('message', $notice_msg);
            Session::flash('alert-class', 'alert-success');
            return Redirect::action('UsersController@login');
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            Session::flash('message', $error_msg);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::action('UsersController@login');
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            Session::flash('message', $notice_msg);
            Session::flash('alert-class', 'alert-success');
            return Redirect::action('UsersController@login');

        } else {

            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            Session::flash('message', $error_msg);
            Session::flash('alert-class', 'alert-danger');
            return Redirect::action('UsersController@login');
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            Session::flash('message', $error_msg);
            Session::flash('alert-class', 'alert-danger');

            return Redirect::action('UsersController@resetPassword', array('token'=>$input['token']))
                ->withInput();
        }
    }

    public function settings()
    {
        return View::make('layouts.user.settings');
    }

    public function doSettings()
    {
        $repo = App::make('UserRepository');
        $input = array(

            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
            'start_date' =>Input::get('start_date'),
            'end_date' =>Input::get('end_date')
        );

        $uname=Confide::user()->username;
        // By passing an array with the token, password and confirmation
        if ($repo->settings_password($uname,$input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');

            Session::flash('message', $notice_msg);
            Session::flash('alert-class', 'alert-success');

            return Redirect::to('/users/settings');
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            Session::flash('message', $error_msg);
            Session::flash('alert-class', 'alert-danger');

            return Redirect::to('/users/settings');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }


    public function block_unblock($id,$route){
 
        if(!Entrust::hasRole('Admin')){
            return;
        }

        $user=User::find($id);

        if($user->blocked==1){$user->blocked=0;Session::flash('message', 'Account has been unblocked');Session::flash('alert-class', 'alert-success');}
        else{ $user->blocked=1;Session::flash('message', 'Account has been blocked');Session::flash('alert-class', 'alert-danger');}
        $user->save();
        return Redirect::to($route);
    }

}