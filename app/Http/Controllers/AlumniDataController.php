<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlumniDataController extends Controller
{
    function createBulk($request)
    {
        try {
            $data = $request->input('data');
            $actionType = $request->input('actionType');
        switch($actionType)
        {
            case 'alumni-data':
                $this->insertAlumniData(
                    $data['fname'],
                    $data['mname'],
                    $data['lname'],
                    $data['studentNumber'],
                    $data['civilStatus'],
                    $data['year'],
                    $data['relatedOrNot'],
                    $data['course'],
                    $data['employmentStatus'],
                    $data['gender']
                );
            break;

            case 'user-registration':
                $this->insertUser(
                    $data['fname'],
                    $data['mname'],
                    $data['lname'],
                    $data['role'],
                    Hash::make($data['password']),
                    $data['email']
                );
            break;
        }
        }catch(\Exception $ex) {
            return response()->json(
                [
                    'message' => $ex->getMessage()
                ], 500
            );
        }
    }

    private function insertAlumniData($fname, $mname, $lname, $studentNumber, $civilStatus, $year, $relatedOrNot, $course, $employmentStatus, $gender){
        AlumniRecord::create([
            'fname' => $fname,
            'mname' => $mname,
            'lname' => $lname,
            'studentNumber' => $studentNumber,
            'civilStatus' => $civilStatus,
            'year' => $year,
            'relatedOrNot' => $relatedOrNot,
            'course' => $course,
            'employmentStatus' => $employmentStatus,
            'gender' => $gender
        ]);
    }

    private function insertUser($fname, $mname, $lname, $email, $password, $role){
        User::create([
            'fname' => $fname,
            'mname' => $mname,
            'lname' => $lname,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);
    }
}
