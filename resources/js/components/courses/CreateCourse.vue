<template>
    <div class="col-md-6 offset-3">
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
                            <button class="btn btn-primary">Create</button>
                            <router-link to="/" class="btn btn-secondary">Cancel</router-link>
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
            var token = localStorage.getItem('token');
        },

        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newCourse = app.course; //data typed in form is saved inside this

                var token = localStorage.getItem('token');
                //json string
                var xhr = axios.post('/api/courses', newCourse, {
                    headers: { Authorization: "Bearer " + token }
                });
                xhr = xhr.then(function (resp) {
                    //go to router object and push path '/home/courses'
                    app.$router.push({path: '/home/courses'});
                });
                xhr = xhr.catch(function (resp) {
                    app.errors = resp.response.data;
                });
            }
        }
    }
</script>
