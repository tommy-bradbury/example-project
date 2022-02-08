<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class courses extends Model
{
    use HasFactory;

    protected $table      = 'courses';
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

    public static function allCoursesById()
    {

        $courses = cache()->remember('courses', 600, function () {
            return courses::select('*')->get();
        });

        if(empty($courses)) {
            $return = array(
                'success' => false,
                'message' => "Courses could not be found right now"
            );
            return $return;
        }

        $return = array(
            'success' => true,
            'courses' => $courses
        );
        return $return;
    }




}
