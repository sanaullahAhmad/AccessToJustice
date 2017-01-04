<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',function()
{
   
    if(Auth::check()){

        return Redirect::to('dashboard');
    }

	return View::make('home');
});


Route::get('centeriec',['before'=>'check_login','uses'=>'CenterIecController@index']);
Route::get('dashboard',['before'=>'check_login','uses'=>'DashboardController@index']);

Route::post('meeting/download_excel',['before'=>'check_login','as'=>'meeting.download_excel', 'uses'=>'MeetingController@download_excel']);
Route::group(['before' => 'check_login'], function(){ Route::resource('meeting', 'MeetingController');

Route::get('download',function(){

    return downloadfile(Input::get('filename'));
});


});


Route::get('outgoing/pre_index',['before'=>'check_login|redirect_prei','as'=>'outgoing.pre_index', 'uses'=>'OutgoingCallsController@pre_index']);

Route::get('outgoing/center/{slug?}',['before'=>'check_login|redirect_prei','as'=>'outgoing.center', 'uses'=>'OutgoingCallsController@center']);

Route::get('calendar',['before'=>'check_login','as'=>'event.calendar', 'uses'=>'EventsController@calendar']);
Route::get('events_alert',['before'=>'check_login','as'=>'event.events_alert', 'uses'=>'EventsController@events_alert']);


Route::post('outgoing/excel',['before'=>'check_login','as'=>'outgoing.excel', 'uses'=>'OutgoingCallsController@excel']);
Route::post('outgoing/download_excel',['before'=>'check_login','as'=>'outgoing.download_excel', 'uses'=>'OutgoingCallsController@download_excel']);
Route::get('outgoing/center_ajaxi/{slug?}',['before'=>'check_login|redirect_prei','as'=>'outgoing.center_ajaxi', 'uses'=>'OutgoingCallsController@center_ajaxi']);
Route::get('outgoing/center_ajax/{slug?}',['before'=>'check_login|redirect_prei','as'=>'outgoing.center_ajax', 'uses'=>'OutgoingCallsController@center_ajax']);
Route::post('outgoing/download_pdf',['before'=>'check_login','as'=>'outgoing.download_pdf', 'uses'=>'OutgoingCallsController@download_pdf']);
Route::post('outgoing/download_report_pdf',['before'=>'check_login','as'=>'outgoing.download_report_pdf', 'uses'=>'OutgoingCallsController@download_report_pdf']);
Route::get('outgoing/ajax',['before'=>'check_login','as'=>'outgoing.ajax', 'uses'=>'OutgoingCallsController@ajax']);
Route::get('outgoing/ajaxi',['before'=>'check_login','as'=>'outgoing.ajaxi', 'uses'=>'OutgoingCallsController@ajaxi']);
Route::group(['before' => 'check_login'], function(){ Route::resource('outgoing', 'OutgoingCallsController');});

Route::get('incoming/pre_index',['before'=>'check_login|redirect_prei','as'=>'incoming.pre_index', 'uses'=>'IncomingCallsController@pre_index']);
Route::get('incoming/center/{slug?}',['before'=>'check_login|redirect_prei','as'=>'incoming.center', 'uses'=>'IncomingCallsController@center']);
Route::get('incoming/center_ajaxi/{slug?}',['before'=>'check_login|redirect_prei','as'=>'incoming.center_ajaxi', 'uses'=>'IncomingCallsController@center_ajaxi']);
Route::get('incoming/center_ajax/{slug?}',['before'=>'check_login|redirect_prei','as'=>'incoming.center_ajax', 'uses'=>'IncomingCallsController@center_ajax']);
Route::post('incoming/excel',['before'=>'check_login','as'=>'incoming.excel', 'uses'=>'IncomingCallsController@excel']);
Route::post('incoming/download_excel',['before'=>'check_login','as'=>'incoming.download_excel', 'uses'=>'IncomingCallsController@download_excel']);
Route::post('incoming/download_pdf',['before'=>'check_login','as'=>'incoming.download_pdf', 'uses'=>'IncomingCallsController@download_pdf']);
Route::post('incoming/download_report_pdf',['before'=>'check_login','as'=>'incoming.download_report_pdf', 'uses'=>'IncomingCallsController@download_report_pdf']);
Route::get('incoming/ajax',['before'=>'check_login','as'=>'incoming.ajax', 'uses'=>'IncomingCallsController@ajax']);
Route::get('incoming/ajaxi',['before'=>'check_login','as'=>'incoming.ajaxi', 'uses'=>'IncomingCallsController@ajaxi']);
Route::group(['before' => 'check_login'], function(){ Route::resource('incoming', 'IncomingCallsController');});

Route::get('legalassistance/pre_index',['before'=>'check_login|redirect_prei','as'=>'legalassistance.pre_index', 'uses'=>'LegalAssistanceController@pre_index']);
Route::get('legalassistance/center/{slug?}',['before'=>'check_login|redirect_prei','as'=>'legalassistance.center', 'uses'=>'LegalAssistanceController@center']);
Route::get('legalassistance/center_ajaxi/{slug?}',['before'=>'check_login|redirect_prei','as'=>'legalassistance.center_ajaxi', 'uses'=>'LegalAssistanceController@center_ajaxi']);
Route::get('legalassistance/center_ajax/{slug?}',['before'=>'check_login|redirect_prei','as'=>'legalassistance.center_ajax', 'uses'=>'LegalAssistanceController@center_ajax']);
Route::post('legalassistance/excel',['before'=>'check_login','as'=>'legalassistance.excel', 'uses'=>'LegalAssistanceController@excel']);
Route::post('legalassistance/download_excel',['before'=>'check_login','as'=>'legalassistance.download_excel', 'uses'=>'LegalAssistanceController@download_excel']);
Route::post('legalassistance/download_pdf',['before'=>'check_login','as'=>'legalassistance.download_pdf', 'uses'=>'LegalAssistanceController@download_pdf']);
Route::post('legalassistance/download_report_pdf',['before'=>'check_login','as'=>'legalassistance.download_report_pdf', 'uses'=>'LegalAssistanceController@download_report_pdf']);
Route::get('legalassistance/ajax',['before'=>'check_login','as'=>'legalassistance.ajax', 'uses'=>'LegalAssistanceController@ajax']);
Route::get('legalassistance/ajaxi',['before'=>'check_login','as'=>'legalassistance.ajaxi', 'uses'=>'LegalAssistanceController@ajaxi']);
Route::group(['before' => 'check_login'], function(){ Route::resource('legalassistance', 'LegalAssistanceController');});


Route::get('sycop/pre_index',['before'=>'check_login|redirect_prei','as'=>'sycop.pre_index', 'uses'=>'SycopCallsController@pre_index']);
Route::get('sycop/center/{slug?}',['before'=>'check_login|redirect_prei','as'=>'sycop.center', 'uses'=>'SycopCallsController@center']);
Route::get('sycop/center_ajaxi/{slug?}',['before'=>'check_login|redirect_prei','as'=>'sycop.center_ajaxi', 'uses'=>'SycopCallsController@center_ajaxi']);
Route::get('sycop/center_ajax/{slug?}',['before'=>'check_login|redirect_prei','as'=>'sycop.center_ajax', 'uses'=>'SycopCallsController@center_ajax']);
Route::post('sycop/excel',['before'=>'check_login','as'=>'sycop.excel', 'uses'=>'SycopCallsController@excel']);
Route::post('sycop/download_excel',['before'=>'check_login','as'=>'sycop.download_excel', 'uses'=>'SycopCallsController@download_excel']);
Route::post('sycop/download_pdf',['before'=>'check_login','as'=>'sycop.download_pdf', 'uses'=>'SycopCallsController@download_pdf']);
Route::post('sycop/download_report_pdf',['before'=>'check_login','as'=>'sycop.download_report_pdf', 'uses'=>'SycopCallsController@download_report_pdf']);
Route::get('sycop/ajax',['before'=>'check_login','as'=>'sycop.ajax', 'uses'=>'SycopCallsController@ajax']);
Route::get('sycop/ajaxi',['before'=>'check_login','as'=>'sycop.ajaxi', 'uses'=>'SycopCallsController@ajaxi']);
Route::group(['before' => 'check_login'], function(){ Route::resource('sycop', 'SycopCallsController');});


Route::get('walkin/pre_index',['before'=>'check_login|redirect_prei','as'=>'walkin.pre_index', 'uses'=>'WalkinsController@pre_index']);
Route::get('walkin/center/{slug?}',['before'=>'check_login|redirect_prei','as'=>'walkin.center', 'uses'=>'WalkinsController@center']);
Route::get('walkin/center_ajaxi/{slug?}',['before'=>'check_login|redirect_prei','as'=>'walkin.center_ajaxi', 'uses'=>'WalkinsController@center_ajaxi']);
Route::get('walkin/center_ajax/{slug?}',['before'=>'check_login|redirect_prei','as'=>'walkin.center_ajax', 'uses'=>'WalkinsController@center_ajax']);

Route::post('walkin/multiple_delet',['before'=>'check_login','as'=>'walkin.multiple_delet', 'uses'=>'WalkinsController@multiple_delet']);
Route::post('walkin/excel',['before'=>'check_login','as'=>'walkin.excel', 'uses'=>'WalkinsController@excel']);
Route::post('walkin/download_excel',['before'=>'check_login','as'=>'walkin.download_excel', 'uses'=>'WalkinsController@download_excel']);
Route::post('walkin/download_pdf',['before'=>'check_login','as'=>'walkin.download_pdf', 'uses'=>'WalkinsController@download_pdf']);
Route::post('walkin/download_report_pdf',['before'=>'check_login','as'=>'walkin.download_report_pdf', 'uses'=>'WalkinsController@download_report_pdf']);
Route::get('walkin/ajax',['before'=>'check_login','as'=>'walkin.ajax', 'uses'=>'WalkinsController@ajax']);
Route::get('walkin/ajaxi',['before'=>'check_login','as'=>'walkin.ajaxi', 'uses'=>'WalkinsController@ajaxi']);
Route::group(['before' => 'check_login'], function(){ Route::resource('walkin', 'WalkinsController');});

Route::get('legalaid/pre_index',['before'=>'check_login|redirect_prei','as'=>'legalaid.pre_index', 'uses'=>'LegalAidsController@pre_index']);
Route::get('legalaid/center/{slug?}',['before'=>'check_login|redirect_prei','as'=>'legalaid.center', 'uses'=>'LegalAidsController@center']);
Route::get('legalaid/center_ajaxi/{slug?}',['before'=>'check_login|redirect_prei','as'=>'legalaid.center_ajaxi', 'uses'=>'LegalAidsController@center_ajaxi']);
Route::get('legalaid/center_ajax/{slug?}',['before'=>'check_login|redirect_prei','as'=>'legalaid.center_ajax', 'uses'=>'LegalAidsController@center_ajax']);
Route::post('legalaid/excel',['before'=>'check_login','as'=>'legalaid.excel', 'uses'=>'LegalAidsController@excel']);
Route::post('legalaid/download_excel',['before'=>'check_login','as'=>'legalaid.download_excel', 'uses'=>'LegalAidsController@download_excel']);
Route::post('legalaid/download_pdf',['before'=>'check_login','as'=>'legalaid.download_pdf', 'uses'=>'LegalAidsController@download_pdf']);
Route::post('legalaid/download_report_pdf',['before'=>'check_login','as'=>'legalaid.download_report_pdf', 'uses'=>'LegalAidsController@download_report_pdf']);
Route::get('legalaid/ajax',['before'=>'check_login','as'=>'legalaid.ajax', 'uses'=>'LegalAidsController@ajax']);
Route::get('legalaid/ajaxi',['before'=>'check_login','as'=>'legalaid.ajaxi', 'uses'=>'LegalAidsController@ajaxi']);
Route::group(['before' => 'check_login'], function(){ Route::resource('legalaid', 'LegalAidsController');});



Route::get('cases/pre_index',['before'=>'check_login|redirect_prei','as'=>'cases.pre_index', 'uses'=>'CasesController@pre_index']);
Route::get('cases/center/{slug?}',['before'=>'check_login|redirect_prei','as'=>'cases.center', 'uses'=>'CasesController@center']);
Route::get('cases/center_ajaxi/{slug?}',['before'=>'check_login|redirect_prei','as'=>'cases.center_ajaxi', 'uses'=>'CasesController@center_ajaxi']);
Route::get('cases/center_ajax/{slug?}',['before'=>'check_login|redirect_prei','as'=>'cases.center_ajax', 'uses'=>'CasesController@center_ajax']);
Route::post('cases/excel',['before'=>'check_login','as'=>'cases.excel', 'uses'=>'CasesController@excel']);
Route::post('cases/download_excel',['before'=>'check_login','as'=>'cases.download_excel', 'uses'=>'CasesController@download_excel']);
Route::post('cases/download_pdf',['before'=>'check_login','as'=>'cases.download_pdf', 'uses'=>'CasesController@download_pdf']);
Route::post('cases/download_report_pdf',['before'=>'check_login','as'=>'cases.download_report_pdf', 'uses'=>'CasesController@download_report_pdf']);
Route::get('cases/ajax',['before'=>'check_login','as'=>'cases.ajax', 'uses'=>'CasesController@ajax']);
Route::get('cases/ajaxi',['before'=>'check_login','as'=>'cases.ajaxi', 'uses'=>'CasesController@ajaxi']);
Route::group(['before' => 'check_login'], function(){ Route::resource('cases', 'CasesController');});

Route::get('daterange',['before'=>'check_login','as'=>'daterange.edit', 'uses'=>'ProjectDateController@edit']);
Route::put('daterange/{id?}',['before'=>'check_login','as'=>'daterange.update', 'uses'=>'ProjectDateController@update']);


Route::group(['before' => 'check_login'], function(){ Route::resource('rightbased', 'RightBasedOrgController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('districtbar', 'DistrictBarController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('ppersonality', 'PoliticalPersonalityController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('govdeps', 'GoveronmentDepartmentController');});


Route::group(['before' => 'check_login'], function(){ Route::resource('callnature', 'CallNaturesController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('callpurpose', 'CallPurposesController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('heardabout', 'HeardAboutController');});

Route::group(['before' => 'check_login'], function(){ Route::resource('event', 'EventsController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('eventscategories', 'EventsCategoriesController');});

Route::group(['before' => 'check_login'], function(){ Route::resource('casenature', 'CaseNaturesController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('defaultemail', 'DefaultEmailsController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('defaultnumber', 'DefaultNumbersController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('center', 'CentersController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('district', 'DistrictsController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('minority', 'MinorityGroupsController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('partner', 'PartnersController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('lawyer', 'LawyersController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('staff', 'CenterStaffController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('supportorg', 'SupportOrganizationsController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('priority', 'PriorityGroupsController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('problem', 'ProblemNaturesController');});
Route::group(['before' => 'check_login'], function(){ Route::resource('adminusers', 'AdminUsersController',['only'=>array('index','create','destroy')]);});
Route::group(['before' => 'check_login'], function(){ Route::resource('centerusers', 'CenterUsersController',['only'=>array('index','create','destroy')]);});
Route::group(['before' => 'check_login'], function(){ Route::resource('normalusers', 'NormalUsersController',['only'=>array('index','create','destroy')]);});


Route::get('iec/download_file', ['before'=>'check_login','as'=>'iec.download_file', 'uses'=>'IecController@download_file']);
Route::group(['before' => 'check_login'], function(){ Route::resource('iec', 'IecController');});

Route::get('reports/', ['before'=>'check_login','as'=>'reports.general_analysis', 'uses'=>'ReportsController@generalAnalysis']);
Route::post('general_ajax', ['before'=>'check_login','as'=>'reports.general_ajax', 'uses'=>'ReportsController@ajax_generalAnalysis']);

Route::group(['before' => 'check_login'], function(){ Route::resource('reports', 'ReportsController');});

//

// Confide routes
Route::get('users/create', ['before'=>'check_login','uses'=>'UsersController@create']);
Route::post('users', ['as'=>'users.store','before'=>'check_login','uses'=>'UsersController@store']);
Route::get('users/login', ['uses'=>'UsersController@login']);
Route::post('users/login',['uses'=> 'UsersController@doLogin']);
Route::get('users/confirm/{code}',['uses'=> 'UsersController@confirm']);
Route::post('users/forgot_password',['uses'=> 'UsersController@doForgotPassword']);
Route::get('users/reset_password/{token}',['uses'=> 'UsersController@resetPassword']);
Route::post('users/reset_password',['uses'=> 'UsersController@doResetPassword']);
Route::get('users/settings',['before'=>'check_login','uses'=> 'UsersController@settings']);
Route::post('users/settings',['before'=>'check_login','uses'=> 'UsersController@doSettings']);
Route::get('users/logout',['before'=>'check_login','uses'=> 'UsersController@logout']);
Route::get('block_unblock/{id}/{route}',['before'=>'check_login','uses'=> 'UsersController@block_unblock']);


Route::get('centers_refer_pre_index',['before'=>'check_login','uses'=> 'AggregateController@refer_centers']);
Route::get('refer_pre_index/{id?}',['before'=>'check_login','uses'=> 'AggregateController@refer']);

Route::get('centers_support_pre_index',['before'=>'check_login','uses'=> 'AggregateController@support_centers']);
Route::get('support_pre_index/{id?}',['before'=>'check_login','uses'=> 'AggregateController@support']);

Route::get('gprptcs',['before'=>'check_login','uses'=> 'GroupReportController@cases']);
Route::get('gprptleg',['before'=>'check_login','uses'=> 'GroupReportController@legal']);

Route::get('213dsde',['before'=>'check_login','uses'=> 'TruncateController@index']);
Route::get('tyfd_okj/{id}',['before'=>'check_login','uses'=> 'TruncateController@truncate']);