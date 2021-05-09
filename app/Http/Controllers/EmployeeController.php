<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $users = DB::table('users')
                ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                ->where('role_id', '=', 2)
                ->paginate(10);


        return view('employee.employee_list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
       

        $data = new User;
        $data->name = trim($request->input('name'));
        $data->email = strtolower($request->input('email'));
        $data->phone = $request->input('phone');
        $data->password = bcrypt($request->input('password'));     
        $data->save();         
        
        $role = new \App\Models\RollUser();
        $role->role_id = 2;
        $role->user_id = $data->id;
        $role->user_type = 'App\Models\User';
        
        $role->save();


        session()->flash('message', 'Your account is created');

        return redirect()->route('dashboard.employeeData')->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $employeeInfo = DB::table('users')->select(DB::raw('*'))
                        ->where('id', $id)->first();

        $data = [
            "id" => $employeeInfo->id,
            "name" => $employeeInfo->name,
            "email" => $employeeInfo->email,
            "phone" => $employeeInfo->phone
        ];


        return view('employee.edit', ['user' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required'
        ]);

        DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => trim($request->input('name')),
                    'email' => strtolower($request->input('email')),
                    'phone' => $request->input('phone')
        ]);

        return redirect()->route('dashboard.employeeData')->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee) {
        //
    }

}
