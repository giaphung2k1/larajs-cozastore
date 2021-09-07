<?php
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => 'optimizeImages'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('/language/{language}', 'LaraJSController@setLanguage');
Route::post('/logging', 'LaraJSController@logging');
// Send reset password mail
Route::post('/forgot-password', 'AuthController@forgotPassword');
// Handle reset password form process
Route::post('/reset-password', 'AuthController@resetPassword');
// START - Auth
Route::post('/fe-login', 'AuthController@feLogin');
Route::post('/refresh-token', 'AuthController@refreshToken');
Route::post('/login', 'AuthController@login');
// END - Auth
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/fe-logout', 'AuthController@feLogout');
    Route::get('/user-info', 'UserController@userInfo');
    Route::get('/logout', 'AuthController@logout');
    Route::group(['middleware' => 'verify_request'], function () {});
    // permission manage permission
    Route::group(
        [
            'middleware' => 'permission:' . \ACL::PERMISSION_PERMISSION_MANAGE,
        ],
        function () {
            Route::apiResource('roles', 'RoleController');
            Route::apiResource('permissions', 'PermissionController');
        }
    );
    // role Admin (Super admin)
    Route::group(['middleware' => 'role:' . \ACL::ROLE_ADMIN], function () {
        Route::group(['prefix' => 'generators'], function () {
            Route::get('check-model', 'GeneratorController@checkModel');
            Route::get('check-column', 'GeneratorController@checkColumn');
            Route::get('get-models', 'GeneratorController@getModels');
            Route::get('get-all-models', 'GeneratorController@getAllModels');
            Route::get('get-columns', 'GeneratorController@getColumns');
            Route::post('relationship', 'GeneratorController@generateRelationship');
            Route::get('diagram', 'GeneratorController@generateDiagram');
        });
        Route::apiResource('generators', 'GeneratorController');
        Route::apiResource('users', 'UserController');
        //{{ROUTE_ADMIN_NOT_DELETE_THIS_LINE}}
    });

    /*<==> Category Route - 2021-08-17 10:51:26 <==>*/
    Route::get('/categories/get-categories', 'CategoryController@getCategory');
            Route::apiResource('categories', 'CategoryController');
    /*<==> Product Route - 2021-08-17 12:13:07 <==>*/
    Route::get('/products/get-products', 'ProductController@getProduct');
    Route::get('/products/{id}/detail', 'ProductController@detail');
            Route::apiResource('products', 'ProductController');
    /*<==> Color Route - 2021-08-17 12:23:52 <==>*/
    Route::get('/colors/get-colors', 'ColorController@getColor');
            Route::apiResource('colors', 'ColorController');
    /*<==> Size Route - 2021-08-17 12:25:08 <==>*/
    Route::get('/sizes/get-sizes', 'SizeController@getSize');
            Route::apiResource('sizes', 'SizeController');
    /*<==> ProductPayment Route - 2021-08-17 12:27:50 <==>*/
    Route::get('product-payments/chart/', 'ProductPaymentController@chart');
    Route::delete('product-payments/{product_payment}/rollback', 'ProductPaymentController@rollback');
    Route::get('product-payments/export/excel', 'ProductPaymentController@exportExcel');
    Route::get('product-payments/total/sold', 'ProductPaymentController@totalSold');
    Route::apiResource('product-payments', 'ProductPaymentController');
    
    /*<==> ProductReject Route - 2021-08-17 12:31:00 <==>*/
    Route::apiResource('product-rejects', 'ProductRejectController');
    /*<==> Member Route - 2021-08-17 12:35:43 <==>*/
    Route::get('/members/get-members', 'MemberController@getMember');
    Route::get('/members/search', 'MemberController@search');
            Route::apiResource('members', 'MemberController');
    Route::get('/product-details/get-product-details', 'ProductDetailController@getProductDetail');
            Route::apiResource('product-details', 'ProductDetailController');
    
   
});

Route::fallback(function () {
    return response()->json(
        [
            'message' => trans('error.404'),
        ],
        404
    );
});
