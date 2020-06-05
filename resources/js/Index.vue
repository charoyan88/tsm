<template>
    <v-app>
        <div id="main">
            <header id="header">
                <Menu></Menu>
            </header>
            <div id="content">
                <router-view></router-view>
            </div>
        </div>
    </v-app>
</template>
<script>
    import Menu from './components/Menu.vue'

    export default {
        data() {
            return {
                //
            }
        },
        components: {
            Menu,
        }
    }
</script>