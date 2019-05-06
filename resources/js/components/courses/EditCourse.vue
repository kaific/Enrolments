<template>
    <div class="card bg-dark text-white">
        <div class="card-header">Add a Course</div>
        <div class="card-body">
            <form v-on:submit="saveForm()">
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label>Title</label>
                        <!-- v-model : two-way bindings; 1) variable displayed inside will be course.title -->
                        <!-- 2) when input field is changed, it'll be overridden -->
                        <!-- 
                            two-way binding = if one changes, the other does too & vice-versa;
                            if view changes, data changes; if data changes, the view changes
                        -->
                        <input type="text" v-model="course.title" class="form-control">
                        <!-- 
                            if errors for title exist, display the first (only?)
                            error in the array of errors for title 
                        -->
                        <p class="text-danger" v-if="errors.title">{{ errors.title[0] }}</p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Description</label>
                        <textarea v-model="course.description" class="form-control"></textarea>
                        <p class="text-danger" v-if="errors.description">{{ errors.description[0] }}</p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label>Code</label>
                        <input type="text" v-model="course.code" class="form-control">
                        <p class="text-danger" v-if="errors.code">{{ errors.code[0] }}</p>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Points</label>
                        <input type="text" v-model="course.points" class="form-control">
                        <p class="text-danger" v-if="errors.points">{{ errors.points[0] }}</p>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Level</label>
                        <select class="form-control" v-model="course.level">
                            <option value="7">
                                7
                            </option>
                            <option value="8">
                                8
                            </option>
                            <option value="9">
                                9
                            </option>
                            <option value="10">
                                10
                            </option>
                        </select>
                        <p class="text-danger" v-if="errors.level">{{ errors.level[0] }}</p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 form-group">
                        <button class="btn btn-primary">Update</button>
                        <router-link to="/" class="btn btn-secondary">Cancel</router-link>
                    </div>
                </div>
            </form>
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

            axios.get('/api/courses/' + id, {
                headers: { Authorization: "Bearer " + token }
            })
            .then(function (resp) {
                console.log(resp.data);
                app.course = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert('Could not load course');
            });
        },

        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var token = localStorage.getItem('token');
                var id = app.$route.params.id;
                var newCourse = app.course;

                //json string
                axios.put('/api/courses/' + id, newCourse, {
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
