<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <router-link :to="{name: 'home'}" class="navbar-brand">My App</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto" v-if="!$auth.check()">
                <li class="nav-item" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
                    <router-link :to="{ name : route.path }" :key="key" class="nav-link">{{route.name}}</router-link>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto" v-if="$auth.check()">
                <li class="nav-item">
                    <a class="nav-link" href="#" @click.prevent="$auth.logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
    export default {
        data() {
            return {
                routes: {
                    // UNLOGGED
                    unlogged: [
                        { name: 'Register', path: 'register' },
                        { name: 'Login', path: 'login'}
                    ],
                    // LOGGED USER
                    user: [
                        { name: 'Dashboard', path: 'dashboard' }
                    ],
                },
            }
        },
        methods: {
        },
        mounted() {
            // let redirect = this.$auth.redirect();
            // let app = this;
            // if (this.code) {
            //     this.$auth.oauth2({
            //         code: true,
            //         provider: this.type,
            //         params: {
            //             code: this.code,
            //         },
            //         success: function(res) {
            //             app.success = true;
            //             const redirectTo = 'dashboard';
            //             console.log(redirect);
            //             this.$router.push({name: redirectTo})
            //         },
            //         error: function (res) {
            //             console.log('error ' + res);
            //             console.log(res)
            //         },
            //         rememberMe: true,
            //         fetchUser: true,
            //     });
            // }
        }
    }
</script>
<style>
    .navbar {
        margin-bottom: 30px;
    }
</style>
