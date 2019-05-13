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

//--------------------------------------Маршруты для пользователя пополнения--------------------------------------------
Route::get('int_success', 'Interkassa\addBalanceController@intSuccess')->name('int_success');
Route::get('int_fail', 'Interkassa\addBalanceController@intFail')->name('int_fail');
Route::get('int_waiting', 'Interkassa\addBalanceController@intWaiting')->name('int_waiting');
Route::match(['get', 'post'], 'interkassa', 'Interkassa\InterkassaController@api')->name('interkassa');

Route::match(['get', 'post'],'wfp_success', 'Wayforpay\WayForPayController@Success')->name('wfp_success');
Route::match(['get', 'post'],'wfp_fail', 'Wayforpay\WayForPayController@Fail')->name('wfp_fail');
Route::match(['get', 'post'], 'wfp_api', 'Wayforpay\WayForPayController@Api')->name('wfp_api');

//Route::match(['get', 'post'], 'callback', 'CallbackController@index')->name('callback');

//----------------------------------------------------------------------------------------------------------------------
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {



        Route::match(['get', 'post'],'/', 'HomeController@index');
        Auth::routes();

        Route::post('hello', function() {
            echo 'hello';
            echo \Config::get('app.private_key');
        });

        Route::any('callback','CallbackController@index')->name('callback');

        //----- Quick login routes --------
        Route::get('newlogin', 'Auth\LoginController@showExtendedLoginForm')->name('newlogin');
        Route::post('newlogin', 'Auth\LoginController@newlogin');
        //------ End of quick login -------
       
        //-------------- Social AUTH 
        Route::get('auth/{provider}', 'Auth\SocialProviderController@redirectToProvider');
        Route::get('auth/{provider}/callback', 'Auth\SocialProviderController@handleProviderCallback');
        
        
        //--------------------------------------------------------------------------------------------------------------
        Route::get('/user/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');

        
        //Route::get('about','Front\About\aboutController@index')->name('about');
        Route::get('faq','HomeController@faq')->name('faq');
        Route::get('rules_service','HomeController@rulesCreateProject')->name('rules_service');
        Route::get('agreement','HomeController@agreement')->name('agreement');
        
        Route::get('contacts','HomeController@contacts')->name('contacts');
        Route::post('contacts','HomeController@contactssend')->name('contactssend');
        
        Route::get('curators','HomeController@curators')->name('curators');
        Route::get('manual','HomeController@manual')->name('manual');
        Route::get('returnmoney','HomeController@returnmoney')->name('returnmoney');
        
        Route::get('about','HomeController@about')->name('about');
        
        
        //-------------------------------------Project------------------------------------------------------------------
        Route::get('projects','Front\Project\projectController@index')->name('projects');
        
        
        Route::get('project/{id}/edit/{step?}', 'Front\Project\projectController@edit')->name('edit_project');

//        Route::get('project/{id}/liqpay_form', 'Front\Project\projectController@liqpay_form')->name('liqpay_form');

        Route::put('project/{id}/update/{step?}', 'Front\Project\projectController@update')->name('update_project');
        
        Route::post('project_search','Front\Project\projectController@search')->name('projectsearch');
        Route::resource('project','Front\Project\projectController');           //Создание проекта пользователем
        
        Route::get('project/{id}/{seo?}', 'Front\Project\projectController@show')->name('show_project');//после ресурса, иначе не работает создание
        
        Route::get('delete_project_video/{video_id}','Front\Project\projectController@deleteVideoProject')
            ->name('delete_project_video');
        

        
        //---------------------------- Мои профиль
        Route::resource('myprofile','User\ProfileController',['only'=>['index','update']]);
        
        //---------------------------- Мои проекты
        Route::resource('myprojects','User\MyProjectController',['only'=>['index','show']]);
        Route::post('myprojects/ajaxorders/{id}','User\MyProjectController@getAjaxOrders')->name('getAjaxOrders');
        Route::post('myprojects/sendorders/{idp}/{ido?}','User\MyProjectController@sendGiftToUser')->name('sendGiftToUser');
        //---------------------------- Обновления к проектам
        Route::resource('projectup','User\UpdateProjectController');

        //--------------------------------------------------------------------------------------------------------------

        //финансовые операции пользователя
        //Route::get('myfinance', 'User\ShowOperationsController@index')->name('myfinance');
        
        Route::post('check_my_balance', 'User\BalanceController@checkBalance')->name('check_my_balance');
        Route::resource('mybalance','User\BalanceController');
        
        //---------------------------- Возврат средств, заявка от пользователя
        Route::resource('refund','User\RefundController');                      
        
        
//        Route::post('support_project/{project_id}','Front\Sponsors\sponsorsController@supportProject')
//            ->name('support_project');
//        Route::post('gift_support_project/{project_id}','Front\Sponsors\sponsorsController@giftSupportProject')
//            ->name('gift_support_project');
        
        Route::post('support_project/create','Front\Sponsors\sponsorsController@postCreate')->name('SC_postCreate');
        Route::get('support_project/{project_id}/order/{order_id}/submit','Front\Sponsors\sponsorsController@submit')->name('SP_submit');

        Route::resource('support_project','Front\Sponsors\sponsorsController');



//        Route::get('withdraw_money','User\personalAreaController@withdrawMoneyApplication')->name('withdraw_money');
//        Route::post('withdraw_money','User\personalAreaController@applicationGetMoney')->name('withdraw_money');

        //----------------------------------Создание проекта------------------------------------------------------------
        //Route::get('new_project','Front\Project\projectController@create')->name('new_project');
        
        //---------------------------------Редактирование проекта ------------------------------------------------------
        //Route::get('edit_project/{id}','Front\Project\projectController@edit')->name('edit_project');
//        Route::post('first_step_edit_project/{id}','Front\Project\projectController@editFirstStep')
//            ->name('first_step_edit_project');
        
        //---------------------Сохранение первого шага создание проекта-------------------------------------------------
//        Route::post('first_step_add_project','Front\Project\projectController@confirmWithRules')
//            ->name('first_step_add_project');
//        //--------------------------------------------------------------------------------------------------------------
//        Route::get('second_form_project/{id}','Front\Project\projectController@secondFormProject')
//            ->name('second_form_project');
//        //---------------------Сохранение второго шага создания проекта-------------------------------------------------
//        Route::post('second_step_project/{id}','Front\Project\projectController@secondStepProject')
//            ->name('second_step_project');
        

        
        //--------------------------------------------------------------------------------------------------------------
//        Route::get('third_form_project/{id}','Front\Project\projectController@thirdFormProject')
//            ->name('third_form_project');
//        //---------------------Сохранение третьего шага проекта---------------------------------------------------------
//        Route::post('third_step_project/{id}','Front\Project\projectController@thirdStepProject')
//            ->name('third_step_project');
        //--------------------------------------------------------------------------------------------------------------
//        Route::get('fourth_form_project/{id}','Front\Project\projectController@fourthFormProject')
//            ->name('fourth_form_project');
//        //---------------------Сохранение четвертого шага проекта-------------------------------------------------------
//        Route::post('profile_info','Front\Project\projectController@addProfileInfoProject')
//            ->name('profile_info');
        //--------------------------------------------------------------------------------------------------------------
//        Route::get('fifth_form_project/{id}','Front\Project\projectController@fifthFormProject')
//            ->name('fifth_form_project');
        
        
        
        Route::post('project_type_req/{id}','Front\Project\requisitiesController@choseTypeReq')
            ->name('project_type_req');
        //--------------------------Юридический тип реквизитов проекта--------------------------------------------------
        Route::post('individual_project_form/{id}','Front\Project\requisitiesController@individualRequisities')
            ->name('individual_project_form');
        //--------------------------------------------------------------------------------------------------------------
        //--------------------------Физический тип реквизитов-----------------------------------------------------------
        Route::post('fop_project_form/{id}','Front\Project\requisitiesController@fopRequisities')
            ->name('fop_project_form');
        //------------------------------ЧП  тип реквизитов--------------------------------------------------------------
        Route::post('entity_project_form/{id}','Front\Project\requisitiesController@entityRequisities')
            ->name('entity_project_form');
        
        
        
        Route::post('/downloadFileReq/{id}','Front\Project\requisitiesController@downloadFileReq')->name('downloadFileReq');
        Route::post('/deleteFileReq/{id}','Front\Project\requisitiesController@deleteFileReq')->name('deleteFileReq');
        
        //--------------------------------------------------------------------------------------------------------------
//        Route::get('sixth_form_project/{id}','Front\Project\projectController@sixthFormProject')
//            ->name('sixth_form_project');
//        
//        Route::get('send_to_moderation/{id}','Front\Project\projectController@sendToModeration')
//            ->name('send_to_moderation');
        
//        Route::post('delete_add_project/{id}','Front\Project\projectController@destroy')
//            ->name('delete_add_project');

        

        
        
        
        //----------------------------------- Подарки проектов
        Route::resource('ugift','Front\Project\giftController');
        Route::post('add_gift/{id}','Front\Project\giftController@addGiftProject')->name('add_gift');
        
        

        
        
        
//        Route::resource('personal_area','User\personalAreaController');
//        
//         Route::get('addition','User\personalAreaController@showAdditionForm')->name('addition');
//        
//        Route::get('sponsored','User\personalAreaController@showSponsored')->name('sponsored');
//        // ---------------------- Route for User------------------------------------------------------------------------
//        Route::get('settings_profile','User\personalAreaController@edit')->name('settings_profile');
//        Route::post('update_setting_profile','User\personalAreaController@updateSettingProfile')
//            ->name('update_setting_profile');
//        Route::post('add_social_info','User\personalAreaController@addSocialInfo')->name('add_social_info');
//        Route::post('change_password','User\personalAreaController@changePassword')->name('change_password');
//        Route::post('change_email','User\personalAreaController@changeEmail')->name('change_email');

        
        
//        Route::get('sort_new_project','Front\Project\projectController@sortNewProjects')->name('sort_new_project');
//        Route::get('sort_by_name','Front\Project\projectController@sortByNameProjects')->name('sort_by_name');
//        Route::get('sort_by_popular','Front\Project\projectController@sortByPopularProjects')->name('sort_by_popular');
        
        //----------------------------------- Комментарии к проектам
        Route::resource('comment', 'CommentController', ['only' => ['store','destroy']]);
        
        
        
        
        
        
        
        
        
        
        //--------------------------------------------------------------------------------------------------------------
        Route::prefix('admin')->group(function () {
            Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
            Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
            Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
            Route::group(['middleware'=>'route_admin'],function (){
                
                Route::get('/', 'AdminController@index')->name('admin.dashboard');
                
                Route::resource('admins','Admin\adminsController');
                
                Route::resource('users','Admin\Users\usersController');
                
                Route::resource('proposal','Admin\ApplicationUser\applicationController');
                
                Route::resource('catgories_project','Admin\Categories\categoriesProjectController'); //категории проектов
                
                Route::resource('status_projects','Admin\Categories\statusProjectController'); //статусы проектов

                Route::resource('cities','Admin\Settings\CityController');      // Города
                
                Route::resource('paymethods','Admin\Settings\PayMethod');  // Платёжные методы, доступные пользователям
                
                Route::resource('balance_type','Admin\Settings\BalanceType');   // Типы операций по балансу
                
                Route::resource('balance_status','Admin\Settings\BalanceStatus');// Типы статусов по операциям баланса
                
                Route::resource('balance','Admin\Balance\BalanceController');   // Операции по балансу

                Route::resource('a_s_page','Admin\Pages\StaticPageController');   // Статические страницы
                
                
                
                //----------------------------------- Администрирование проектов
                Route::resource('a_allprojects', 'Admin\Project\AllProjectsController'); //Список всех проектов
                
                Route::get('a_mod_user_project/{id}', 'Admin\Project\ModProjectsController@inUserProject')->name('a_mod_user_project');
                Route::resource('a_modprojects', 'Admin\Project\ModProjectsController',['only'=>['index','show','update']]); //Список проектов на модерации
                
                
                //-----Post moderation
                Route::resource('a_postmodprojects', 'Admin\Project\PostProjectsController',['only'=>['index','show','update']]); //Список проектов на модерации
                
                //-----Обновления
                Route::resource('a_updates', 'Admin\Project\updatesProjectController',['only'=>['index','show','update']]);//управление обновлениями к проекту
                
                //-----Возвраты-Выплаты
                Route::resource('a_refund','Admin\Users\refundController',['only'=>['index','show','update']]); //управление заявками пользователя
                
                Route::resource('admin_project','Admin\Project\projectController');
                
                Route::get('mod_new_project','Admin\Project\projectController@newProject')->name('mod_new_project');
                Route::get('change_mode_status/{status}/{id}','Admin\Project\projectController@changeModeStatus')
                    ->name('change_mode_status');
                //---------------------Редактирование проекта шаг первый------------------------------------------------
                Route::get('delete_poster_link/{id}','Admin\Project\projectController@deletePoster')
                    ->name('delete_poster_link');
                Route::post('update_project_one/{id}','Admin\Project\projectController@updateInfoProjectOne')
                    ->name('update_project_one');
                //------------------------------------------------------------------------------------------------------
                //---------------------Удаления фото реквизитов проекта-------------------------------------------------
                Route::get('delete_requisities_image/{id}','Admin\Project\requisitesController@deleteRequisitImage')
                    ->name('delete_requisities_image');
                //------------------------------------------------------------------------------------------------------
                //---------------------Обновления реквизитов проекта----------------------------------------------------
                Route::post('edit_individual_requisites_pr/{id}','Admin\Project\requisitesController@editIndividualReq')
                    ->name('edit_individual_requisites_pr');
                Route::post('edit_fop_requisites_pr{id}','Admin\Project\requisitesController@editFopReq')
                    ->name('edit_fop_requisites_pr');
                Route::post('edit_entity_requisites_pr/{id}','Admin\Project\requisitesController@editEntityReq')
                    ->name('edit_entity_requisites_pr');
                //------------------------------------------------------------------------------------------------------
                //-----------------------Редактирование подарка проекта-------------------------------------------------
                Route::post('edit_gift_project/{id}','Admin\Project\giftController@editGiftProject')
                    ->name('edit_gift_project');

                Route::post('upload_img_gift/{id}','Admin\Project\giftController@uploadImageGift')
                    ->name('upload_img_gift');
                Route::get('delete_image/{id}','Admin\Project\giftController@deleteImage')
                    ->name('delete_image');
                //------------------------------------------------------------------------------------------------------
                //Route::resource('additions_users','Admin\Statistics\additionUserController');
                Route::resource('sponsored_statistics','Admin\Statistics\sponsoredStatisticsController');
                Route::resource('sponsors','Admin\Statistics\sponsorsController');
            });
        });
        
        
        Route::get('{slug}','PagesController@show')->name('show_static_page');
    });
