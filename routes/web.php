<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/sign-in',[SignInController::class, 'create'])->name('login');
Route::post('/sign-in/store',[SignInController::class, 'store'])->name('sign-in.store');
Route::get('/sign-up',[SignUpController::class, 'create'])->name('sign-up.create');
Route::post('/sign-up/store',[SignUpController::class, 'store'])->name('sign-up.store');
Route::get('/forget-password/create',[ForgetPasswordController::class, 'create'])->name('forget-password.create');
Route::post('/forget-password',[ForgetPasswordController::class, 'store'])->name('forget-password.store');
Route::get('/reset-password',[ResetPasswordController::class, 'create'])->name('password.reset');
Route::put('/reset-password',[ResetPasswordController::class, 'update'])->name('reset-password.update');
//Tasks
Route::middleware(['auth'])->group(function() {
    Route::get('/sign-in/logout',[SignInController::class, 'logout'])->name('logout');
    Route::get('/',[TaskController::class, 'report'])->name('tasks.report');
    Route::get('/tasks/print',[TaskController::class, 'print'])->name('tasks.print');
    Route::get('/tasks/edit/{task}',[TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/update/{task}',[TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/destroy/{task}',[TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/create',[TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store',[TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/category/{category}',[TaskController::class, 'category'])->name('tasks.category');

    Route::get('/tasks/update-status/{task}', [TaskController::class, 'progress'])->name('tasks.progress');
    Route::get('/tasks/{int}',[TaskController::class, 'index'])->name('tasks.index');
    //
    //Tasks
    Route::get('/categorys',[CategoryController::class, 'index'])->name('categorys.index');
    Route::get('/categorys/create',[CategoryController::class, 'create'])->name('categorys.create');
    Route::get('/categorys/edit/{category}',[CategoryController::class, 'edit'])->name('categorys.edit');
    Route::post('/categorys/update/{category}',[CategoryController::class, 'update'])->name('categorys.update');
    Route::delete('/categorys/destroy/{category}',[CategoryController::class, 'destroy'])->name('categorys.destroy');
    Route::post('/categorys/store',[CategoryController::class, 'store'])->name('categorys.store');
    //
});

//1- structure change for database (create table , edit column , remove column)
//2- operations on database (insert record, edit record, delete record)
