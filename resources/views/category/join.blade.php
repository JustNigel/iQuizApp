@extends('layouts.app')

@section('title', 'Join an Exam')

@section('content')

    <div class="container mt-6">
        <div class="mb-6">
            <input 
                type="text" 
                id="search" 
                placeholder="Search for an exam..." 
                class="border p-2 rounded-lg w-full" 
                autofocus
            />
        </div>

        <div id="cards-container" class="card-container mt-6">
            @include('category._cards', ['cards' => $cards])
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const cardsContainer = document.getElementById('cards-container');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase();

                fetch(`/category/join?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    cardsContainer.innerHTML = html;
                });
            });
        });
    </script>

@endsection
