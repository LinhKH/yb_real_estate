<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Yb_AdminController;
use App\Http\Controllers\Yb_UserController;
use App\Http\Controllers\Yb_PropertyController;
use App\Http\Controllers\Yb_PagesController;
use App\Http\Controllers\Yb_FacilityController;
use App\Http\Controllers\Yb_PackageController;
use App\Http\Controllers\Yb_PurposeController;
use App\Http\Controllers\Yb_CategoryController;
use App\Http\Controllers\Yb_DistanceController;
use App\Http\Controllers\Yb_CountryController;
use App\Http\Controllers\Yb_StateController;
use App\Http\Controllers\Yb_CityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Yb_HomeController;

// Route::get('/', function () {
//     return view('welcome');
// });
 Route::group(['middleware'=>'installed'], function(){
   
   Route::group(['middleware'=>['protectedPage']],function(){
      
      Route::any('/admin',[Yb_AdminController::class,'yb_index']);
      // Route::post('/admin',[Yb_AdminController::class,'yb_index']);
      Route::get('admin/logout',[Yb_AdminController::class,'yb_logout']); 

      Route::get('admin/dashboard',[Yb_AdminController::class,'yb_dashboard']);

      Route::resource('admin/users',Yb_UserController::class);
      Route::resource('admin/properties',Yb_PropertyController::class);
      Route::resource('admin/pages',Yb_PagesController::class);
      Route::resource('admin/facilities',Yb_FacilityController::class);
      Route::resource('admin/packages',Yb_PackageController::class);
      Route::resource('admin/purpose',Yb_PurposeController::class);
      Route::resource('admin/category',Yb_CategoryController::class);
      Route::resource('admin/area',Yb_AreaController::class);
      Route::resource('admin/distance',Yb_DistanceController::class);
      Route::resource('admin/country',Yb_CountryController::class);
      Route::resource('admin/states',Yb_StateController::class);
      Route::resource('admin/city',Yb_CityController::class);

      Route::post('admin/userChange_status',[Yb_UserController::class,'yb_changeStatus']);
      Route::post('admin/page_showIn_header',[Yb_PagesController::class,'yb_show_in_header']);
      Route::post('admin/page_showIn_footer',[Yb_PagesController::class,'yb_show_in_footer']);
   
      Route::any('admin/general-settings',[SettingController::class,'yb_general_settings']);
      Route::any('admin/banner-settings',[SettingController::class,'yb_banner_settings']);
   
      Route::any('admin/profile-settings',[SettingController::class,'yb_profile_settings']);
      Route::post('admin/profile/change-password',[SettingController::class,'yb_change_password']); 
   
      Route::any('admin/social-settings',[SettingController::class,'yb_social_settings']);
   
      Route::get('admin/contact',[SettingController::class,'yb_contact']); 
      Route::post('admin/contact/{id}',[SettingController::class,'yb_Contactview']);
   
   });


   Route::get('/',[Yb_HomeController::class,'index']);
   Route::any('/all-listing',[Yb_HomeController::class,'yb_all_listing']);

   Route::get('/user-listing/{text}',[Yb_UserController::class,'yb_user_listing']);
   // Route::get('load-listing',[Yb_HomeController::class,'load_listing_home']);
   Route::get('category/{slug}',[Yb_HomeController::class,'yb_category_listing']);

   Route::any('login',[Yb_UserController::class,'yb_login']);
   Route::any('logout',[Yb_UserController::class,'yb_logout']);

   Route::any('signup',[Yb_UserController::class,'yb_signup']);

   Route::get('create',[Yb_HomeController::class,'yb_create']);
   Route::post('create',[Yb_PropertyController::class,'store']);
   Route::get('property/edit/{id}',[Yb_HomeController::class,'yb_edit']);
   Route::post('property/update/{id}',[Yb_PropertyController::class,'update']);
   Route::post('property/change-status/{id}',[Yb_PropertyController::class,'yb_change_status_byUser']);

   // Route::post('signup',[Yb_UserController::class,'store']);

   Route::get('my-profile',[Yb_UserController::class,'yb_profile']);
   Route::post('update-user-profile',[Yb_UserController::class,'update']);
   Route::get('my-listing',[Yb_UserController::class,'yb_my_listing']);
   Route::any('my-listing/{id}/featured',[Yb_PropertyController::class,'yb_make_featured']);
   
   Route::post('add-user-favourite',[Yb_UserController::class,'yb_Insertfavourite']);
   Route::get('my-favourites',[Yb_UserController::class,'yb_myfavourite']);
   Route::get('property/single/{slug}',[Yb_HomeController::class,'yb_singlePage']);
   
   Route::get('contact',[Yb_HomeController::class,'yb_contact']);
   Route::post('contact',[Yb_HomeController::class,'yb_contactStore']);
   Route::get('search',[Yb_HomeController::class,'yb_search']);
   Route::post('search-filter',[Yb_HomeController::class,'yb_search_filter']);
   // Route::post('search',[Yb_HomeController::class,'yb_search']);
   

   Route::any('get-locations',[Yb_HomeController::class,'yb_get_locations']);


   Route::post('get-country-states',[Yb_PropertyController::class,'yb_get_country_states']);
   Route::post('get-state-city',[Yb_PropertyController::class,'yb_get_state_city']);

   Route::get('{text}',[Yb_HomeController::class,'yb_single_pages']);
});