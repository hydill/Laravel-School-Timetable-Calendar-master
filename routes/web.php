<?php

// use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SchoolClassesController;
use App\Http\Controllers\Admin\StudentRecordController;
use App\Http\Controllers\timezoneController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Route::redirect('/', '/login',);
Route::get('/home', function () {
    $routeName = auth()->user() && (auth()->user()->is_student || auth()->user()->is_teacher) ? 'admin.calendar.index' : 'admin.home';
    if (session('status')) {
        return redirect()->route($routeName)->with('status', session('status')); 
    }

    return redirect()->route($routeName);
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::resource('lessons', 'LessonsController');
    Route::post('/lessons/update/{id}', 'LessonsController@updated')->name('update.lesson');

    //konten
    Route::resource('kontens', 'KontenController');
    // Route::resource('kontens', [KontenController::class]);
    Route::delete('kontens/destroy', [KontenController::class, 'massDestroy'])->name('kontens.massDestroy');
    // Route::get('kontens/create', 'KontenController@create')->name('kontens.create');

    // siswa
    Route::resource('student', 'StudentRecordController');
    Route::delete('student/destroy', 'StudentRecordController@massDestroy')->name('student.massDestroy');


    // School Classes
    Route::delete('school-classes/destroy', 'SchoolClassesController@massDestroy')->name('school-classes.massDestroy');
    Route::resource('school-classes', 'SchoolClassesController');
    Route::post('school-classes/{slug?}', 'SchoolClassesController@showing')->name('school-classes.showing')->where('slug', '.+');
    // routes/web.php
    Route::post('school-classes/{id}/send-notification', 'SchoolClassesController@sendNotification')->name('school-classes.send-notification');
    Route::post('school-classes/{slug?}', 'SchoolClassesController@makeMessage')->name('send.students');

    // Route::get('{slug?}', 'SchoolClassesController@showing')->name('school-classes.showing')->where('slug','.+');
    // Route::get('admin/', 'SchoolClassesController@showing')->name('school-classes.showing');


    Route::get('calendar', 'CalendarController@index')->name('calendar.index');

    Route::get('manage-class/index', 'ManageClassController@index')->name('manage-class.index');
    Route::get('manage-class/index/show/{id}', 'ManageClassController@show')->name('manage-class.show');
    Route::post('manage-class/index/show/{id}', 'ManageClassController@store')->name('manage-class.store');
    Route::get('report/{date}',  [ReportController::class, 'dailyReport'])->name('report.daily');

});
