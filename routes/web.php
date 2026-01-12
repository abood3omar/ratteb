<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DataBank\CategoryController;
use App\Http\Controllers\DataBank\OccasionTypeController;   
use App\Http\Controllers\DataBank\PackageController;
use App\Http\Controllers\DataBank\ProviderController;
use App\Http\Controllers\DataBank\ServiceController as AdminServiceController;
use App\Http\Controllers\Front\PlannerController as FrontPlannerController;
use App\Http\Controllers\Front\ServiceController as FrontServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\RoleRightsController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SystemModuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPackageController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes                                                          |
|--------------------------------------------------------------------------|
| مسارات للمستخدمين غير المسجلين (تسجيل الدخول والتسجيل)
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])->name('login');       
    Route::post('/login', [SessionController::class, 'store']);                      

    Route::get('/register', [RegisterUserController::class, 'create'])->name('register'); 
    Route::post('/register', [RegisterUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Home Page                                                              |
|--------------------------------------------------------------------------|
*/
Route::get('/home', [HomeController::class, 'index'])->name('home'); 

/*
|--------------------------------------------------------------------------
| Account Management Routes                                              |
|--------------------------------------------------------------------------|
| إدارة الحساب الشخصي (للمستخدم المسجل)
*/
Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('myaccount');        
    Route::put('/update', [UserController::class, 'updateProfile'])->name('update'); 
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password'); 
    Route::delete('/delete', [UserController::class, 'deleteAccount'])->name('delete');
});

/*
|--------------------------------------------------------------------------
| Front End Public Routes                                                |
|--------------------------------------------------------------------------|
| مسارات الواجهة الأمامية (متاحة للجميع)
*/
Route::get('/services', [FrontServiceController::class, 'index'])->name('front.services.index'); 
Route::get('/plan-your-event', [FrontPlannerController::class, 'index'])->name('front.planner.index'); 
Route::get('/plan-your-event/{slug}', [FrontPlannerController::class, 'show'])->name('front.planner.show'); 
Route::get('/packages', [UserPackageController::class, 'index'])->name('front.packages.index'); 
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index'); 

/*
|--------------------------------------------------------------------------
| Front End Authenticated Routes                                         |
|--------------------------------------------------------------------------|
| مسارات تتطلب تسجيل دخول
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout'); 

    Route::get('/services/{id}/book', [FrontServiceController::class, 'showBookingPage'])->name('front.services.book');
    Route::post('/services/{id}/book', [FrontServiceController::class, 'storeBooking'])->name('front.services.store');

    Route::post('/plan-your-event/save', [FrontPlannerController::class, 'store'])->name('front.planner.store');

    Route::get('/packages/{id}/book', [UserPackageController::class, 'showBookingPage'])->name('front.packages.book');
    Route::post('/packages/{id}/book', [UserPackageController::class, 'storeBooking'])->name('front.packages.store');

    Route::get('/my-bookings', [BookingController::class, 'index'])->name('components.front.bookings.index'); 
    Route::post('/bookings/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');    

    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store'); 

    Route::post('/bookings/upload-receipt', [App\Http\Controllers\BookingController::class, 'uploadReceipt'])->name('bookings.upload_receipt'); // رفع إيصال الدفع
});

/*
|--------------------------------------------------------------------------
| Admin - System Module Routes                                           |
|--------------------------------------------------------------------------|
| إدارة هيكلية النظام (الموديولات، الكيانات، الإجراءات)
*/
Route::prefix('system-module')->as('system-module.')->middleware('auth')->group(function () {
    Route::get('/', [SystemModuleController::class, 'index'])->name('index');
    Route::post('/add', [SystemModuleController::class, 'addModule'])->name('add');
    Route::post('/edit/{id}', [SystemModuleController::class, 'editModule'])->name('edit');
    Route::delete('/delete/{id}', [SystemModuleController::class, 'deleteModule'])->name('delete');

    // Actions
    Route::post('/action/add', [SystemModuleController::class, 'addAction'])->name('action.add');
    Route::post('/action/edit/{id}', [SystemModuleController::class, 'editAction'])->name('action.edit');
    Route::delete('/action/delete/{id}', [SystemModuleController::class, 'deleteAction'])->name('action.delete');

    // Entities
    Route::post('/entity/add', [SystemModuleController::class, 'addEntity'])->name('entity.add');
    Route::post('/entity/edit/{id}', [SystemModuleController::class, 'editEntity'])->name('entity.edit');
    Route::delete('/entity/delete/{id}', [SystemModuleController::class, 'deleteEntity'])->name('entity.delete');
    Route::post('/entity/actions/{id}', [SystemModuleController::class, 'updateEntityActions'])->name('entity.actions');
})->middleware('permission:system-module,show');

/*
|--------------------------------------------------------------------------
| Admin - Role & Rights Routes                                           |
|--------------------------------------------------------------------------|
| إدارة الأدوار والصلاحيات
*/
Route::prefix('role-rights')->as('role-rights.')->middleware('auth')->group(function () {
    Route::get('/', [RoleRightsController::class, 'index'])->name('index');
    Route::post('/add', [RoleRightsController::class, 'addRole'])->name('add');
    Route::post('/edit/{id}', [RoleRightsController::class, 'editRole'])->name('edit');
    Route::delete('/delete/{id}', [RoleRightsController::class, 'deleteRole'])->name('delete');
})->middleware('permission:role-rights,show');

/*
|--------------------------------------------------------------------------
| Admin - Users Management Routes                                        |
|--------------------------------------------------------------------------|
| إدارة المستخدمين من قبل الأدمن
*/
Route::prefix('users')->as('users.')->middleware('auth')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UsersController::class, 'update'])->name('update');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/change-password', [UsersController::class, 'changePassword'])->name('change-password');
})->middleware('permission:users,show');

/*
|--------------------------------------------------------------------------
| Admin - Active Sessions                                                |
|--------------------------------------------------------------------------|
*/
Route::get('/sessions', [SessionsController::class, 'index'])->name('sessions.index')->middleware('auth')->middleware('permission:sessions,show');;

/*
|--------------------------------------------------------------------------
| Admin - DataBank Routes                                                |
|--------------------------------------------------------------------------|
| بنك المعلومات (إدارة التصنيفات، المزودين، الخدمات، الباقات، أنواع المناسبات)
*/
Route::prefix('databank')->name('databank.')->middleware('auth')->group(function () {

    // 1. Categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // 2. Providers
    Route::prefix('providers')->name('providers.')->group(function () {
        Route::get('/', [ProviderController::class, 'index'])->name('index');
        Route::post('/', [ProviderController::class, 'store'])->name('store');
        Route::put('/{id}', [ProviderController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProviderController::class, 'destroy'])->name('destroy');
    });

    // 3. Services
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [AdminServiceController::class, 'index'])->name('index');
        Route::post('/', [AdminServiceController::class, 'store'])->name('store');
        Route::put('/{id}', [AdminServiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminServiceController::class, 'destroy'])->name('destroy');
    });

    // 4. Packages
    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('index');
        Route::post('/', [PackageController::class, 'store'])->name('store');
        Route::put('/{id}', [PackageController::class, 'update'])->name('update');
        Route::delete('/{id}', [PackageController::class, 'destroy'])->name('destroy');
    });

    // 5. Occasion Types
    Route::prefix('occasions')->name('occasions.')->group(function () {
        Route::get('/', [OccasionTypeController::class, 'index'])->name('index');
        Route::post('/', [OccasionTypeController::class, 'store'])->name('store');
        Route::put('/{id}', [OccasionTypeController::class, 'update'])->name('update');
        Route::delete('/{id}', [OccasionTypeController::class, 'destroy'])->name('destroy');
    });
})->middleware('permission:databank,show');


/*
|--------------------------------------------------------------------------
| Admin - bookings managment by admin                                               |
|--------------------------------------------------------------------------|
| إدارة الحجوزات من قبل الأدمن
*/
Route::prefix('admin')->group(function () {
          Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
          Route::post('/bookings/update', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.update');
})->middleware('auth')->middleware('permission:admin-bookings,show');   


Route::get('/notifications/read-all', function () {
    Auth::User()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.readAll')->middleware('auth');