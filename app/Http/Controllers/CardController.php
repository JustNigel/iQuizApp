<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function showAvailableExams(Request $request)
    {
        $query = $request->input('query');
        $cards = [
            (object) [
                'title' => 'ITILv4 Foundation',
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi vero, sit numquam fugit repellat laudantium similique ab temporibus eum ea necessitatibus odit autem accusantium ullam? Expedita architecto alias ut nobis!',
                'url' => '#',
                'buttonText' => 'Get Started',
                'passingScore' => '65%',
                'numItems' => 40,
                'timeLimit' => '60 minutes'
            ],
            (object) [
                'title' => 'AWS Cloud Practitioner',
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi vero, sit numquam fugit repellat laudantium similique ab temporibus eum ea necessitatibus odit autem accusantium ullam? Expedita architecto alias ut nobis!',
                'url' => '#',
                'buttonText' => 'Get Started',
                'passingScore' => '70%',
                'numItems' => 60,
                'timeLimit' => '90 minutes'
            ],
            // Add more cards as needed
        ];

        if ($query) {
            $cards = array_filter($cards, function($card) use ($query) {
                return stripos($card->title, $query) !== false || stripos($card->description, $query) !== false;
            });
        }

        if ($request->ajax()) {
            return view('category._cards', compact('cards'))->render();
        }

        return view('category.available-exams', compact('user'), [
            'cards' => $cards,
            'headerTitle' => 'Available Exams' // Pass the header title here
        ]);
    }

    public function showJoinExams(Request $request)
    {
        $user = auth()->user();
        $query = $request->input('query');
        $cards = [
            (object) [
                'title' => 'MS Azure Fundamentals',
                'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi vero, sit numquam fugit repellat laudantium similique ab temporibus eum ea necessitatibus odit autem accusantium ullam? Expedita architecto alias ut nobis!",
                'url' => '#',
                'buttonText' => 'Request to Join',
                'passingScore' => '60%',
                'numItems' => 50,
                'timeLimit' => '75 minutes'
            ],
            (object) [
                'title' => 'MS Azure Administrator',
                'description' => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi vero, sit numquam fugit repellat laudantium similique ab temporibus eum ea necessitatibus odit autem accusantium ullam? Expedita architecto alias ut nobis!",
                'url' => '#',
                'buttonText' => 'Request to Join',
                'passingScore' => '75%',
                'numItems' => 70,
                'timeLimit' => '120 minutes'
            ],
            // Add more cards as needed
        ];

        if ($query) {
            $cards = array_filter($cards, function($card) use ($query) {
                return stripos($card->title, $query) !== false || stripos($card->description, $query) !== false;
            });
        }

        if ($request->ajax()) {
            return view('category._cards', compact('cards'))->render();
        }

        return view('category.join', compact('user'), [
            'cards' => $cards,
            'headerTitle' => 'Join an Exam' // Pass the header title here
        ]);
    }
}
