<?php

namespace App\Http\Controllers;

use App\Models\course_assignments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class CourseAssignmentsController extends Controller
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
     * Create new record of course assignment
     * 
     * @param $request
     *
     * @return array( 
     *      (boolean) $success,
     *      (string)  $message/$error (depending on state of success)
     * ) 
     */
    public function create(Request $request)
    {
        return course_assignments::assignCourse($request); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        return course_assignments::viewAssignments($user_id); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\course_assignments  $course_assignments
     * @return \Illuminate\Http\Response
     */
    public function edit(course_assignments $course_assignments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\course_assignments  $course_assignments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, course_assignments $course_assignments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\course_assignments  $course_assignments
     * @return \Illuminate\Http\Response
     */
    public function destroy(course_assignments $course_assignments)
    {
        //
    }


 
    public function completeCourse(Request $request)
    {
        return course_assignments::completeCourse($request);
    }

    
    public function archiveCourse(Request $request)
    {
        return course_assignments::archiveCourse($request);
    }

    
}
