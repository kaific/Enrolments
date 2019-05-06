<template>
    <div class="card bg-dark text-white mb-3">
        <div class="card-body">
            <div class="float-left">
                <h1>Enrolments</h1>
            </div>
            <div class="float-right">
                <router-link :to="{ name: 'enrolments.create' }" class="btn btn-success">
                    Enrol a student
                </router-link>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Course</th>
                        <th scope="col">Student</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :key="enrolment.title" v-for="enrolment in enrolments">
                        <th scope="row">{{enrolment.id}}</th>
                        <td><router-link :to="{ name: 'courses.view', params: { id: enrolment.course.id } }">{{enrolment.course.title}}</router-link></td>
                        <td><router-link :to="{ name: 'students.view', params: { id: enrolment.student.id } }">{{enrolment.student.name}}</router-link></td>
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
</template>

<script>
    export default {
        mounted() {
            var app = this;
            var token = localStorage.getItem('token');
            axios.get('/api/enrolments', {
                headers: { Authorization: "Bearer " + token }
            })
            .then(function (resp) {
                console.log(resp.data);
                app.enrolments = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert('Could not load enrolments');
            });
        },
        data() {
            return {
                enrolments: []
            }
        }
    }
</script>
