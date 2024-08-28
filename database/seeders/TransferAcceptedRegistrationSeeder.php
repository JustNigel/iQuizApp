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
        // Start a database transaction
        DB::transaction(function () {
            // Get all accepted records from registration_requests
            $acceptedRequests = DB::table('registration_requests')
                ->where('request_status', 'accepted')
                ->get();

            // Check if there are any records to process
            if ($acceptedRequests->isNotEmpty()) {
                // Insert each accepted request into confirmed_registrations
                foreach ($acceptedRequests as $request) {
                    // Check if the student_id already exists in confirmed_registrations
                    $exists = DB::table('confirmed_registrations')
                        ->where('student_id', $request->user_id)
                        ->exists();

                    // Insert only if it doesn't exist
                    if (!$exists) {
                        DB::table('confirmed_registrations')->insert([
                            'student_id' => $request->user_id,
                            'request_status' => $request->request_status,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // Delete the accepted records from registration_requests
                DB::table('registration_requests')
                    ->where('request_status', 'accepted')
                    ->delete();
            }
        });
    }
}
