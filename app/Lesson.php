<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    

    // Types Constants 
    const VIDEO = 'video';
    const IMAGE = 'image';
    const PDF = 'pdf';
    const LINK = 'link';
    const WORD = 'word';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];


    /**
     * The Units that the lesson belongs to
     */
    public function units(){

        return $this->belongsToMany('App\Unit','unit_lesson')
        ->withPivot('lesson_order')
        ->withTimestamps();

    }

    /**
     * Owner Subjects of this lesson
     */

     public function subjects(){

        return $this->belongsToMany('App\Subject','lesson_subject')
        ->withTimestamps();
     }

     /**
      * Classes owners of this lesson
      */
      public function classes(){


        return $this->belongsToMany('App\ClassRoom','class_lesson','lesson_id','class_id')
        ->withTimestamps();
      }


      /**
       * Courses owners of this lesson
       */
      public function courses(){

        return $this->belongsToMany('App\Course','course_lesson')
                ->withTimestamps();
      }

      /**
       * Attachments Belonging to this Lesson
       */
      public function attachments(){

          return $this->morphMany('App\Attachment','attachmentable');
      }


      /**
       * Comments Belonging to this lesson
       */
      public function comments(){

        return $this->hasMany('App\Comment');
      }

      /**
       * Evaluations For This Lesson
       */
      public function evaluations(){

        return $this->hasMany('App\Evaluation');
      }

      /**
       * Teachers for this Lesson
       */
      public function teachers(){

        return $this->belongsToMany('App\Teacher','lesson_teacher','lesson_id','teacher_id')
          ->withTimestamps();
      }
}
