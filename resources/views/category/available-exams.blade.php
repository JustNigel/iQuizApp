@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')

    <x-join-button href="{{route('category.join')}}">
        Join an exam
    </x-join-button>

    <div class="card-container mt-6">
        @foreach ($cards as $card)
            <x-category-card 
                title="{{ $card->title }}" 
                description="{!! $card->description !!}" 
                url="{{ $card->url }}" 
                buttonText="{{ $card->buttonText }}" 
            />
        @endforeach
    </div>
@endsection
