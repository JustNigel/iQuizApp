<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{


    public function availableExam(Request $request)
    {
        $user = auth()->user();
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
    public function index(){

        $user = auth()->user();
        return view('student.dashboard', compact('user'));
    }

    public function history(){
        $user = auth()->user();
        return view('history', compact('user'));
    }
}
