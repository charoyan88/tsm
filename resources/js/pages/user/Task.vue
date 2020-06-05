<template>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <p class="float-left"> Hi {{this.$auth.user().name}}</p>
            </div>
            <div class="card">
                <Navbar></Navbar>
                <div class="card-body">
                    <div class="form-row align-items-center">
                        <div class="form-group col-md-3">
                        <label for="inputTaskName">Task Name</label>
                        <input type="text" class="form-control" id="inputTaskName" v-model="name">
                        </div>
                        <div class="form-group col-md-4">
                        <label for="inputTaskDescription">Task Description</label>
                        <input type="text" class="form-control" id="inputTaskDescription" v-model="description">
                        </div>
                        <div class="form-group col-md-3">
                            <v-select
                                    v-model="assignees"
                                    :items="members"
                                    item-text="name"
                                    item-value="id"
                                    :menu-props="{ maxHeight: '400' }"
                                    label="Select"
                                    multiple
                                    hint=""
                                    persistent-hint
                            ></v-select>
                        </div>
                        <div class="col-auto">
                        <button class="btn btn-primary mt-3" @click="addTask">Add</button>
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
                name: "",
                description: "",
                url: `${process.env.MIX_APP_URL}/api/v1/tasks`,
                usersUrl: `${process.env.MIX_APP_URL}/api/v1/users`,
                assignees: [],
                members: [

                ],
            }
        },
        methods: {
            addTask() {
                fetch(this.url, {
                    method: 'POST',
                    body: JSON.stringify({name: this.name, description: this.description,assignees:this.assignees}),
                    headers: {
                        'Authorization': 'Bearer' + localStorage.getItem('laravel-jwt-auth'),
                        'Content-Type': 'application/json'
                    }
                }).then((res) => res.text())
                    .then((data) => {
                        console.log(data)
                    })
                    .catch((err) => console.error(err));
                console.log()
            },
            getMembers()
            {
                fetch(this.usersUrl, {
                    method: 'GET',
                    // body: JSON.stringify({name: this.name, type: this.type}),
                    headers: {
                        'Authorization': 'Bearer' + localStorage.getItem('laravel-jwt-auth'),
                        'Content-Type': 'application/json'
                    }
                }).then((res) => res.text())
                    .then((data) => {
                        let members = JSON.parse(data).data;
                        members.forEach((element)=>{
                            this.members.push({id:element.id,name:element.first_name+" "+element.last_name})
                        });
                        console.log(this.members)
                    })
                    .catch((err) => console.error(err));
            }
        },
        mounted() {
            this.getMembers();
        },

        components: {
            Navbar
        }
    }
</script>