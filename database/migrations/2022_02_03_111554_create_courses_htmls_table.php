<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesHtmlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_html', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id')->references('id')->on('courses');
            $table->integer('element_number');
            $table->string('lang');
            $table->binary('html');
            $table->unique(['course_id', 'element_number']);
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
        Schema::dropIfExists('courses_html');
    }
}
