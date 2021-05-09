<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $user = auth()->user();
        $userID = $user->id;

        $todayAttendance = DB::table('attendances')->select(DB::raw('*'))
                        ->where('user_id', $userID)
                        ->whereRaw('Date(created_at) = CURDATE()')->first();

        if ($todayAttendance) {
            $data = [
                "userID" => $userID,
                "flag" => 1,
                "checkIn" => $todayAttendance->created_at,
                "checkOut" => $todayAttendance->updated_at
            ];
        } else {
            $data = [
                "userID" => $userID,
                "flag" => 0,
                "checkIn" => '',
                "checkOut" => ''
            ];
        }
       
        return view('attendance.attendance', ['attendance' => $data]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $toDateTime = Carbon::now();

        $user = new Attendance;
        $user->timestamps = false;
        $user->user_id = $request->id;
        $user->created_at = $toDateTime->toDateTimeString();
        $user->save();

        return redirect()->route('dashboard.attendance')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance) {

        $toDateTime = Carbon::now();       

        DB::table('attendances')                
                ->where('user_id', $request->id)
                ->whereRaw('Date(created_at) = CURDATE()')
                ->update(['updated_at' => $toDateTime->toDateTimeString()]);

        return redirect()->route('dashboard.attendance')->with('success', 'Checkout Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance) {
        //
    }

}
