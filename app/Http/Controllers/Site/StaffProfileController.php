<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;

class StaffProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $socialMediaPlatforms = [
            'instagram' => 'https://www.instagram.com/',
            'facebook' => 'https://www.facebook.com/profile.php?id=',
            'snapchat' => 'https://www.snapchat.com/add/',
            'youtube' => 'https://www.youtube.com/',
            'tiktok' => 'https://www.tiktok.com/@',
        ];

        foreach ($socialMediaPlatforms as $platform => $urlPrefix) {
            if (!filter_var($user->staff->$platform, FILTER_VALIDATE_URL)) {
                $user->staff->$platform = $urlPrefix . $user->staff->$platform;
            }
        }

        $categories = ServiceCategory::get();

        return view('site.staff.show', compact('user', 'categories'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
