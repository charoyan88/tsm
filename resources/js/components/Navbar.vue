<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" >
                        <router-link :to="{name: 'dashboard'}" class="navbar-link">My Tasks</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" >
                        <router-link :to="{name: 'task'}" class="navbar-link">Create Task</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>
