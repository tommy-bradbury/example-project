<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_assignments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->timestamp('assigned_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status',['current','archive'])->default('current');
            $table->string('outcome',100)->nullable();
            $table->charset ='utf8';
            $table->collation = 'utf8_general_ci';
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_assignments');
    }
}
