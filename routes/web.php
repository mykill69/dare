<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\FoldersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\GuestController;


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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/login', function () {
        return view('.login.login');
    });


//login
Route::get('/login', [LoginAuthController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [LoginAuthController::class, 'postLogin'])->name('postLogin');


Route::get('/', [GuestController::class, 'indexGuest'])->name('indexGuest');
Route::get('/searchGuest', [GuestController::class, 'searchGuest'])->name('searchGuest');
Route::get('/guest/viewPdf/{file_name}', [GuestController::class, 'viewPdfGuest'])->name('viewPdfGuest');
Route::get('/guest/downloadPdf/{file_name}', [GuestController::class, 'downloadPdfGuest'])->name('downloadPdfGuest');


});


Route::group(['middleware'=>['login_auth']],function(){

//Main page
Route::get('/index', [DocumentsController::class, 'index'])->name('index');

// search docu
Route::get('/search', [DocumentsController::class, 'search'])->name('search');


// folders
Route::post('/storeFolder', [FoldersController::class, 'storeFolder'])->name('folders.storeFolder');
Route::get('/folders', [FoldersController::class, 'showFolders'])->name('folders');
Route::post('/folders/{id}/rename', [FoldersController::class, 'rename'])->name('folders.rename');
Route::delete('/folders/{id}', [FoldersController::class, 'destroyFolder'])->name('destroyFolder');

//documents
Route::get('/folders/{folderId}', [DocumentsController::class, 'documentView'])->name('documentView');
Route::post('/storeFile', [DocumentsController::class, 'storeFile'])->name('storeFile');
Route::get('/documents/view/{file_name}', [DocumentsController::class, 'viewPdf'])->name('viewPdf');
Route::get('/document/edit/{id}', [DocumentsController::class, 'editFile'])->name('editFile');
Route::post('/document/update/{id}', [DocumentsController::class, 'updateFile'])->name('updateFile');
Route::delete('/document/{id}', [DocumentsController::class, 'destroy'])->name('destroy');

//users
Route::get('/users', [UserController::class, 'userView'])->name('userView');
Route::post('/users', [UserController::class, 'addUser'])->name('users.addUser');
Route::get('/users/edit/{id}', [UserController::class, 'userEdit'])->name('userEdit');
Route::put('/users/update/{id}', [UserController::class, 'userUpdate'])->name('userUpdate');
Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('users.deleteUser');

//logout
Route::get('/logout', [MasterController::class,'logout'])->name('logout');

});

