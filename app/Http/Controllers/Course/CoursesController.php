<?php

namespace App\Http\Controllers\Course;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursesQuery = Course::latest();

        //Prepare for Search Courses 

        if(request()->has('title')){
            $coursesQuery->where('title','like','%' .request('title') . '%');
        }

        $courses = $coursesQuery->get();
        //Prepare for Ajax Calls 
        if(request()->wantsJson()){

            return $courses ; 
        }

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new Course.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data 
        $request->validate([
            'title' => 'required|max:200|unique:courses',
            'active' => 'boolean'
        ]);

        //Prepare data 
        $data['title'] = $request->title ; 

        $data['active'] = $request->active ? true : false ; 
        

        //Store Data 
        $course = Course::create($data);

        //Return to the Class Show page With Success Message 


        return redirect()->route('course.show', ['course' => $course->id])
                ->with('success', 'تم إنشاء الدورة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        

        //prepare for AjaxCall 
        if(request()->wantsJson()){

            return $course ; 
        }

        return view('admin.courses.show' , compact('course'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        
        return view('admin.courses.edit' , compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        
        //Validate Data 
        $request->validate([
            'title' => 'required|max:200', 
            'active' => 'boolean'

        ]);

        //Prepare data 
        
        $data['title'] = $request->title ;

        $data['active'] = $request->active ? true : false ; 


        //Update Course 
        $course->title = $data['title']; 
        $course->active = $data['active'];

        $course->save();

        

        //Redirect with updated Data 
        return redirect()->route('course.show',['course' => $course->id])
            ->with('success','تم تعديل الدورة بنجاح');


        
    }

    /**
     * Remove the specified Course from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();


        return redirect()->route('course.index')
                    ->with('success','تم حذف الدورة بنجاح');


    }

    /**
     * Action to Activate A Course 
     */
    public function activate(Course $course){

        $course->makeActive();
        
        $course->save();
        
        return redirect()->route('course.show', ['course' => $course->id])
                ->with('success','تم تفعيل الدورة بنجاح');
    }

     /**
      * Action to deactivate A Course
      */
      public function deactivate(Course $course){
        $course->makeInactive();
        $course->save();

        return redirect()->route('course.show', ['course' => $course->id])
                ->with('success', 'تم إلغاء تفعيل الدورة بنجاح');

      }
}
