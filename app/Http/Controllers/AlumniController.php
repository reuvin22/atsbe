<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniData;
use App\Models\AlumniRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\GenericResource;
use App\Http\Controllers\AlumniDataController;
use App\Http\Resources\GenericResourceCollection;

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

            case 'tab2':
                return $this->fetchAlumniList($request);
            break;

            case 'tab3':
                return $this->fetchUserList($request);
            break;
        }
    }
    private function fetchCount(){
        $genderM = AlumniData::where('gender', 'Male')->count();
        $genderF = AlumniData::where('gender', 'Female')->count();
        $students = AlumniData::all()->count();
        $freelancer = AlumniData::where('employmentType', 'Freelancer')->count();
        $part_time = AlumniData::where('employmentType', 'Part Time')->count();
        $full_time = AlumniData::where('employmentType', 'Full Time')->count();
        $employed = AlumniData::where('employmentStatus', 'Employed')->count();
        $unemployed = AlumniData::where('employmentStatus', 'Unemployed')->count();
        $related = AlumniData::where('relatedOrNot', 'Related')->count();
        $not_related = AlumniData::where('relatedOrNot', 'Not Related')->count();
        return response()->json([
            'status' => 200,
            'data' => [
                'male' => $genderM,
                'female' => $genderF,
                'total_students' => $students,
                'freelancer' => $freelancer,
                'part_time' => $part_time,
                'full_time' => $full_time,
                'employed' => $employed,
                'unemployed' => $unemployed,
                'related' => $related,
                'not_related' => $not_related
            ]
        ], 200);
    }

    private function fetchAlumniList($request)
    {
        $query = AlumniData::query();
        if ($request->has('sort') && $request->sort === 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->has('items')) {
            $symptomsList = $query->paginate($request->items);

            $data = new GenericResource($symptomsList);
            $data->setTableName('alumni_data');
            $data->setDisplayFields([
                'fname',
                'mname',
                'lname',
                'studentNumber',
                'civilStatus',
                'year',
                'relatedOrNot',
                'course',
                'employmentStatus',
                'gender',
                'email',
                'employmentType'
            ]);
            $data->set24HourFormat(false);
        } else {
            $symptomsList = $query->get();
            $data = GenericResourceCollection::collection($symptomsList)->map(function ($patient) use($request) {
                if($patient) {
                    $resource = new GenericResourceCollection($patient);
                    $resource->set24HourFormat(false);
                    return $resource->toArray($request);
                }
                return [];
            });
        }
        return response()->json($data, 200);
    }

    private function fetchUserList($request)
    {
        $query = User::query();
        if ($request->has('sort') && $request->sort === 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->has('items')) {
            $users = $query->paginate($request->items);

            $data = new GenericResource($users);
            $data->setTableName('users');
            $data->setDisplayFields([
                'fname',
                'mname',
                'lname',
                'role',
                'email',
            ]);
            $data->set24HourFormat(false);
        } else {
            $users = $query->get();
            $data = GenericResourceCollection::collection($users)->map(function ($patient) use($request) {
                if($patient) {
                    $resource = new GenericResourceCollection($patient);
                    $resource->set24HourFormat(false);
                    return $resource->toArray($request);
                }
                return [];
            });
        }
        return response()->json($data, 200);
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
    public function destroy(Request $request, string $id)
    {
        $actionType = $request->input('actionType');
        switch($actionType){
            case 'deleteUser':
                $delete = User::find($id);
                $delete->delete();
            break;

            default:
                return null;
            break;
        }
        return response()->json(['success' => true], 200);
    }
}
