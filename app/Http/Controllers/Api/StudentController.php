<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Student::with('teacher')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'gender' => 'required',
            'teacher_id'=> 'required',
            'phoneNumber' => 'required',
            'dob' => 'required',
            'pob' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images/students'), $filename);
        }

        $student = new Student();
        $student->teacher_id = $request->teacher_id;
        $student->firstName = $request->firstName;
        $student->lastName = $request->lastName;
        $student->image = url()->previous().'/images/students/'.$filename  ?? '';
        $student->gender = $request->gender;
        $student->phoneNumber = $request->phoneNumber;
        $student->email = $request->email;
        $student->dob = $request->dob;
        $student->pob = $request->dob;
        $student->save();

        return response()->json($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Student::with('teacher')->where('id',$id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::with('teacher')->find($id);
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'gender' => 'required',
            'teacher_id'=> 'required',
            'phoneNumber' => 'required',
            'dob' => 'required',
            'pob' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images/students'), $filename);
        }

        $student = Student::find($id);
        $student->teacher_id = $request->teacher_id;
        $student->firstName = $request->firstName;
        $student->lastName = $request->lastName;
        $student->image = url()->previous().'/images/students/'.$filename ?? '';
        $student->gender = $request->gender;
        $student->phoneNumber = $request->phoneNumber;
        $student->email = $request->email;
        $student->dob = $request->dob;
        $student->pob = $request->dob;
        $student->save();

        return response()->json($student->teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        return response()->json($student->delete());
    }
}
