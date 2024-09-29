@extends('layouts.admin')

@section('title', 'Edit Trainer Profile')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    
            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-trainer-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-trainer-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-trainer-form')
                </div>
            </div>
        </div>
    </div>
@endsection
