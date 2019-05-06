<template>
    <div class="row mb-4">
        <div class="col-md-5">
            <div class="card bg-dark text-white">
                <div class="card-header"><h1>{{course.title}}</h1></div>
                <div class="card-body">
                    <div class="float-right mb-2">
                        <router-link :to="{ name: 'courses.edit', params: { id: course.id } }" class="btn btn-primary">Edit</router-link>
                        <router-link :to="{ name: 'courses.delete', params: { id: course.id } }" class="btn btn-danger">Delete</router-link>
                    </div>
                    <table class="table">
                        <tr>
                            <th scope="row">Code:</th>
                            <td>{{course.code}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Points:</th>
                            <td>{{course.points}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Level:</th>
                            <td>{{course.level}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card bg-dark text-white">
                <div class="card-header"><h3>Enrolments</h3></div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Student</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :key="enrolment.date" v-for="enrolment in course.enrolments">
                                <th scope="row"><router-link :to="{ name: 'students.view', params: { id: enrolment.student.id } }">{{enrolment.student.name}}</router-link></th>
                                <td>{{enrolment.status}}</td>
                                <td>{{enrolment.date}}</td>
                                <td>{{enrolment.time}}</td>
                                <td>
                                    <router-link :to="{ name: 'enrolments.edit', params: { id: enrolment.id } }" class="btn btn-sm btn-primary">Edit</router-link>
                                    <router-link :to="{ name: 'enrolments.delete', params: { id: enrolment.id } }" class="btn btn-sm btn-danger">Delete</router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                course: {
                    title: '',
                    code: '',
                    description: '',
                    points: '',
                    level: '',
                },
                errors: {},
            }
        },

        mounted() {
            var app = this;
            var id = app.$route.params.id;
            var token = localStorage.getItem('token');
            
            var xhr = axios.get('/api/courses/' + id, {
                headers: { Authorization: "Bearer " + token }
            });
            xhr = xhr.then(function (resp) {
                console.log(resp.data);
                app.course = resp.data;
            });
            xhr = xhr.catch(function (resp) {
                console.log(resp);
                alert('Could not load course');
            });
        },

        methods: {
            
        }
    }
</script>
