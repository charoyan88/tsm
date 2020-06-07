<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-body">
                <Navbar></Navbar>
                <div class="card-body">
                    <div class="form-row align-items-center">
                        <div class="form-group col-md-5">
                            <input type="text" class="form-control" id="keyword" v-model="keyword">
                        </div>
                        <div class="form-group col-md-3">
                            <button class="btn btn-dark" @click="search">Search</button>
                        </div>
                        <div id="data-table" style="display: none">
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
                                                <span v-for="(assigne,key) in item[header.value]">{{assigne.email}}<span v-if="key < item[header.value].length-1">,</span></span>

                                            </v-edit-dialog>


                                            <v-edit-dialog v-else
                                            > {{item[header.value]}}

                                            </v-edit-dialog>
                                        </td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-data-table>
                            <div class="text-center pt-2">
                                <v-pagination v-model="page" :length="pageCount"></v-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Navbar from '../components/Navbar.vue'

    export default {
        data() {
            return {
                keyword: "",
                url: `${process.env.MIX_APP_URL}/api/v1/tasks`,
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
                assignees: [],
            }
        },
        methods: {
            search() {
                let url = this.url + '/' + this.keyword;
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
                        this.pageCount = this.tasks.length / this.itemsPerPage;
                        document.getElementById('data-table').style.display="block";
                    })
                    .catch((err) => console.error(err));
                console.log()
            },
        },
        mounted() {

        },
        components: {
            Navbar
        }
    }
</script>
