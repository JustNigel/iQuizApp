<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainerListController;
use App\Http\Middleware\PendingRequests;
use App\Http\Middleware\UserType;
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
    Route::prefix('student')->middleware([UserType::class.':student', PendingRequests::class])->group(function () {
        Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard'); // Dashboard Page
        Route::get('/history', [StudentController::class, 'history'])->name('history'); // History Page
        Route::get('/history/reviewer/{exam}', [StudentController::class, 'reviewer'])->name('student.reviewer'); // History Exam Review Page
        Route::get('/category', [StudentController::class, 'category'])->name('student.category'); // Category Page
        Route::get('/category/request', [ExamRequestController::class, 'requestJoin'])->name('category.join'); // Request To Join Page
        Route::post('/request-to-join', [ExamRequestController::class, 'storeRequest'])->name('exam.request.store');
        Route::delete('/request-to-cancel/{id}', [ExamRequestController::class, 'cancelRequest'])->name('exam.request.cancel');
        Route::get('/category/available-exam', [StudentController::class, 'availableExam'])->name('category.available-exams'); // Request To Join Page
        
        
        Route::get('/{category}/{exam}', [ExamController::class, 'exam'])->name('student.exam'); // Get Started Page
        Route::get('/{category}/{exam}/{questionnaire}', [ExamController::class, 'questionnaire'])->name('student.questionnaire'); // Exam Page
        Route::get('/{category}/{exam}/{result}', [ExamController::class, 'result'])->name('student.result'); // Result Page
        Route::get('/verify-registration', [RegistrationController::class, 'displayVerificationRegistration'])->name('auth.verify-registration');
        Route::get('/verify-registration-refresh', [RegistrationController::class, 'checkIfAccepted'])->name('auth.accepted-registration');
        
    });

    
    // Routes for Trainer
    Route::prefix('trainer')->middleware([UserType::class.':trainer', PendingRequests::class])->group(function () {
        Route::get('/dashboard', [TrainerController::class, 'index'])->name('trainer.dashboard'); //Dashboard Page
        Route::get('/request-list',[TrainerController::class, 'requestList'])->name('trainer.request-list'); //All the Requests of Students Page
        Route::get('/all-category', [TrainerController::class, 'displayAllCategory'])->name('trainer.all-category'); //Category Page

        Route::get('/category/add-questionnaire',[TrainerController::class, 'addQuestionnaire'])->name('trainer.add-questionnaire'); //Exam Questionnaire Page
        Route::post('/store-questionnaire', [TrainerController::class, 'storeQuestionnaire'])->name('trainer.store-questionnaire');
        Route::get('/confirm-delete-all-questionnaire/{categoryId}', [TrainerController::class, 'showAllQuestionnaireDeleteConfirmation'])->name('trainer.confirm-delete');
        Route::delete('/delete-all-questionnaire/{categoryId}', [TrainerController::class, 'deleteAllQuestionnaire'])->name('trainer.questionnaire.delete');
    
        
        
        Route::get('/respondents', [TrainerController::class, 'respondent'])->name('trainer.respondent');
        Route::get('/{category}/respondents', [TrainerController::class, 'respondentsCategory'])->name('trainer.respondents-category'); //All Respondents In the Exam
    

    });


    // Routes for Admin
    Route::prefix('admin')->middleware([UserType::class.':admin', PendingRequests::class])->group(function () {
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
        Route::get('/cancel-delete', [CategoryController::class, 'cancelDeleteCategory'])->name('admin.cancel-delete');
        Route::get('/add-another-questionnaire/{categoryId}', [QuestionnaireController::class, 'addAnotherQuestionnaire'])->name('admin.add-another-questionnaire');
        
    
        Route::get('/confirm-delete-questionnaire/{id}', [QuestionnaireController::class, 'showQuestionnaireDeleteConfirmation'])->name('admin.confirm-delete-questionnaire');
        Route::delete('/delete-questionnaire/{id}', [QuestionnaireController::class, 'deleteQuestionnaire'])->name('admin.delete-questionnaire');
        
        Route::get('/category/add-questionnaire',[QuestionnaireController::class, 'addQuestionnaire'])->name('admin.add-questionnaire'); 
        Route::get('/category/confirm-add-questionnaire', [QuestionnaireController::class, 'displayConfirmAddQuestionnairePrompt'])->name('admin.confirm-add-questionnaire');
        Route::post('/category/store-questionnaire', [QuestionnaireController::class, 'storeQuestionnaire'])->name('admin.store-questionnaire');
        
        
        Route::get('/category-{categoryId}/all-questionnaires',[QuestionnaireController::class, 'displayAllQuestionnaire'])->name('admin.all-questionnaire'); //Exam Questionnaire Page
        
        
        Route::get('/category/trainer-{trainerId}/filtered-categories', [CategoryController::class, 'filterByTrainer'])->name('admin.filter-by-trainer');
        Route::put('/questionnaire-{id}', [QuestionnaireController::class, 'updateQuestionnaire'])->name('admin.update-questionnaire');
        Route::get('/edit-questionnaire-{id}', [QuestionnaireController::class, 'editQuestionnaire'])->name('admin.edit-questionnaire');
        Route::post('/questionnaire/toggle-visibility/{id}', [QuestionnaireController::class, 'toggleVisibility'])->name('questionnaire.toggle-visibility');
        
        Route::get('/respondents', [AdminController::class, 'respondent'])->name('admin.respondent');
        Route::get('/{category}/respondents', [AdminController::class, 'respondents'])->name('admin.respondents'); //All Respondents In the Exam
        

        Route::get('/all-registration-request', [RegistrationController::class, 'displayAllRegistrationRequest'])->name('admin.all-registration-request');
        Route::get('/accept-request/{id}', [RegistrationController::class, 'acceptRequest'])->name('admin.acceptRequest');
        Route::get('/deny-request/{id}', [RegistrationController::class, 'denyRequest'])->name('admin.denyRequest');
        
        Route::get('/all-exam-requests', [ExamRequestController::class, 'displayAllExamRequest'])->name('admin.all-exam-request');
        Route::put('/exam-request/{id}/accept', [ExamRequestController::class, 'acceptExamRequest'])->name('exam.request.accept');
        Route::get('/all-exam-students',[ExamRequestController::class,'displayAllAccepted'])->name('admin.all-confirmed-students');

        Route::get('/edit-trainer-profile/{id}', [AdminController::class, 'editTrainerProfile'])->name('admin.edit-trainer-profile');
        Route::patch('/update-trainer-profile/{id}', [AdminController::class, 'updateTrainerProfile'])->name('admin.update-trainer-profile');
        Route::delete('/delete-trainer-profile/{id}', [AdminController::class, 'deleteTrainerProfile'])->name('admin.delete-trainer-profile');

        Route::get('/all-students', [AdminController::class, 'displayAllStudents'])->name('admin.all-students');
        Route::get('/confirm-delete-student-{id}', [AdminController::class, 'showStudentDeleteConfirmation'])->name('admin.confirm-delete-student');
        Route::delete('/delete-student/{id}', [AdminController::class, 'deleteStudent'])->name('admin.delete-student');
        Route::get('/questionnaire-{id}/add-questions', [AdminController::class, 'displayAddQuestionnaire'])->name('admin.questionnaire');
        Route::post('/questionnaire-{id}/store-question', [AdminController::class, 'store'])->name('questions.store');

    });







});

require __DIR__.'/auth.php';
