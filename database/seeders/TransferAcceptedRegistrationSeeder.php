<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferAcceptedRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all accepted records from registration_requests
        $acceptedRequests = DB::table('registration_requests')
            ->where('request_status', 'accepted')
            ->get();

        // Insert each accepted request into confirmed_registrations
        foreach ($acceptedRequests as $request) {
            DB::table('confirmed_registrations')->insert([
                'student_id' => $request->user_id, // Insert into student_id
                'request_status' => $request->request_status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Delete the accepted records from registration_requests
        DB::table('registration_requests')
            ->where('request_status', 'accepted')
            ->delete();
    }
}
