<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // The universal routes in editing profile for Student, Trainer, and Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for Student
    Route::prefix('student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard'); // Dashboard Page
        Route::get('/history', [StudentController::class, 'history'])->name('history'); // History Page
        Route::get('/history/reviewer/{exam}', [StudentController::class, 'reviewer'])->name('student.reviewer'); // History Exam Review Page
        Route::get('/category', [StudentController::class, 'category'])->name('student.category'); // Category Page
        Route::get('/category/request-to-join', [StudentController::class, 'requestJoin'])->name('category.join'); // Request To Join Page
        Route::get('/category/available-exam', [StudentController::class, 'availableExam'])->name('category.available-exams'); // Request To Join Page
        Route::get('/{category}/{exam}', [ExamController::class, 'exam'])->name('student.exam'); // Get Started Page
        Route::get('/{category}/{exam}/{questionnaire}', [ExamController::class, 'questionnaire'])->name('student.questionnaire'); // Exam Page
        Route::get('/{category}/{exam}/{result}', [ExamController::class, 'result'])->name('student.result'); // Result Page
    });

    
    // Routes for Trainer
    Route::prefix('trainer')->group(function () {
        Route::get('/dashboard', [TrainerController::class, 'index'])->name('trainer.dashboard.dashboard'); //Dashboard Page
        Route::get('/request-list',[TrainerController::class, 'requestList'])->name('trainer.request-list'); //All the Requests of Students Page
        Route::get('/category', [TrainerController::class, 'category'])->name('trainer.category'); //Category Page
        Route::get('/category/add-category', [TrainerController::class, 'addCategory'])->name('trainer.add-category'); //Add Category Page
        Route::get('/{category}/add-questionnaire',[TrainerController::class, 'addQuestionnaire'])->name('trainer.add-questionnaire'); //Exam Questionnaire Page
        Route::get('/respondents', [TrainerController::class, 'respondent'])->name('trainer.respondent');
        Route::get('/{category}/respondents', [TrainerController::class, 'respondentsCategory'])->name('trainer.respondents-category'); //All Respondents In the Exam
    });


    // Routes for Admin
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.dashboard'); //Dashboard Page
        Route::get('/request-list',[AdminController::class, 'requestList'])->name('admin.request-list'); //All the Requests of Students Page
        Route::get('/trainer-list', [AdminController::class,'trainerList'])->name('admin.all-trainers'); //All the Trainers existing
        
        Route::get('/trainer-list/add-trainer', [AdminController::class,'addTrainer'])->name('admin.add-trainer'); //Registration for Admin and Trainer
        Route::post('/trainer-list/store-trainer', [AdminController::class, 'storeTrainer'])->name('admin.store-trainer');


        Route::post('/store-category', [AdminController::class, 'storeCategory'])->name('admin.store-category'); //Category Page
        Route::get('/add-category', [AdminController::class,'create'])->name('admin.add-category');
        Route::get('/all-category', [AdminController::class, 'allCategories'])->name('admin.all-category');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.edit');
        Route::get('/admin/confirm-delete/{id}', [AdminController::class, 'showCategoryDeleteConfirmation'])->name('admin.confirm-delete');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('admin.update-category');

        
        Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');


        Route::get('/{category}/add-questionnaire',[AdminController::class, 'addQuestionnaire'])->name('admin.add-questionnaire'); //Exam Questionnaire Page
        Route::get('/respondents', [AdminController::class, 'respondent'])->name('admin.respondent');
        Route::get('/{category}/respondents', [AdminController::class, 'respondents'])->name('admin.respondents'); //All Respondents In the Exam
    });







});

// Route::get('/admin/add-trainer', function () {
//     return view('admin.add-trainer');
// })->name('admin.add-trainer');

// Route::get('/profile', function () {
//     return view('profile/profile');
// })->name('profile');

// Route::prefix('category')->group(function () {
    
//     Route::view('/join', 'category/join')->name('category.join');
//     Route::view('/available-exams', 'category/available-exams')->name('category.available-exams');
// });

// Route::get('/history', function () {
//     return view('history/history');
// })->name('history');

// Route::get('/category/available-exams', [CardController::class, 'showAvailableExams'])->name('category.available-exams');

// Route for join exams
// Route::get('/category/join', [CardController::class, 'showJoinExams'])->name('category.join');

require __DIR__.'/auth.php';
