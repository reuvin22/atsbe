<?php

namespace App\Http\Controllers;

use App\Models\AlumniRecord;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tab = $request->input('tab');
        switch($tab){
            case 'tab1':
                return $this->fetchCount();
            break;
        }
    }
    private function fetchCount(){
        $genderM = AlumniRecord::where('gender', 'Male')->count();
        $genderF = AlumniRecord::where('gender', 'Female')->count();
        $students = AlumniRecord::all()->count();
        return response()->json([
            'status' => 200,
            'data' => [
                'Male' => $genderM,
                'Female' => $genderF,
                'Total Students' => $students
            ]
        ], 200);
    }

    private function fetchTable(){

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AlumniDataController $service)
    {
        return $service->createBulk($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
