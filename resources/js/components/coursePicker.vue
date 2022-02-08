<template>
    <div class="container" style="margin:auto;border: 3px solid #215ead;padding: 10px;border-radius: 15px 50px 30px;background-color: #7593b9;">
    
        <div class="container" style="width: 80%;padding: 10px;background-color: #a4b1ce;border-radius: 15px 50px 30px;">
            <div class="row">
                <div class="col-1" style="margin:auto;">
                    <img src="/pics/enroll.png" style="height:100px;">
                </div>

                <div class="col-11">
                    <form style="margin:auto;width: 85%;">
                        <h1>
                            Assign/Reassign a course
                        </h1>
                        <div class="form-group">
                            <label for="locationToGroupBySelector">Please select a course to (re)assign</label>
                            <select class="form-control" id="locationToGroupBySelector" v-html="coursePickerList" v-model="course_id_selected">
                            
                            </select>
                        </div>
                        <br />
                        <button type="button" class="btn btn-success" v-on:click="requestCourseProvisionment" style = "width:100%;">(re)assign course</button>
                    </form>
                </div>
            </div>
        </div>
        <br /><br />
        <div class="container" style="width: 80%;padding: 10px;background-color: #a4b1ce;border-radius: 15px 50px 30px;">

                    <div class="row">
                <div class="col-1" style="margin:auto;">
                    <img src="/pics/delete.png" style="height:100px;">
                </div>

                <div class="col-11">
                    <form style="margin:auto;width: 85%;">
                        <h1>
                            Remove a course
                        </h1>
                        <div class="form-group">
                            <label for="locationToGroupBySelector">Please select a course to remove</label>
                            <select class="form-control" id="locationToGroupBySelector" v-html="coursesAssignedList" v-model="courses_id_archiver">
                            
                            </select>
                        </div>
                        <br />
                        <button type="button" class="btn btn-warning" v-on:click="archiveCourse" style = "width:100%;">remove course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template> 

<script>
export default {
    name: "MyComponent",
    data: function () {
        return {
            course_id_selected  : "",
            coursePickerList    : "",
            coursesAssignedList : "",
            courses_id_archiver : "",
            message             : ""
        }
    }, 
    beforeMount(){
        this.getAllCoursesById(),
        this.getAllAssignedCourses()
    },
    methods: {

        // retrieve all courses available for (re)assignment
        async getAllCoursesById() {
            try {
                const apiRes = await axios.post(
                    "http://example-project.test/api/v1/courses/allCourseInfo"
                );

                // add an option in the select list tied to this.coursePickerList
                for(let i = 0; i <= apiRes.data.courses.length - 1; i++)
                {
                    this.coursePickerList += '<option value="' + apiRes.data.courses[i].id + '">' + apiRes.data.courses[i].course_name + '</option>';
                }
            } catch (error) {
                console.log(error);
            }
        },
        
        // request a (re)assignment
        async requestCourseProvisionment() {

            this.user_id = document.querySelector("meta[name='user-id']").getAttribute('content');

            const payload = {
                course_id : this.course_id_selected,
                user_id   : this.user_id,
            };

            try {
                const apiRes = await axios.post(
                    "http://example-project.test/api/v1/courses/assignCourse", payload
                );
                // JSON responses are automatically parsed.
                if(apiRes.data.success == false) {
                    alert(apiRes.data.error);
                } else {
                    alert(apiRes.data.message);
                }

                window.location.href = 'http://example-project.test/courses';

            } catch (error) {
                console.log(error);
            }
        },
        

        // retrieve all courses currently assigned and apply them for 
        async getAllAssignedCourses() {

            // get user id from meta tag
            this.user_id = document.querySelector("meta[name='user-id']").getAttribute('content');

            // get all courses assigned and add them to the select tied to this.coursesAssignedList
            try {
                axios.get('http://example-project.test/api/v1/courses/showAllAssignedCourses/' + this.user_id).then(resp => {

                    if(resp.data.courses != undefined) {
                        for(let i = 0; i <= resp.data.courses.length - 1; i++)
                        {
                            this.coursesAssignedList += '<option value="' + resp.data.courses[i].course_id + '">' + resp.data.courses[i].course_name + '</option>';
                        }
                    }
                });
            } catch (error) {

                console.log(error);
            }
        },

        
        // remove a course assignment
        async archiveCourse() {

            this.user_id = document.querySelector("meta[name='user-id']").getAttribute('content');

            const payload = {
                course_id : this.courses_id_archiver,
                user_id   : this.user_id,
            };

            try {
                const apiRes = await axios.post(
                    "http://example-project.test/api/v1/courses/archive", payload
                );
                // JSON responses are automatically parsed.
                if(apiRes.data.success == false) {
                    alert(apiRes.data.error);
                } else {
                    alert(apiRes.data.message);
                }
                location.reload();
            } catch (error) {
                console.log(error);
            }
        },
    }
}
</script>