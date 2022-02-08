<template>
<div>
    <div v-html="course_content"></div>
    <!-- <button type="button" v-on:click="getCourses" style = "height:25px;width:100%;">run</button> -->
</div>
</template> 

<script>
export default {
    name: "MyComponent",
    data: function () {
        return {
            course_content : 'Loading...'
        }
    },
    beforeMount(){
        this.getCourses()
    },
    methods: {
        async getCourses() {

            // get user id from meta tag
            this.user_id = document.querySelector("meta[name='user-id']").getAttribute('content');

            try {
                axios.get('http://example-project.test/api/v1/courses/showAllAssignedCourses/' + this.user_id).then(resp => {
                    this.course_content = '';
                    
                    if(resp.data.courses == undefined) {
                        this.course_content = '<h3>You currently have no assigned courses. Go to <a href="http://example-project.test/courses/admin">My admin</a> to enrol onto a course!</h3>';
                    }
                    for(let i = 0; i <= resp.data.courses.length - 1; i++)
                    {
                        let launchButton = (resp.data.courses[i].completed_at) ? '<div><span>You have already completed this course. Go to <a href="http://example-project.test/courses/admin">My admin</a> to re-enroll</span></div>' : '<div><span>Click Here to launch this course!</span><button type="button" value="' + i + '" class="btn btn-success" style="width:200px;margin-left:10px;">Launch</button></div>';

                        if(i%2 == 0 || i == 0) {
                            this.course_content += '<div class="row" style="height:200px;margin-bottom:10px;">';
                        }
                        this.course_content +=      '<div class="col-6" style="height:200px;">' +
                                                        '<div style="height:100%;background-color:white;border-radius: 15px 50px 30px;padding: 5px 6px;">' +
                                                            '<div class="row" style="height:100%;">' +
                                                                '<div class="col-5">' +
                                                                        '<img src="/' + resp.data.courses[i].course_image + '" style="max-width: 100%; height: 100%;border-radius: 15px 10px 30px 50px;">' +
                                                                '</div>' +
                                                                '<div class="col-7" style="padding-left:10px">' +
                                                                        '<h3>' + resp.data.courses[i].course_name + '</h3>' +
                                                                        // '<p>' + resp.data.courses[i].course_description + '</p>' +
                                                                        launchButton +
                                                                '</div>' +
                                                            '</div>' +
                                                        '</div>' +
                                                    '</div>' +
                                                    '<br />';                                                    
                        if(i%2 == 1 || i == 1) {
                            this.course_content += '</div>';
                        }
                     }
                });

            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>


