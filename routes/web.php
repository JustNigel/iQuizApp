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
use App\Http\Middleware\SetPreviousPage;
use App\Http\Middleware\UserType;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified', PendingRequests::class, SetPreviousPage::class])->group(function () {

    // The universal routes in editing profile for Student, Trainer, and Admin
    Route::get('/profile', [ProfileController::class, 'edit',])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/deactivate', [ProfileController::class, 'deactivate'])->name('deactivate');
    Route::put('/profile/update-image', [ProfileController::class, 'updateProfileImage'])->name('profile.update-image');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('login', [AuthenticatedSessionController::class, 'showLoginForm'])->name('login');

    // Routes for Student
    Route::prefix('student')->middleware([UserType::class.':student'])->group(function () {
        Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard'); // Dashboard Page
        Route::get('/history', [StudentController::class, 'history'])->name('history'); // History Page
        Route::get('/history/reviewer/{exam}', [StudentController::class, 'reviewer'])->name('student.reviewer'); // History Exam Review Page
        Route::get('/category', [StudentController::class, 'category'])->name('student.category'); // Category Page
        Route::get('/category/request', [ExamRequestController::class, 'requestJoin'])->name('category.join'); // Request To Join Page
        Route::post('/request-to-join', [ExamRequestController::class, 'storeRequest'])->name('exam.request.store');
        Route::delete('/request-to-cancel/{id}', [ExamRequestController::class, 'cancelRequest'])->name('exam.request.cancel');
        Route::get('/category/available-exam', [StudentController::class, 'availableExam'])->name('category.available-exams'); // Request To Join Page
        

        Route::get('start-exam/{questionnaire}',[ExamController::class,'exam'])->name('student.exam');
    
        Route::get('/verify-registration', [RegistrationController::class, 'displayVerificationRegistration'])->name('auth.verify-registration');
        Route::get('/verify-registration-refresh', [RegistrationController::class, 'checkIfAccepted'])->name('auth.accepted-registration');
        
    });

    
    // Routes for Trainer
    Route::prefix('trainer')->middleware([UserType::class.':trainer'])->group(function () {
        Route::get('/dashboard', [TrainerController::class, 'index'])->name('trainer.dashboard'); // Dashboard Page
        Route::get('/request-list', [TrainerController::class, 'requestList'])->name('trainer.request-list'); // All the Requests of Students Page
        Route::get('/category/add-questionnaire', [TrainerController::class, 'addQuestionnaire'])->name('trainer.add-questionnaire'); // Exam Questionnaire Page
        Route::post('/store-questionnaire', [TrainerController::class, 'storeQuestionnaire'])->name('trainer.store-questionnaire');
        Route::get('/confirm-delete-all-questionnaire/{categoryId}', [TrainerController::class, 'showAllQuestionnaireDeleteConfirmation'])->name('trainer.confirm-delete');
        Route::delete('/delete-all-questionnaire/{categoryId}', [TrainerController::class, 'deleteAllQuestionnaire'])->name('trainer.questionnaire.delete');
        Route::get('/respondents', [TrainerController::class, 'respondent'])->name('trainer.respondent');
        Route::get('/{category}/respondents', [TrainerController::class, 'respondentsCategory'])->name('trainer.respondents-category'); // All Respondents In the Exam
        Route::get('/accept-request/{id}', [RegistrationController::class, 'acceptRequest'])->name('trainer.acceptRequest');
        Route::get('/deny-request/{id}', [RegistrationController::class, 'denyRequest'])->name('trainer.denyRequest');
        Route::put('/exam-request/{id}/accept', [ExamRequestController::class, 'acceptExamRequest'])->name('trainer.request.accept');
        Route::delete('/deny-exam-request/{id}', [ExamRequestController::class, 'denyExamRequest'])->name('trainer.denyExamRequest');
        Route::get('/confirm-delete-exam-access-{id}', [ExamRequestController::class,'showConfirmDeleteAccess'])->name('trainer.confirm-delete-access');
        Route::delete('/delete-exam-access/{id}', [ExamRequestController::class,'deleteExamAccess'])->name('trainer.delete-exam-request');
        Route::post('/questionnaire/toggle-visibility/{id}', [QuestionnaireController::class, 'toggleVisibility'])->name('questionnaire.toggle-visibility');
        Route::get('/edit-questionnaire-{id}', [QuestionnaireController::class, 'editQuestionnaire'])->name('trainer.edit-questionnaire');
        Route::put('/questionnaire-{id}', [QuestionnaireController::class, 'updateQuestionnaire'])->name('trainer.update-questionnaire');

        Route::prefix('all')->group(function () {
            Route::get('category', [TrainerController::class, 'displayAllCategory'])->name('trainer.all-category'); // Category Page
            Route::get('registration-request', [RegistrationController::class, 'displayAllRegistrationRequest'])->name('trainer.all-registration-request');
            Route::get('students', [AdminController::class, 'displayAllStudents'])->name('trainer.all-students');
            Route::get('exam-students', [ExamRequestController::class, 'displayAllAccepted'])->name('trainer.all-confirmed-students');
            Route::get('exam-requests', [ExamRequestController::class, 'displayAllExamRequest'])->name('trainer.all-exam-request');
            Route::get('questionnaires', [QuestionnaireController::class, 'displayListQuestionnaires'])->name('trainer.all-questionnaires');
            Route::get('category-{categoryId}/questionnaires', [QuestionnaireController::class, 'displayAllQuestionnaire'])->name('trainer.all-questionnaire'); // Exam Questionnaire Page
        });
    });
    


    // ADMIN ROUTES
    Route::prefix('admin')->middleware([UserType::class.':admin'])->group(function () {
        
        // Dashboard    
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.dashboard'); //Dashboard Page
        
        // Student Management
        Route::prefix('students')->group(function(){
            Route::get('request-list',[AdminController::class, 'requestList'])->name('admin.request-list'); //All the Requests of Students Page
            Route::get('accept-request/{id}', [RegistrationController::class, 'acceptRequest'])->name('admin.acceptRequest');
            Route::get('deny-request/{id}', [RegistrationController::class, 'denyRequest'])->name('admin.denyRequest');
            Route::put('exam-request/{id}/accept', [ExamRequestController::class, 'acceptExamRequest'])->name('exam.request.accept');
            Route::delete('deny-exam-request/{id}', [ExamRequestController::class,'denyExamRequest'])->name('admin.denyExamRequest');
            Route::get('confirm-delete-student-{id}', [AdminController::class, 'showStudentDeleteConfirmation'])->name('admin.confirm-delete-student');
            Route::delete('/delete-student/{id}', [AdminController::class, 'deleteStudent'])->name('admin.delete-student');
        });

        // Trainer Management
        Route::prefix('trainers')->group(function(){
            Route::get('add', [AdminController::class,'addTrainer'])->name('admin.add-trainer'); 
            Route::get('edit-profile/{id}', [AdminController::class, 'editTrainerProfile'])->name('admin.edit-trainer-profile');
            Route::post('store', [AdminController::class, 'storeTrainer'])->name('admin.store-trainer');
            Route::get('confirm-delete/{id}', [TrainerListController::class,'showTrainerDeleteConfirmation'])->name('admin.delete-trainer');
            Route::delete('delete/{id}', [TrainerListController::class, 'deleteTrainer'])->name('admin.confirm-delete-trainer');
            Route::patch('update-profile/{id}', [AdminController::class, 'updateTrainerProfile'])->name('admin.update-trainer-profile');
            Route::patch('update-trainer-password/{id}', [AdminController::class, 'updateTrainerPassword'])->name('admin.update-trainer-password');
            Route::delete('delete-trainer-profile/{id}', [AdminController::class, 'deleteTrainerProfile'])->name('admin.delete-trainer-profile');
        });

        // Category Management
        Route::prefix('categories')->group(function(){
            Route::get('add', [CategoryController::class,'createCategory'])->name('admin.add-category');
            Route::post('store', [CategoryController::class, 'storeCategory'])->name('admin.store-category'); 
            Route::get('{id}/edit', [CategoryController::class, 'editCategory'])->name('admin.edit');//Category Page
            Route::put('category-{id}', [CategoryController::class, 'updateCategory'])->name('admin.update-category');
            Route::get('confirm-delete/{id}', [CategoryController::class, 'showCategoryDeleteConfirmation'])->name('admin.confirm-delete');
            Route::delete('delete-category-{id}', [CategoryController::class, 'deleteCategory'])->name('admin.category.delete');
            Route::get('cancel-delete', [CategoryController::class, 'cancelDeleteCategory'])->name('admin.cancel-delete');
            Route::get('{categoryId}/all-questionnaires',[QuestionnaireController::class, 'displayAllQuestionnaire'])->name('admin.all-questionnaire'); 
            Route::get('trainer-{trainerId}/filtered-categories', [CategoryController::class, 'filterByTrainer'])->name('admin.filter-by-trainer');
            
        });

        // Questionnaire Management
        Route::prefix('questionnaires')->group(function(){
            Route::get('add',[QuestionnaireController::class, 'addQuestionnaire'])->name('admin.add-questionnaire'); 
            Route::get('edit-{id}', [QuestionnaireController::class, 'editQuestionnaire'])->name('admin.edit-questionnaire');
            Route::put('update-{id}', [QuestionnaireController::class, 'updateQuestionnaire'])->name('admin.update-questionnaire');
            Route::get('cancel-add', [QuestionnaireController::class,'cancelAddQuestionnaire'])->name('admin.cancel-add-questionnaire');
            Route::get('confirm-add', [QuestionnaireController::class, 'confirmAddPrompt'])->name('admin.confirm-add-questionnaire');
            Route::post('store', [QuestionnaireController::class, 'storeQuestionnaire'])->name('admin.store-questionnaire');
            Route::get('add-another-{categoryId}', [QuestionnaireController::class, 'addAnotherQuestionnaire'])->name('admin.add-another-questionnaire');
            Route::get('confirm-delete-{id}', [QuestionnaireController::class, 'showQuestionnaireDeleteConfirmation'])->name('admin.confirm-delete-questionnaire');
            Route::delete('delete/{id}', [QuestionnaireController::class, 'deleteQuestionnaire'])->name('admin.delete-questionnaire');
            Route::post('toggle-visibility-{id}', [QuestionnaireController::class, 'toggleVisibility'])->name('questionnaire.toggle-visibility');
            Route::get('add-question', [AdminController::class, 'displayAddQuestionnaire'])->name('admin.questionnaire');
            Route::post('{id}/store-question', [AdminController::class, 'store'])->name('questions.store');
        });
        
        
        // All Management
        Route::prefix('all')->group(function(){
            Route::get('questionnaires', [QuestionnaireController::class, 'displayListQuestionnaires'])->name('admin.all-questionnaires');
            Route::get('trainers', [TrainerListController::class,'index'])->name('admin.all-trainers'); //All the Trainers existing
            Route::get('registration-request', [RegistrationController::class, 'displayAllRegistrationRequest'])->name('admin.all-registration-request');
            Route::get('exam-requests', [ExamRequestController::class, 'displayAllExamRequest'])->name('admin.all-exam-request');
            Route::get('exam-students',[ExamRequestController::class,'displayAllAccepted'])->name('admin.all-confirmed-students');
            Route::get('students', [AdminController::class, 'displayAllStudents'])->name('admin.all-students');
            Route::get('categories', [CategoryController::class, 'allCategories'])->name('admin.all-category');
        });
        
    });
});

require __DIR__.'/auth.php';
