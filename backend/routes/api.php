<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Auth route start*/
Route::group(['prefix' => 'v1/auth'], function (){

    /*register route start*/
    Route::post('/register', [\App\Http\Controllers\Api\V1\Auth\RegisterController::class, 'register'])->name('register');
    /*register route end*/

    /*login route start*/
    Route::post('/login', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'login']);
    /*login route end*/

    /*forget password route start*/
    Route::post('/forget-password', [\App\Http\Controllers\Api\V1\Auth\ForgetPasswordController::class, 'forgetPassword']);
    /*forget password route end*/

    /*change password route start*/
    Route::post('/change-password', [\App\Http\Controllers\Api\V1\Auth\ChangePasswordController::class, 'changePassword']);
    /*change password route end*/

    Route::group(['middleware' => 'jwtAuth'], function (){

        /*logout route start*/
        Route::post('/logout', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'logout']);
        /*logout route end*/

        /*check token route start*/
        Route::post('checkToken', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'checkToken']);
        /*check token route end*/
    });
});
/* Auth route end*/

/*Admin route start*/
Route::group(['prefix' => 'v1/admin', 'middleware' => 'jwtAuth'], function (){

    /*check permission route start*/
    Route::get('check-permission', [\App\Http\Controllers\CheckPermissionController::class, 'checkPermission']);
    /*check permission route end*/

    /*Dashboard route start*/
    Route::get('/dashboard', [\App\Http\Controllers\Api\V1\Admin\DashboardController::class, 'index']);
    /*Dashboard route end*/

    /*user route start*/
    Route::get('/user', [\App\Http\Controllers\Api\V1\Admin\UserController::class, 'index']);
    Route::post('/user', [\App\Http\Controllers\Api\V1\Admin\UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [\App\Http\Controllers\Api\V1\Admin\UserController::class, 'edit']);
    Route::put('/user/{id}', [\App\Http\Controllers\Api\V1\Admin\UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [\App\Http\Controllers\Api\V1\Admin\UserController::class, 'destroy']);
    /*user route end*/

    /*role route start*/
    Route::get('/role', [\App\Http\Controllers\Api\V1\Admin\RoleController::class, 'index']);
    Route::post('/role', [\App\Http\Controllers\Api\V1\Admin\RoleController::class, 'store']);
    Route::get('/role/{id}', [\App\Http\Controllers\Api\V1\Admin\RoleController::class, 'edit']);
    Route::put('/role/{id}', [\App\Http\Controllers\Api\V1\Admin\RoleController::class, 'update']);
    Route::delete('/role/{id}', [\App\Http\Controllers\Api\V1\Admin\RoleController::class, 'destroy']);
    /*role route end*/

    /*permission route start*/
    Route::get('/permission', [\App\Http\Controllers\Api\V1\Admin\PermissionController::class, 'index']);
    Route::post('/permission', [\App\Http\Controllers\Api\V1\Admin\PermissionController::class, 'store']);
    Route::get('/permission/{id}', [\App\Http\Controllers\Api\V1\Admin\PermissionController::class, 'edit']);
    Route::put('/permission/{id}', [\App\Http\Controllers\Api\V1\Admin\PermissionController::class, 'update']);
    Route::delete('/permission/{id}', [\App\Http\Controllers\Api\V1\Admin\PermissionController::class, 'destroy']);
    /*permission route end*/

    /*leave category route start*/
    Route::get('/leave-category', [\App\Http\Controllers\Api\V1\Admin\LeaveCategoryController::class, 'index']);
    Route::post('/leave-category', [\App\Http\Controllers\Api\V1\Admin\LeaveCategoryController::class, 'store'])->name('leave_category.store');
    Route::get('/leave-category/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveCategoryController::class, 'edit']);
    Route::put('/leave-category/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveCategoryController::class, 'update'])->name('leave_category.update');
    Route::delete('/leave-category/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveCategoryController::class, 'destroy']);
    Route::post('/leave-category/status/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveCategoryController::class, 'changeStatus']);
    /*leave category route end*/

    /*leave route start*/
    Route::get('/leave', [\App\Http\Controllers\Api\V1\Admin\LeaveController::class, 'index']);
    Route::post('/leave', [\App\Http\Controllers\Api\V1\Admin\LeaveController::class, 'store'])->name('leave.store');
    Route::get('/leave/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveController::class, 'edit']);
    Route::put('/leave/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveController::class, 'update'])->name('leave.update');
    Route::delete('/leave/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveController::class, 'destroy']);
    Route::post('/leave/status/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveController::class, 'leaveStatus']);
    /*leave route end*/

    /*leave comment route start*/
    Route::get('/leave-comment', [\App\Http\Controllers\Api\V1\Admin\LeaveCommentController::class, 'index']);
    Route::post('/leave-comment', [\App\Http\Controllers\Api\V1\Admin\LeaveCommentController::class, 'store'])->name('leave_comment.store');
    Route::get('/leave-comment/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveCommentController::class, 'edit']);
    Route::put('/leave-comment/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveCommentController::class, 'update'])->name('leave_comment.update');
    Route::delete('/leave-comment/{id}', [\App\Http\Controllers\Api\V1\Admin\LeaveCommentController::class, 'destroy']);
    /*leave comment route end*/
});
/*Admin route end*/
