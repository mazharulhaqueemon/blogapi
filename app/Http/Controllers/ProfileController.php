<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use App\Models\Education;
use App\Models\PersonalInfo;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    $ageFrom = $request->query('age_from');
    $ageTo = $request->query('age_to');
    $marital_status = $request->query('marital_status');
    $height = $request->query('height');
    $highest_degree = $request->query('highest_degree');
    $blood_group = $request->query('blood_group');


    $users = User::with(['personalinfo', 'education', 'profile'])
        ->when($ageFrom, fn($q) =>
            $q->whereHas('profile', fn($q2) => $q2->where('age', '>=', $ageFrom))
        )
        ->when($ageTo, fn($q) =>
            $q->whereHas('profile', fn($q2) => $q2->where('age', '<=', $ageTo))
        )
        ->when($marital_status, fn($q) =>
            $q->whereHas('personalinfo', fn($q2) => $q2->where('marital_status', $marital_status))
        )
        ->when($height, fn($q) =>
            $q->whereHas('personalinfo', fn($q2) => $q2->where('height', '>=', $height))
        )
        ->when($highest_degree, fn($q) =>
            $q->whereHas('education', fn($q2) => $q2->where('highest_degree', 'like', "%$highest_degree%"))
        )

        ->when($blood_group, fn($q) =>
            $q->whereHas('personalinfo', fn($q2) => $q2->where('blood_group', 'like', "%$blood_group%"))
        )

        ->get();

    return response()->json($users);


        // $ageFrom = $request->query('age_from');
        // $ageTo = $request->query('age_to');





        // $profiles=Profile::query()
        //     ->when($ageFrom && $ageTo, function($query) use ($ageFrom, $ageTo) {
        //        return $query->whereBetween('age', [$ageFrom, $ageTo]);
        //     })
        //     ->get();


        // get all query at a time in profile
        // $profiles = Profile::query()
        //     ->when($ageFrom, fn($q) => $q->where('age', '>=', $ageFrom))
        //     ->when($ageTo, fn($q) => $q->where('age', '<=', $ageTo))
        //     ->get();

        // return response()->json($profiles);



    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gender' => 'nullable|string|max:10',
            'age' => 'nullable|integer|min:0',
        ]);

        $profile = Profile::create([
            'gender' => $request->gender,
            'age' => $request->age,
            'user_id' => $request->user()->id, // Assuming user is authenticated
        ]);

        return response()->json($profile, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
