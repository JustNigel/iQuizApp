<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainerListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function () {

    // The universal routes in editing profile for Student, Trainer, and Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('login', [AuthenticatedSessionController::class, 'showLoginForm'])->name('login');

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
        Route::get('/verify-registration', [RegistrationController::class, 'displayVerificationRegistration'])->name('auth.verify-registration');
        Route::get('/verify-registration-refresh', [RegistrationController::class, 'checkIfAccepted'])->name('auth.accepted-registration');
        
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
        Route::get('/student-list',[AdminController::class, 'requestList'])->name('admin.request-list'); //All the Requests of Students Page
        Route::get('/trainer-list', [TrainerListController::class,'index'])->name('admin.all-trainers'); //All the Trainers existing

        Route::get('/trainer-list/add-trainer', [AdminController::class,'addTrainer'])->name('admin.add-trainer'); //Registration for Admin and Trainer
        Route::post('/trainer-list/store-trainer', [AdminController::class, 'storeTrainer'])->name('admin.store-trainer');
        Route::get('/trainer-list/confirm-delete/{id}', [TrainerListController::class,'showTrainerDeleteConfirmation'])->name('admin.delete-trainer');
        Route::delete('/trainer-list/confirm-delete/{id}', [TrainerListController::class, 'deleteTrainer'])->name('admin.confirm-delete-trainer');


    
        Route::get('/add-category', [CategoryController::class,'createCategory'])->name('admin.add-category');
        Route::post('/store-category', [CategoryController::class, 'storeCategory'])->name('admin.store-category'); 
        Route::get('/category-{id}/edit-category', [CategoryController::class, 'editCategory'])->name('admin.edit');//Category Page
        Route::get('/all-category', [CategoryController::class, 'allCategories'])->name('admin.all-category');


        Route::get('/confirm-delete/{id}', [CategoryController::class, 'showCategoryDeleteConfirmation'])->name('admin.confirm-delete');
        Route::put('/category-{id}', [CategoryController::class, 'updateCategory'])->name('admin.update-category');
        Route::delete('/delete-category-{id}', [CategoryController::class, 'deleteCategory'])->name('admin.category.delete');
        Route::get('/add-another-questionnaire/{categoryId}', [QuestionnaireController::class, 'addAnotherQuestionnaire'])->name('admin.add-another-questionnaire');
        
    
        Route::get('/confirm-delete-questionnaire/{id}', [QuestionnaireController::class, 'showQuestionnaireDeleteConfirmation'])->name('admin.confirm-delete-questionnaire');
        Route::delete('/delete-questionnaire/{id}', [QuestionnaireController::class, 'deleteQuestionnaire'])->name('admin.delete-questionnaire');
        Route::get('/category/add-questionnaire',[QuestionnaireController::class, 'addQuestionnaire'])->name('admin.add-questionnaire'); 
        Route::post('/category/store-questionnaire', [QuestionnaireController::class, 'storeQuestionnaire'])->name('admin.store-questionnaire');
        Route::get('/category-{categoryId}/all-questionnaires',[QuestionnaireController::class, 'displayAllQuestionnaire'])->name('admin.all-questionnaire'); //Exam Questionnaire Page
        
        Route::put('/questionnaire-{id}', [QuestionnaireController::class, 'updateQuestionnaire'])->name('admin.update-questionnaire');
        Route::get('/edit-questionnaire-{id}', [QuestionnaireController::class, 'editQuestionnaire'])->name('admin.edit-questionnaire');
        
        Route::get('/respondents', [AdminController::class, 'respondent'])->name('admin.respondent');
        Route::get('/{category}/respondents', [AdminController::class, 'respondents'])->name('admin.respondents'); //All Respondents In the Exam


        Route::get('/all-registration-request', [RegistrationController::class, 'displayAllRegistrationRequest'])->name('admin.all-registration-request');
        Route::get('/accept-request/{id}', [RegistrationController::class, 'acceptRequest'])->name('admin.acceptRequest');
        Route::get('/deny-request/{id}', [RegistrationController::class, 'denyRequest'])->name('admin.denyRequest');
        
    });







});

require __DIR__.'/auth.php';
