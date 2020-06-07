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
                            <div>
                                <v-data-table
                                        :headers="headers"
                                        :items="tasks"
                                        :page.sync="page"
                                        :items-per-page="itemsPerPage"
                                        hide-default-footer
                                        @page-count="pageCount = $event"
                                >
                                    <template v-slot:body="{ items, headers }">
                                        <tbody>
                                        <tr v-for="(item,idx,k) in items" :key="idx">
                                            <td v-for="(header,key) in headers" :key="key">
                                                <v-edit-dialog v-if="header.value =='assignees'"

                                                >
                                                    <v-select
                                                        v-model="item[header.value]"
                                                        :items="members"
                                                        item-text="name"
                                                        item-value="id"
                                                        :menu-props="{ maxHeight: '400' }"
                                                        multiple
                                                        hint=""
                                                        @change="selectChange(item.id,item[header.value])"
                                                        persistent-hint
                                                ></v-select>

                                                </v-edit-dialog>
                                                <v-edit-dialog v-else-if="header.value =='author'"

                                                > {{item[header.value]}}

                                                </v-edit-dialog>
                                                <v-edit-dialog v-else
                                                               :return-value.sync="item[header.value]"
                                                               @save="save(item.id,header.value,item[header.value],)"
                                                               @cancel="cancel"
                                                               @open="open"
                                                               @close="close"
                                                               large
                                                > {{item[header.value]}}
                                                    <template v-slot:input>
                                                        <v-text-field
                                                                v-model="item[header.value]"
                                                                label="Edit"
                                                                single-line
                                                        ></v-text-field>
                                                    </template>
                                                </v-edit-dialog>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </template>
                                </v-data-table>
                                <div class="text-center pt-2" >
                                    <v-pagination v-model="page" :length="pageCount"></v-pagination>
                                </div>
                            </div>
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
                usersUrl: `${process.env.MIX_APP_URL}/api/v1/users`,
                page: 1,
                pageCount: 1,
                itemsPerPage: 5,
                headers: [
                    {
                        text: 'Name',
                        align: 'start',
                        sortable: false,
                        value: 'name',
                    },
                    {text: 'Description', value: 'description'},
                    {text: 'Author', value: 'author'},
                    {text: 'Status', value: 'status'},
                    {text: 'Assignees', value: 'assignees'},
                ],
                tasks: [],
                members:[],
                assignees:[],
            }
        },
        methods: {
            getAllTasks() {
                let url = new URL(this.url),
                    params = {
                        user_id: this.$auth.user().id,
                    };
                Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
                console.log(url)
                fetch(url, {
                    method: 'GET',
                    // body: JSON.stringify({name: this.name, type: this.type}),
                    headers: {
                        'Authorization': 'Bearer' + localStorage.getItem('laravel-jwt-auth'),
                        'Content-Type': 'application/json'
                    }
                }).then((res) => res.text())
                    .then((data) => {
                        this.tasks = JSON.parse(data).data;
                        this.pageCount = this.tasks.length/this.itemsPerPage;
                    })
                    .catch((err) => console.error(err));
                console.log()
            },
            save(id,item,value) {
                fetch(this.url+'/'+id, {
                    method: 'PUT',
                    body: JSON.stringify({item: item, value: value}),
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
            cancel() {

            },
            open() {

            },
            close() {

            },
            selectChange(id,assignees)
            {
                fetch(this.url+'/'+id, {
                    method: 'PUT',
                    body: JSON.stringify({item:"assignees",value: assignees}),
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
                    })
                    .catch((err) => console.error(err));
            },

        },
        mounted() {
            this.getAllTasks(this.$auth.user().id);
            this. getMembers();
        },
        components: {
            Navbar
        }
    }
</script>