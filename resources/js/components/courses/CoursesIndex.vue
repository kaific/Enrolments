<template>
    <div class="card bg-dark text-white mb-3">
        <div class="card-body">
            <div class="float-left">
                <h1>Courses</h1>
            </div>
            <div class="float-right">
                <router-link :to="{ name: 'courses.create' }" class="btn btn-success">
                    Add a course
                </router-link>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Code</th>
                        <th scope="col">Points</th>
                        <th scope="col">Level</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :key="course.title" v-for="course in courses">
                        <th scope="row">{{course.id}}</th>
                        <td>
                            <router-link :to="{ name: 'courses.view', params: { id: course.id } }">
                                {{course.title}}
                            </router-link>
                        </td>
                        <td>{{course.code}}</td>
                        <td>{{course.points}}</td>
                        <td>{{course.level}}</td>
                        <td>
                            <router-link :to="{ name: 'courses.edit', params: { id: course.id } }" class="btn btn-sm btn-primary">Edit</router-link>
                            <router-link :to="{ name: 'courses.delete', params: { id: course.id } }" class="btn btn-sm btn-danger">Delete</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var app = this;
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
        },
        data() {
            return {
                courses: []
            }
        }
    }
</script>
