<?php

namespace App\Http\Controllers\API;

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

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').str_replace(' ', '_', $file->getClientOriginalName());
            $file-> move(public_path('images/teachers'), $filename)-> move(public_path('images/protect/teachers'), $filename);
        }

        $teacher = new Teacher();
        $teacher->firstName = $request->firstName;
        $teacher->lastName = $request->lastName;
        $teacher->image = url()->previous().'/images/teachers/'.$filename ?? '';
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

    public function uploadTeacherProfile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        $teacher = Teacher::find($id);

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').str_replace(' ', '_', $file->getClientOriginalName());
            $file-> move(public_path('images/teachers'), $filename)-> move(public_path('images/protect/teachers'), $filename);
        }

        $teacher->image = url()->previous().'/images/teachers/'.$filename ?? '';
        $teacher->save();

        return response()->json($teacher);
    }

    public function getTeacherProfile($id)
    {
        $teacher = Teacher::find($id);
        $str = explode('/',  $teacher->image);
        $teacher['protect_image'] = url()->previous().'/images/protect/teachers/'.$str[5];
        if(!$teacher){
            return response()->json(404);
        }

        return response()->json($teacher->protect_image);

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

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').str_replace(' ', '_', $file->getClientOriginalName());
            $file-> move(public_path('images/teachers'), $filename)-> move(public_path('images/protect/teachers'), $filename);
        }

        $teacher = Teacher::find($id);
        $teacher->firstName = $request->firstName;
        $teacher->lastName = $request->lastName;
        $teacher->image = url()->previous().'/images/teachers/'.$filename ?? '';
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
