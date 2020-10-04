<template>
    <div>
        <div class="container">
            <div class="row">
                <input class="form-control search-bar" type="text" placeholder="Search..." v-model="search">
            </div>
            <div class="row justify-content-center">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">
                            Full Name
                            <i class="fa fa-fw fa-sort"></i>
                        </th>

                        <th scope="col">
                            Email
                            <i class="fa fa-fw fa-sort"></i>
                        </th>

                        <th scope="col">
                            Last Logged In
                            <i class="fa fa-fw fa-sort"></i>
                        </th>

                        <th scope="col">
                            Authorized
                            <i class="fa fa-fw fa-sort"></i>
                        </th>
                        <th scope="col">
                            User Type
                            <i class="fa fa-fw fa-sort"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>
                            {{ date(user.last_login, 'DD-M-yy h:m:s') }}
                        </td>

                        <td>
                            <button
                                @click="toggleAuthorizedBtn(user.id)"
                                type="button" class="btn btn-primary btn-sm"
                            >
                                {{ date(authorized(user), 'DD-M-yy h:m:s') }}
                            </button>
                        </td>

                        <td>
                            <button
                                @click="toggleUserTypeBtn(user.user_type.id, user.id)"
                                type="button"
                                class="btn btn-primary btn-sm"
                            >
                                {{user.user_type.type_name}}
                            </button>
                        </td>
                    </tr>

                    </tbody>
<!--                    table footer-->
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="row">
<!--                                set item display per page-->
                                <div class="col-6">
                                    <label for="perPage">Record per page</label>
                                    <input
                                        class="form-control input-tfoot"
                                        id="perPage"
                                        type="number"
                                        v-model="perPage"
                                    />
                                </div>

<!--                                pagination-->
                                <div class="col-6">
                                    <nav class="nav-tfoot" aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li
                                                v-for="index in lastPage"
                                                :key="index"
                                                :class="`page-item ${index === currentPage ? 'active' : ''}`"
                                            >
                                                <a
                                                    class="page-link"
                                                    @click="changePage(index)"
                                                >
                                                    {{index}}
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!--        comfirmation modal-->
        <div v-if="modalOpen">
            <user-type-modal
                :current-user-id="currentUserId"
                :current-user-type-id="currentUserTypeId"
                v-on:onClose="setModalClose"
                v-on:refetchUser="getUsers"
            ></user-type-modal>
        </div>
    </div>
</template>


<script>
    import UserTypeModal from './UserTypeModal'
    import moment from 'moment';

    export default {
        components: {UserTypeModal},
        data() {
            return {
                users: [],
                perPage: 20,
                modalOpen: false,
                nextPage: null,
                prevPage: null,
                currentPage: 1,
                currentUserTypeId: '',
                currentUserId: '',
                search: '',
                from: 1,
                lastPage: 1
            }
        },
        methods: {
            authorized(user) {
                return user.authorized ? user.authorized : 'Unauthorized';
            },
            //get all user from database
            getUsers() {
                axios.get(`/api/users?perPage=${this.perPage}&page=${this.currentPage}&q=${this.search}`)
                .then((res) => {
                    const {data, from, last_page, next_page_url, prev_page_url} = res.data;
                    this.users = data;
                    this.from = from;
                    this.lastPage = last_page;
                    this.nextPage = next_page_url;
                    this.prevPage = prev_page_url;
                })
                .catch((err) => {
                    console.log(err, "Can't get users. Please check the log for information");
                })
            },

            //toggle user type button
            toggleUserTypeBtn(userTypeId, userId) {
                this.modalOpen = true;
                this.currentUserTypeId = userTypeId;
                this.currentUserId = userId
            },

            //toggle authorized button
            toggleAuthorizedBtn(userId){
                axios.get(`/api/updateUserAuthorized/${userId}`)
                .then((res) => {
                    this.getUsers();
                })
                .catch((err) => {
                    console.log(err);
                })
            },

            //close modal
            setModalClose(value) {
                this.modalOpen = value;
            },

            //format display date
            date(value, format) {
                if (value) {
                    return moment(String(value)).format(format || 'MM/DD/YY')
                }
            },

            changePage(page) {
                this.currentPage = page;
                this.getUsers();
            }

        },

        mounted() {
            this.getUsers();
        },
        watch: {
            perPage(value) {
                this.perPage = value
                this.getUsers();
            },
            search(value) {
                this.search = value;
                this.getUsers();
            }
        },
    }
</script>

<style>
    .nav-tfoot{
        float: right;
    }

    .input-tfoot{
        max-width: 70px;
    }

    label {
        text-align: right;
        clear: both;
        float:left;
        margin-right:15px;
    }

    .search-bar{
        max-width: 550px;
        margin-bottom: 50px;
    }


</style>
