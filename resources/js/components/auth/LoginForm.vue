<template>
    <div class="row my-5">
        <div class="col-4 offset-4">
            <div class="card bg-dark text-white">
                <div class="card-header h1">Login</div>

                <div class="card-body">
                    <form v-on:submit="login()">
                        <div class="form-row form-group">
                            <label>Email</label>
                            <input type="text" v-model="user.email" class="form-control bg-dark text-white">
                        </div>
                        <div class="form-row form-group">
                            <label>Password</label>
                            <input type="password" v-model="user.password" class="form-control bg-dark text-white">
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <button class="btn btn-success btn-lg">LOGIN</button>
                                <p class="text-danger" v-if="errorMessage != ''">{{ errorMessage }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                user: {
                    email: '',
                    password: ''
                },
                errorMessage: ''
            }
        },
        mounted() {
            var app = this;
            if (localStorage.getItem('token') !== null) {
                app.$router.replace({name: 'home'});
            }
        },
        methods: {
            login() {
                event.preventDefault();
                var app = this;
                axios.post('/api/login', app.user)
                    .then(function (resp) {
                        localStorage.setItem('token', resp.data.token);
                        app.$router.push({name: 'home'});
                    })
                    .catch(function (resp) {
                        app.errorMessage = "It didn't work!";
                    });
            }
        }
    }
</script>
