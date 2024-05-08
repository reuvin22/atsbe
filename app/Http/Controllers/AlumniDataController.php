<?php

namespace App\Http\Controllers;

use App\Models\AlumniData;
use App\Models\User;
use App\Models\AlumniRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlumniDataController
{
    function createBulk($request)
    {
        DB::beginTransaction();
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
                    $data['gender'],
                    $data['email'],
                    $data['employmentType']
                );
            break;

            case 'user-registration':
                $this->insertUser(
                    $data['fname'],
                    $data['mname'],
                    $data['lname'],
                    $data['email'],
                    Hash::make($data['password']),
                    $data['role'],
                );
            break;
        }
        DB::commit();
            return response()->json([
                'message' => 'Successfully created',
                'status' => 'success'
            ], 200);
        }catch(\Exception $ex) {
            DB::rollBack();
            return response()->json(
                [
                    'message' => $ex->getMessage()
                ], 500
            );
        }
    }

    private function insertAlumniData($fname, $mname, $lname, $studentNumber, $civilStatus, $year, $relatedOrNot, $course, $employmentStatus, $gender, $email, $employmentType){
        AlumniData::create([
            'fname' => $fname,
            'mname' => $mname,
            'lname' => $lname,
            'studentNumber' => $studentNumber,
            'civilStatus' => $civilStatus,
            'year' => $year,
            'relatedOrNot' => $relatedOrNot,
            'course' => $course,
            'employmentStatus' => $employmentStatus,
            'gender' => $gender,
            'email' => $email,
            'employmentType' => $employmentType
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
