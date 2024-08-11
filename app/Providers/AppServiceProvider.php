<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public $generalSetting;
    public $socialSetting;

    public function register()
    {

        if(file_exists(storage_path('installed'))){
            if (Schema::hasTable('general_settings')) {
                $siteInfo = DB::table('general_settings')->first();
            }
            if (Schema::hasTable('category')) {
                $category = DB::table('category')->select(['category.*',DB::raw("count(property.ads_id) as count")])
                            ->leftJoin('property','property.category','=','category.id')
                            ->where('category.status','1')
                            ->groupBy('category.id')
                            ->get();
            }
            if (Schema::hasTable('pages')) {
                $head_pages = DB::table('pages')->where('show_in_header','=','1')->where('status','1')->get();
                $foot_pages = DB::table('pages')->where('show_in_footer','=','1')->where('status','1')->get();
            }
            if (Schema::hasTable('social-setting')) {
                $social = DB::table('social-setting')->get();
            }
            // if (Schema::hasTable('pages')) {
            //     $pages = DB::table('pages')->select(['title','slug'])->where('status','1')->get();
            // }

            view()->share(['siteInfo'=> $siteInfo,'social_settings'=>$social,'cat_list'=>$category,'head_pages'=>$head_pages,'foot_pages'=>$foot_pages]);
        } 
       
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // $this->generalSetting = DB::table('general_settings')->select('com_logo')->get();
        // $this->generalSetting = DB::table('general_settings')->get();
        // // $this->SocialSetting = DB::table('social-setting')->get();
       
        // view()->composer('public/layout/footer', function($view) {
        //     $view->with(['logo' => $this->generalSetting]);
        // });
        
    }
}
