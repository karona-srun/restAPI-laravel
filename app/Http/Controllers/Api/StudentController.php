<?php

namespace App\Http\Controllers\API;

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
        return response()->json(Student::with(['teacher','courses'])->get());
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
            'course_id' => 'required',
            'phoneNumber' => 'required',
            'dob' => 'required',
            'pob' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').str_replace(' ', '_', $file->getClientOriginalName());
            $file-> move(public_path('images/students'), $filename)-> move(public_path('images/protect/students'), $filename);
        }

        $student = new Student();
        $student->teacher_id = $request->teacher_id;
        $student->course_id = $request->course_id;
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
        $student = Student::with(['teacher','courses'])->where('id',$id)->first();
        $str = explode('/',  $student->image);
        $student['protect_image'] = url()->previous().'/images/protect/students/'.$str[5];
        if(!$student){
            return response()->json($student,404);
        }
        return response()->json($student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::with(['teacher','courses'])->find($id);
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
            'course_id' => 'required',
            'phoneNumber' => 'required',
            'dob' => 'required',
            'pob' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('images/students'), $filename)->move(public_path('images/protect/students'), $filename);
        }

        $student = Student::find($id);
        $student->teacher_id = $request->teacher_id;
        $student->course_id = $request->course_id;
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
