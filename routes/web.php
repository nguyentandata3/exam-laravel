<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\SubjectController;
use App\Http\Controllers\admin\ExamController;
use App\Http\Controllers\admin\GenreController;
use App\Http\Controllers\admin\AnswerQuestionController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\GetdataController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\user\ResultController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\FacebookController;

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

Route::get('auth/facebook',[FacebookController::class,'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback',[FacebookController::class,'facebookCallback']);
// Route::get('/auth/redirect/{provider}', [SocialController::class, 'redirect'])->name('redirect');
// Route::get('/callback/{provider}', [SocialController::class, 'callback'])->name('callback');
// Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
// Route::get('/callback/{provider}', 'SocialController@callback');

Route::get('getSendemail', [MailController::class, 'getSendemail'])->name('getSendemail');
Route::post('postSendemail', [MailController::class, 'postSendemail'])->name('postSendemail');
Route::get('successemail', [MailController::class, 'successemail'])->name('successemail');

Route::post('verify',[LoginController::class, 'verify'])->name('verify');
Route::get('successverify',[LoginController::class, 'successverify'])->name('successverify');
Route::get('finishverify/{uuid}', [LoginController::class, 'finishverify'])->name('finishverify');

Route::get('login', [LoginController::class, 'getLogin'])->name('getLogin');
Route::get('register', [LoginController::class, 'getRegister'])->name('getRegister');
Route::post('postRegister', [LoginController::class, 'postRegister'])->name('postRegister');
Route::post('postLogin', [LoginController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('getdata', [GetdataController::class, 'getdata'])->name('getdata');

Route::get('laydata', [GetdataController::class, 'laydata'])->name('laydata');
Route::post('postlaydata', [GetdataController::class, 'postlaydata'])->name('postlaydata');

Route::prefix('admin/')->name('admin.')->middleware('check_admin')->group(function () {
    Route::get('', [SubjectController::class, 'index'])->name('index');
    Route::post('ckeditor/image_upload', [CkeditorController::class, 'upload'])->name('upload');
    Route::get('contact', [ContactController::class, 'index'])->name('contact');

    Route::controller(SubjectController::class)->prefix('subjects')->name('subjects.')->group(function () {
        Route::get('', 'index')->name('index');
    
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
    
        Route::get('delete/{id}', 'destroy')->name('destroy');
    });

    Route::controller(GenreController::class)->prefix('genres')->name('genres.')->group(function () {
        Route::get('', 'index')->name('index');
    
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
    
        Route::get('delete/{id}', 'destroy')->name('destroy');
    });

    Route::controller(ExamController::class)->prefix('exams')->name('exams.')->group(function () {
        
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
    
        Route::get('delete/{id}', 'destroy')->name('destroy');

        Route::get('/{subject_id}', 'index')->name('index');
    });

    Route::controller(UserController::class)->prefix('users/')->name('users.')->group(function () {
        Route::get('', 'index')->name('index');
    
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
    
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
    
        Route::get('delete/{id}', 'destroy')->name('destroy');
    });

    Route::controller(AnswerQuestionController::class)->prefix('answerquestions/')->name('answerquestions.')->group(function () {
        Route::get('{exam_id}/', 'index')->name('index');
    
        Route::get('create/{exam_id}/{genres_id}', 'create')->name('create');
        Route::post('store/{exam_id}', 'store')->name('store');

        Route::get('getcheckGenre/{exam_id}', 'getcheckGenre')->name('getcheckGenre');
        Route::post('postcheckGenre/{exam_id}', 'postcheckGenre')->name('postcheckGenre');
    
        Route::get('edit/{answerquestion_id}', 'edit')->name('edit');
        Route::post('update/{answerquestion_id}', 'update')->name('update');
    
        Route::get('delete/{answerquestion_id}', 'destroy')->name('destroy');
    });

});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('subjects/{subject_id}', [HomeController::class, 'subjects'])->name('subjects');
    
Route::get('exams/{exam_id}', [HomeController::class, 'exams'])->name('exams');
Route::get('infomation', [HomeController::class, 'infomation'])->name('infomation');
Route::post('feedback', [HomeController::class, 'feedback'])->name('feedback');
Route::prefix('users')->middleware('check_user')->name('users.')->group(function () {
    Route::get('/', [ResultController::class, 'index'])->name('index');
    Route::get('subjects/{subject_id}', [ResultController::class, 'subjects'])->name('subjects');
    
    Route::get('exams/{exam_id}', [ResultController::class, 'exams'])->name('exams');
    Route::post('addSession/{exam_id}', [ResultController::class, 'addSession'])->name('addSession');

    Route::get('answer_questions/', [ResultController::class, 'answer_questions'])->name('answer_questions');
    Route::post('test/{exam_id}', [ResultController::class, 'test'])->name('test');

    Route::get('delete-session', [ResultController::class, 'deleteSession'])->name('deleteSession');

    Route::get('profile/{user_uuid}', [UserController::class, 'profile'])->name('profile');
    Route::post('postProfile/{user_uuid}', [UserController::class, 'postProfile'])->name('postProfile');
    
    Route::get('transcript/{user_uuid}', [UserController::class, 'transcript'])->name('transcript');
    Route::get('history/{history_id}', [UserController::class, 'history'])->name('history');

    Route::get('changepassword/{uuid}', [UserController::class, 'getChangePassword'])->name('getChangePassword');
    Route::post('postchangepassword/{uuid}', [UserController::class, 'postChangePassword'])->name('postChangePassword');
});
