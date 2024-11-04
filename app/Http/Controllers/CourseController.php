<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Please Fill All Field',
                'error' => $validator->errors()
            ]);
        }

        if(!Auth::check()){
            return response()->json([
                'status' => false,
                'message' => 'Login First To Make This Function'
            ]);
        }

        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->slug = $request->slug; 
        $course->is_published = $request->is_published;
        $course->save();

        return response()->json([
            'status' => true,
            'message' => 'Course Created Successfully',
            'data' => $course,
            'is_published' => false,
        ]);
    }


    public function update(Request $request, $id){
        if(!Auth::check()){
            return response()->json([
                'Login First To Use This Function'
            ]);
        }
       $course = Course::findOrFail($id);
       $validator = Validator::make($request->all(), [
        'name' => 'required',
        'description' => 'required',
        'slug' => 'required'
       ]);

       if ($validator->fails()) {
        return response()->json([
            'status' => 'false',
            'message' => 'Please Fill All Field',
            'error' => $validator->errors()
        ]);
       }

       $course->update([
        'name' => $request->name,
        'description' => $request->description,
        'slug' => $request->slug,
        'is_published' => $request->is_published,
       ]);

       return response()->json([
        'status' => true,
        'message' => 'Course Updated Successfully',
        'data' => $course,
       ]);


       
    }
    public function destroy(Request $request, $id){
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            'status' => true,
            'message' => 'deleted successfully',
        ]);
    }

    public function showPublishedCourses(Request $request){
        
        $course = Course::where('is_published', true)->get();
        return response()->json([
            'status' => true,
            'message' => 'Successfully get all published course',
            'data' => $course
        ]);

    }
}
