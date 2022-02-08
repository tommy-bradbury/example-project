<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class course_assignments extends Model
{
    use HasFactory;

    protected $table      = 'course_assignments';
    public $timestamps    = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'int';
    public $incrementing  = true;
    protected $hidden     = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The default attribute values
     *
     * @var array
     */
    protected $attributes = [];


    /**
     * Assign a course to a user
     * 
     * @param $request : the POST request for this method containing a course_id and a user_id
     * 
     * @returns (array) $return : [
     *      (boolean) success,
     *      (string) error/mesage (depending on the outcome),
     * ]
     */
    public static function assignCourse(Request $request)
    {
        $course_id = $request->course_id;
        $user_id   = $request->user_id;

        // Verify that course and user exist 
        // Cache list of courses every 10 minutes
        $courses = cache()->remember('coursesAssignmentsById', 600, function () {
            return collect(courses::select('*')->get())->keyBy('id')->all();
        });
        // if course does not exist, return error
        if(!array_key_exists($course_id, $courses)) {
            $return = array(
                'success' => false,
                'error'   => "Course selected not found"
            );
            return $return;
        }

        $user_exists = User::find($user_id);
        if(!$user_exists) {
            $return = array(
                'success' => false,
                'error'   => "User selected not found. ($course_id, $user_id)"
            );
            return $return;
        }

        // if user and course exist, provision the course
        // first archive any current assignments of the course
        course_assignments::where('user_id','=',$user_id)->where('course_id','=',$course_id)->update(['status'=>'archive']);

        // insert new assignment (due_at is 1 year later by default)
        $insertSuccess = course_assignments::insert(['user_id' => $user_id, 'course_id' => $course_id, 'due_at' => Carbon::now()->addYear()->format('Y-m-d h:i:s')]);

        if($insertSuccess === false) {
            $return = array(
                'success' => false,
                'error'   => "Uknown Error when trying to provision course"
            );
            return $return;
        }

        $return = array(
            'success' => true,
            'message' => "Course has been added to user"
        );
        return $return;
    }


    public static function viewAssignments($user_id)
    {

        $courses = DB::table('users')
                    ->join('course_assignments', 'users.id', '=', 'course_assignments.user_id')
                    ->join('courses', 'course_assignments.course_id', '=', 'courses.id')
                    ->select(
                        'course_assignments.assigned_at',
                        'course_assignments.due_at',
                        'course_assignments.completed_at',
                        'course_assignments.outcome',
                        'course_assignments.course_id',
                        'courses.course_name',
                        'courses.course_image',
                        'courses.course_description'
                    )
                    ->where('users.id', '=', $user_id)
                    ->where('course_assignments.status', '<>', 'archive')
                    ->get();

        if (!$courses->first()) {
            $return = array(
                'success' => false,
                'error'   => "Courses not found for this user"
            );
            return $return;
        }

        $return = array(
            'success' => true,
            'courses' => $courses
        );
        return $return;
        
    }

    public static function completeCourse(Request $request)
    {
        $user_id   = $request->user_id;
        $course_id = $request->course_id;
        $outcome   = $request->outcome;

        $updater = course_assignments::where('user_id','=',$user_id)->where('course_id','=',$course_id)->update(['outcome'=>$outcome, 'completed_at'=>Carbon::now()]);

        if(!$updater) {
            $return = array(
                'success' => false,
                'error' => 'Error when trying to update user records'
            );
            return $return;
        }

        $return = array(
            'success' => true,
            'message' => 'Records updated successfully'
        );
        return $return;
    }

    public static function archiveCourse(Request $request)
    {
        $user_id   = $request->user_id;
        $course_id = $request->course_id;

        $updater = course_assignments::where('user_id','=',$user_id)->where('course_id','=',$course_id)->update(['status'=>'archive']);

        if(!$updater) {
            $return = array(
                'success' => false,
                'error' => 'Error when trying to archive course assignment user_id: '.$user_id.', course_id: '.$course_id
            );
            return $return;
        }

        $return = array(
            'success' => true,
            'message' => 'Records archived successfully'
        );
        return $return;
    }


    
}
