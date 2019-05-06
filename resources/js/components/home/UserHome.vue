<template>
    <div class="content">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-between mb-2">
            <a class="navbar-brand" href="#">Enrolments Admin</a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link :to="{ name: 'courses' }" class="nav-link">Courses</router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'students' }" class="nav-link">Students</router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'enrolments' }" class="nav-link">Enrolments</router-link>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a v-on:click="logout()" class="nav-link btn">Logout</a>
                </li>
            </ul>
        </nav>
        <!-- <nav class="my-3">
            <router-link :to="{ name: 'courses' }" class="btn btn-primary">Courses</router-link>
            <router-link :to="{ name: 'students' }" class="btn btn-primary">Students</router-link>
            <router-link :to="{ name: 'enrolments' }" class="btn btn-primary">Enrolments</router-link>
            <a v-on:click="logout()" class="btn btn-danger text-white float-right">Logout</a>
        </nav> -->
        <router-view></router-view>
        <footer class="bg-dark text-white">
            <div class="footer-copyright text-center my-2 py-3">
                Application Created by <strong>Kai (Adrian) Fic - N00162203</strong>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
            }
        },
        mounted() {
            var app = this;
            if (localStorage.getItem('token') === null) {
                app.$router.replace({name: 'login'});
            }
            app.$router.push({name: 'courses'});
        },
        methods: {
            logout() {
                var app = this;
                var token = localStorage.removeItem('token');
                app.$router.push({ name: 'login' });
            }
        }
    }
</script>
