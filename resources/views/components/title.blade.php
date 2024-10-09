@props(['routeName', 'user'])

@php
    $titles = [
        'admin.dashboard.dashboard' => '<i class="fa-solid fa-house mr-2"></i> Welcome to your Dashboard, Admin',
        'admin.all-confirmed-students' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Students',
        'admin.all-exam-request' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Exam Requests',
        'admin.edit-trainer-profile' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Edit Trainer Profile',
        'admin.all-trainers' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Trainers',
        'admin.all-questionnaires' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Questionnaires',
        'admin.delete-trainer' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Confirm Delete Trainer',
        'admin.all-category' => '<i class="fa-solid fa-folder mr-2"></i> Categories: All Categories',
        'admin.add-category' => '<i class="fa-solid fa-folder mr-2"></i> Categories: New Category',
        'admin.confirm-delete-student' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Confirm Delete Student',
        'admin.add-trainer' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Add Trainer',
        'admin.all-students' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Students',
        'admin.all-registration-request' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Registration Request',
        'admin.filter-by-trainer' => '<i class="fa-solid fa-folder mr-2"></i> Categories: All Filtered Categories',
        'admin.add-questionnaire' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: New Questionnaire',
        'admin.add-another-questionnaire' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: New Questionnaire',
        'trainer.dashboard' => '<i class="fa-solid fa-house-user mr-2"></i> Welcome to your Dashboard, Trainer',
        'trainer.all-category' => '<i class="fa-solid fa-th-list mr-2"></i> All Categories',
        'trainer.all-students' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Students',
        'trainer.all-questionnaires' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Questionnaires',
        'trainer.all-confirmed-students' => '<i class="fa-solid fa-user-gear mr-2"></i> Questionnaires: All Students',
        'trainer.all-registration-request' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Registration Request',
        'trainer.add-questionnaire' => '<i class="fa-solid fa-file-alt mr-2"></i> Add Questionnaire',
        'dashboard' => '<i class="fa-solid fa-house mr-2"></i> Welcome to your Dashboard, ',
        
        'profile' => '<i class="fa-solid fa-user-circle mr-2"></i>Your Profile'
    ];

    $title = $titles[$routeName] ?? 'Dashboard';

    if (in_array($routeName, ['trainer.dashboard', 'admin.dashboard.dashboard', 'dashboard'])) {
        $title .= ' ' . $user->name . '!';
    }
@endphp

<h2 class="text-1.2rem font-400 flex items-center">
    {!! $title !!}
</h2>
