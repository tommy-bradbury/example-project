@extends('layouts.app')

@section('content')


<div class="container">
    <div class="jumbotron" style="margin-bottom:20px;padding:20px;background-color:blueviolet;border-radius: 15px;color:white;">
        <div class="row">
            <div class="col-5">
                <h1>Welcome Back!</h1> <br />
                <h3>What do you want to learn today?</h3>
            </div>
            
            <div class="col-6">
                <div style="margin:auto;width: 64%;border: 3px solid #73AD21;padding: 10px;border-radius: 75px;">
                    <img src="/pics/stationery.png" style="height:125px;border-radius: 75px;">
                    <img src="/pics/notebook.png" style="height:100px;border-radius: 75px;">
                    <img src="/pics/apple.png" style="height:125px;border-radius: 75px;">  
                </div>
            </div>
        </div>
        
    </div>


    <div id="myCourses">
            <my_courses></my_courses>
    </div>


    
</div>
@endsection