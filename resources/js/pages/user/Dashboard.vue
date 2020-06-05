<template>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <p class="float-left"> Hi {{this.$auth.user().first_name}}</p>
            </div>
            <div class="card">
                <Navbar></Navbar>
                <div class="card-body">
                    <div class="form-row align-items-center">
                        <div class="form-group col-md-10">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Assignees</th>
                                </tr>
                                </thead>
                                <tbody v-for="task in tasks">
                                <tr>
                                    <td @click="edit">{{task.name}}</td>
                                    <td>{{task.description}}</td>
                                    <td>{{task.author}}</td>
                                    <td> {{task.status}}</td>
                                    <td><span v-for="assignees in task.assignees">{{assignees.first_name+" "+assignees.last_name}}</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">Edit</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">Members</button>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Navbar from '../../components/Navbar.vue'

    export default {
        data() {
            return {
                name: null,
                type: null,
                url: `${process.env.MIX_APP_URL}/api/v1/tasks`,
                tasks: [],
            }
        },
        methods: {
            getAllTasks() {
                fetch(this.url, {
                    method: 'GET',
                    // body: JSON.stringify({name: this.name, type: this.type}),
                    headers: {
                        'Authorization': 'Bearer' + localStorage.getItem('laravel-jwt-auth'),
                        'Content-Type': 'application/json'
                    }
                }).then((res) => res.text())
                    .then((data) => {
                        this.tasks = JSON.parse(data).data;
                        console.log(JSON.parse(data).data)
                    })
                    .catch((err) => console.error(err));
                console.log()
            },
            edit()
            {
                console.log(123);
            },
            showMembers() {

            }

        },
        mounted() {
            this.getAllTasks()
        },
        components: {
            Navbar
        }
    }
</script>