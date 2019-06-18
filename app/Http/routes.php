<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'localization', 'prefix' => Session::get('locale')], function() {
    Route::post('/lang', [
        'as' => 'switchLang',
        'uses' => 'LangController@switchLang',
    ]);

    Route::get('/datatableslang','LangController@setTableLang');

    Route::get('index',function(){
        return view('admin.index');
    });

    Route::get('/',function(){
        return Auth::check() ? redirect('admin') : view('auth.login');
    });

    Route::group(['prefix'=>'admin'],function (){

        Route::auth();
        Route::group(['middleware'=>'auth'],function (){
            
            Route::get('/password',['as'=>'user.password.edit','uses'=>'UserController@editPassword']);

            Route::post('/password',['as'=>'user.password.update','uses'=>'UserController@updatePassword']);
        
            //ITEMS ROUTES
            Route::get('/items',['as'=>'admin.items.index','uses'=>'ItemsController@index']);

            Route::get('/items/{id}',['as'=>'admin.items.detail','uses'=>'ItemsController@show']);
            
            Route::post('/update/items/{id}',['as'=>'admin.items.update','uses'=>'ItemsController@update']);

            Route::post('/getlist',['as'=>'admin.getlist','uses'=>'ItemsController@getList']);

            Route::post('update/items',['as'=>'admin.items.bulkupdate','uses'=>'ItemsController@bulkUpdate']);

            Route::patch('/items/{id}/status',['as'=>'admin.items.status','uses'=>'ItemsController@updateStatus']);
            
            //ACCOUNTS ROUTES
            Route::get('/accounts',['as'=>'admin.accounts.index','uses'=>'AccountsController@index']);

            Route::get('/accounts/{id}',['as'=>'admin.accounts.detail','uses'=>'AccountsController@show']);

            Route::post('/getaccountlist',['as'=>'admin.accounts.getlist','uses'=>'AccountsController@getList']);
            
            Route::post('update/accounts',['as'=>'admin.accounts.bulkupdate','uses'=>'AccountsController@bulkUpdate']);

            Route::patch('/accounts/action',['as'=>'admin.accounts.action','uses'=>'AccountsController@updateStatus']);
            
            Route::post('/accounts/getuseritems',['as'=>'admin.accounts.getUserItem','uses'=>'AccountsController@getUserItems']);
        
            Route::post('/changeStatus',['as'=>'admin.account.change','uses'=>'AccountsController@changeStatus']);

            //FEEDBACKS ROUTES
            Route::get('/feedbacks',['as'=>'admin.feedbacks.index','uses'=>'FeedbacksController@index']);

            Route::post('/feedbacks/getlist',['as'=>'admin.feedbacks.getlist','uses'=>'FeedbacksController@getList']);

            Route::post('update/feedbacks',['as'=>'admin.feedbacks.bulkupdate','uses'=>'FeedbacksController@changeStatus']);

            //BRANDS ROUTES
            Route::get('/brands',['as'=>'admin.brands.index','uses'=>'BrandsController@index']);

            Route::post('/brands/getlist',['as'=>'admin.brands.getlist','uses'=>'BrandsController@getList']);

            Route::delete('brand/delete',['as'=>'admin.brands.delete','uses'=>'BrandsController@delete']);

            Route::patch('brand/update',['as'=>'admin.brands.update','uses'=>'BrandsController@update']);

            Route::post('brand/add',['as'=>'admin.brands.add','uses'=>'BrandsController@add']);

            Route::post('brand/status',['as'=>'admin.brands.status','uses'=>'BrandsController@changeStatus']);

            //CHARTS ROUTES
            Route::get('/',['as'=>'admin.charts.dashboard','uses'=>'ChartsController@showDashboard']);

            Route::post('/charts/data',['as'=>'admin.charts.data','uses'=>'ChartsController@getData']);

            Route::get('/charts/statistics',['as'=>'admin.charts.statistics','uses'=>'ChartsController@getStatistics']);
        });
        
    });
});