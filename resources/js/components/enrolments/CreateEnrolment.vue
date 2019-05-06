<template>
    <div class="col-md-6 offset-3">
        <div class="card bg-dark text-white">
            <div class="card-header">Edit enrolment</div>
            <div class="card-body">
                <form v-on:submit="saveForm()">
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label>Date</label>
                            <input type="date" v-model="enrolment.date" class="form-control">
                            <p class="text-danger" v-if="errors.date">{{ errors.date[0] }}</p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Time</label>
                            <input type="time" v-model="enrolment.time" class="form-control">
                            <p class="text-danger" v-if="errors.time">{{ errors.time[0] }}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select class="form-control" v-model="enrolment.status">
                                <option value="attending">
                                    attending
                                </option>
                                <option value="withdrawn">
                                    withdrawn
                                </option>
                                <option value="deferred">
                                    deferred
                                </option>
                                <option value="registered">
                                    registered
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.status">{{ errors.status[0] }}</p>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Course</label>
                            <select v-model="enrolment.course_id" class="form-control">
                                <option v-for="course in courses" :key="course.id" :value="course.id">
                                    {{ course.title }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.course_id">{{ errors.course_id[0] }}</p>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Student</label>
                            <select v-model="enrolment.student_id" class="form-control">
                                <option v-for="student in students" :key="student.id" :value="student.id">
                                    {{ student.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.student_id">{{ errors.student_id[0] }}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 form-group">
                            <button class="btn btn-primary">Update</button>
                            <router-link :to="{ name: 'enrolments' }" class="btn btn-secondary">Cancel</router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // data property in view should be a function that should return an object
        data: function () {
            return {
                // object has two properties; course & errors - automatic two-way binding
                enrolment: {},
                errors: {},
                students: [],
                courses: []
            }
        },

        mounted() {
            var app = this;
            var id = app.$route.params.id;
            var token = localStorage.getItem('token');

            axios.get('/api/courses', {
                headers: { Authorization: "Bearer " + token }
            })
            .then(function (resp) {
                console.log(resp.data);
                app.courses = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert('Could not load courses');
            });

            axios.get('/api/students', {
                headers: { Authorization: "Bearer " + token }
            })
            .then(function (resp) {
                console.log(resp.data);
                app.students = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert('Could not load students');
            });
        },

        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var token = localStorage.getItem('token');
                var id = app.$route.params.id;
                var newEnrolment = app.enrolment;

                //json string
                axios.post('/api/enrolments', newEnrolment, {
                headers: { Authorization: "Bearer " + token }
            })
                    .then(function (resp) {
                        //go to router object and push path '/'
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        app.errors = resp.response.data;
                    });
            }
        }
    }
</script>
