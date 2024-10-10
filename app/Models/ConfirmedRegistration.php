<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class ConfirmedRegistration extends Model
    {
        use HasFactory;
    /**
     * Get all students from confirmed registrations.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAllStudents()
    {
        return DB::table('confirmed_registrations')
            ->join('users', 'confirmed_registrations.student_id', '=', 'users.id')
            ->where('users.type_name', 'student')
            ->select('users.name', 'users.last_name', 'users.username', 'users.email', 'confirmed_registrations.id', 'confirmed_registrations.request_status')
            ->get();
    }

}
