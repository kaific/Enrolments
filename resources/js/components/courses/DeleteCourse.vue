<template>
    <div class="card bg-dark text-white">
        <div class="card-header">Delete Course</div>
        <div class="card-body">
            <form v-on:submit="saveForm()">
                Are you sure you want to delete this course?
                <p class="ml-3">{{course.title}}</p>
                <div class="form-row">
                    <div class="col-md-12 form-group">
                        <button class="btn btn-primary">Delete</button>
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

                //json string
                axios.delete('/api/courses/' + id, {
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