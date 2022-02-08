@extends('layouts.app')

@section('content')


<div class="container">
<div class="jumbotron" style="margin-bottom:20px;padding:20px;background-color:blueviolet;border-radius: 15px;color:white;">
        <div class="row">
            <div class="col-5">
                <h1>My admin</h1> <br />
                <h3>How can we help you today?</h3>
            </div>
            
            <div class="col-6">
                <div style="margin:auto;width: 33%;border: 3px solid #73AD21;padding: 10px;border-radius: 75px;">
                    <img src="/pics/admin.png" style="height:125px;border-radius: 75px;">
                </div>
            </div>
        </div>
        
    </div>


    <div id="myCourses">
            <course_picker></course_picker>
    </div>
</div>
@endsection