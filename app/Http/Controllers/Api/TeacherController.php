<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Teacher::with('students')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $teacher = new Teacher();
        $teacher->firstName = $request->firstName;
        $teacher->lastName = $request->lastName;
        $teacher->phoneNumber = $request->phoneNumber;
        $teacher->email = $request->email;
        $teacher->address = $request->address;
        $teacher->save();

        return response()->json($teacher);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        return response()->json(Teacher::with('students')->where('id',$id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = Teacher::find($id);
        return response()->json($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $teacher = Teacher::find($id);
        $teacher->firstName = $request->firstName;
        $teacher->lastName = $request->lastName;
        $teacher->phoneNumber = $request->phoneNumber;
        $teacher->email = $request->email;
        $teacher->address = $request->address;
        $teacher->save();

        return response()->json($teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        return response()->json($teacher->delete());
    }
}
