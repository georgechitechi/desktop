<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route Hooks - Do not delete//
// Roster Routes
Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
    Route::get('/rosters', App\Livewire\Roster\Rosters::class)->name('admin.rosters');
});

// School Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::middleware(['role:admin|super-admin'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
        Route::get('/students', [App\Livewire\School\Students::class, 'home'])->name('admin.students');
        Route::get('/attendances', App\Livewire\School\Attendances::class);
        
        Route::group(['prefix' => 'timetable'], function () {
            Route::get('/', App\Livewire\School\Timetables::class)->name('admin.timetable');
            Route::get('/schedules', App\Livewire\School\Schedules::class)->name('admin.schedules');
        });

        Route::group(['prefix' => 'students'], function () {
            Route::get('/', App\Livewire\School\Students::class)->name('admin.students');
            Route::get('/{id}', [App\Livewire\School\Students::class, 'details'])->name('admin.students.show');
        });
        Route::group(['prefix' => 'parents'], function () {
            Route::get('/', App\Livewire\School\Guardians::class)->name('admin.parents');
            Route::get('/{id}', [App\Livewire\School\Guardians::class, 'details'])->name('admin.parents.show');
        });
        Route::group(['prefix' => 'teachers'], function () {
            Route::get('/', App\Livewire\School\Teachers::class)->name('admin.teachers');
            Route::get('/{id}', [App\Livewire\School\Teachers::class, 'details'])->name('admin.teachers.show');
        });
        Route::group(['prefix' => 'grades'], function () {
            Route::get('/', App\Livewire\School\Grades::class)->name('admin.grades');
            Route::get('/{id}', [App\Livewire\School\Grades::class, 'details'])->name('admin.grades.show');
        });
        Route::group(['prefix' => 'notices'], function () {
            Route::get('/', App\Livewire\School\Boards::class)->name('admin.notices');
            Route::get('/{id}', [App\Livewire\School\Boards::class, 'details'])->name('admin.notices.show');
        });
    });

    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/', App\Livewire\School\Teachers::class)->name('teacher');
    });

    Route::group(['prefix' => 'parent'], function () {
        Route::get('/', App\Livewire\School\Guardians::class)->name('parent');
    });

    Route::group(['prefix' => 'student'], function () {
        Route::get('/', App\Livewire\School\Students::class)->name('student');
    });
});

// Blog Routes
Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
    Route::get('/blog', App\Livewire\Blog\Posts::class)->name('admin.blog');
});

Route::middleware(['web'])->prefix(config("admin.blogRoute", "blog"))->group(function () {
    Route::get('/', App\Livewire\Blog\BlogPosts::class)->name(config("admin.blogRoute", "blog"));
    Route::get('/post/{post:id}', [App\Livewire\Blog\BlogPosts::class, 'show'])->name('blog.show');
    Route::get('/category/{slug}', [App\Livewire\Blog\BlogPosts::class, 'category'])->name('blog.category');
    Route::get('/archive/{year}/{month}', [App\Livewire\Blog\BlogPosts::class, 'archive'])->name('blog.archive');
});

// Shop Routes
Route::middleware(['web'])->prefix(config("admin.shopRoute", "shop"))->group(function () {
    Route::get('/', [App\Livewire\Shop\Products::class, 'renderProducts'])->name(config("admin.shopRoute", "shop"));
    Route::get('/checkout', [App\Livewire\Shop\Products::class, 'checkout'])->name("shop.checkout");
    Route::get('/product/{product:id}', [App\Livewire\Shop\Products::class, 'show'])->name('shop.show');
    Route::get('/category/{slug}', [App\Livewire\Shop\Products::class, 'category'])->name('shop.category');
});
Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
    Route::get('/shop', App\Livewire\Shop\Products::class)->name(config("admin.adminRoute", "admin").".".config("admin.shopRoute", "shop"));
});

// Social Login Routes
Route::get('/auth/{provider}/redirect', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'callback']);

// Flights Routes
Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
    Route::get('/', App\Livewire\Flight\Flights::class)->name(config("admin.adminRoute", "admin"));
    Route::get('/flights', App\Livewire\Flight\Flights::class)->name('admin.flights');
    Route::get('/airlines', App\Livewire\Flight\Airlines::class)->name('admin.airlines');
    Route::get('/delays', App\Livewire\Flight\Delays::class)->name('admin.delays');
    Route::get('/services', App\Livewire\Flight\Services::class)->name('admin.services');
    Route::get('/registrations', App\Livewire\Flight\Registrations::class)->name('admin.registrations');
    Route::get('/schedules', App\Livewire\Flight\Schedules::class)->name('admin.schedules');
});

// Admin Routes
Route::middleware(['auth', 'role:super-admin|admin|user'])->prefix(config("admin.adminRoute", "admin"))->group(function () {
    Route::get('/', App\Livewire\Users::class)->name(config("admin.adminRoute", "admin"));
    Route::get('/users', App\Livewire\Users::class)->name('admin.users');
    Route::get('/users/{id}', [App\Livewire\Users::class, 'details'])->name('admin.users.show');
    Route::get('/roles', App\Livewire\Roles::class)->name('admin.roles');
    Route::get('/permissions', App\Livewire\Permissions::class)->name('admin.permissions');
    Route::get('/settings', App\Livewire\Settings::class)->name('admin.settings');
});



Auth::routes(['register' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');