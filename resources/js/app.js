
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//var Vue = require('vue');
import Vue from 'vue';
import VueRouter from 'vue-router';
import LoginForm from './components/auth/LoginForm.vue';
import UserHome from './components/home/UserHome.vue';

import CoursesIndex from './components/courses/CoursesIndex.vue';
import CreateCourse from './components/courses/CreateCourse.vue';
import EditCourse from './components/courses/EditCourse.vue';
import DeleteCourse from './components/courses/DeleteCourse.vue';
import ViewCourse from './components/courses/ViewCourse.vue';

import StudentsIndex from './components/students/StudentsIndex.vue';
import ViewStudent from './components/students/ViewStudent.vue';

import EnrolmentsIndex from './components/enrolments/EnrolmentsIndex.vue';
import CreateEnrolment from './components/enrolments/CreateEnrolment.vue';
import EditEnrolment from './components/enrolments/EditEnrolment.vue';
import DeleteEnrolment from './components/enrolments/DeleteEnrolment.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);

const routes = 
[
    {
        path: '/',
        name: 'login',
        component: LoginForm,
    },
    {
        path: '/home',
        name: 'home',
        component: UserHome,
        children: [
            {
                path: 'courses',
                name: 'courses',
                component: CoursesIndex
            },
            {
                path: 'courses/create',
                name: 'courses.create',
                component: CreateCourse
            },
            {
                path: 'courses/:id/edit',
                name: 'courses.edit',
                component: EditCourse
            },
            {
                path: 'courses/:id/delete',
                name: 'courses.delete',
                component: DeleteCourse
            },
            {
                path: 'courses/:id',
                name: 'courses.view',
                component: ViewCourse
            },
            {
                path: 'students',
                name: 'students',
                component: StudentsIndex
            },
            {
                path: 'students/:id',
                name: 'students.view',
                component: ViewStudent
            },
            {
                path: 'enrolments',
                name: 'enrolments',
                component: EnrolmentsIndex
            },
            {
                path: 'enrolments/create',
                name: 'enrolments.create',
                component: CreateEnrolment
            },
            {
                path: 'enrolments/:id/edit',
                name: 'enrolments.edit',
                component: EditEnrolment
            },
            {
                path: 'enrolments/:id/delete',
                name: 'enrolments.delete',
                component: DeleteEnrolment
            },
        ]
    },
];

//Vue.component('books-index', require('./components/books/BooksIndex.vue'));
const router = new VueRouter({
    //routes: routes
    routes 
    //-> shorthand for "routes: routes" (latter being the const from above)
});

const app = new Vue({
    el: '#app',
    //router: router
    router 
    //-> shorthand for "router: router" (latter being the const from above)
});
