<template>
    <div>
        <div class="card mt-3" v-if="active.dashboard">
            <div class="card-body">
                <h3>
                    Manage User
                    <button
                        class="btn btn-outline-success btn-sm float-right"
                        @click="setActive('createUser')"
                    >
                        <i class="fas fa-plus"></i> User
                    </button>
                </h3>

                <div
                    class="alert-success alert"
                    role="alert"
                    v-if="success_message !== null"
                >
                    {{ success_message }}
                </div>

                <div
                    class="alert alert-danger"
                    role="alert"
                    v-if="danger_message !== null"
                >
                    {{ danger_message }}
                </div>

                <Paginator
                    v-if="results != null"
                    v-bind:results="results"
                    v-on:get-page="getPage"
                ></Paginator>

                <PaginatorDetails
                    v-if="results != null"
                    v-bind:results="results"
                >
                </PaginatorDetails>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Since</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="results !== null">
                        <tr v-for="user in results.data" v-bind:key="user.data">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.user_since }}</td>
                            <td>
                                <div class="btn-group">
                                    <button
                                        class="btn btn-secondary btn-sm"
                                        title="View User Logs"
                                        @click="viewUserLogs(user)"
                                    >
                                        <i class="fas fa-list-alt"></i>
                                    </button>

                                    <button
                                        class="btn btn-sm btn-warning"
                                        title="Edit User"
                                        @click="editUser(user)"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button
                                        class="btn btn-sm btn-secondary"
                                        title="ChangeUSer Password"
                                        @click="changePassword(user)"
                                    >
                                        <i class="fas fa-key"></i>
                                    </button>

                                    <button
                                        class="btn btn-sm btn-danger"
                                        @click="deleteUser(user)"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <Paginator
                    v-if="results != null"
                    v-bind:results="results"
                    v-on:get-page="getPage"
                ></Paginator>
            </div>
        </div>

        <CreateUser
            v-if="active.createUser"
            v-on:view-dashboard="setActive('dashboard')"
            v-on:created-user="flashSuccessAndReload"
        >
            >
        </CreateUser>

        <UserLogs
            v-if="user !== null && active.userLogs"
            v-bind:user="user"
            v-on:view-dashboard="setActive('dashboard')"
        >
        </UserLogs>

        <EditUser
            v-if="user !== null && active.editUser"
            v-bind:user="user"
            v-on:view-dashboard="setActive('dashboard')"
            v-on:user-updated="flashSuccessAndReload"
        >
        </EditUser>

        <ChangeUserPassword
            v-if="user !== null && active.changePassword"
            v-bind:user="user"
            v-on:view-dashboard="setActive('dashboard')"
            v-on:updated-password="flashSuccessAndReload"
            v-on:send-reset-link="flashSuccessAndReload"
        >
        </ChangeUserPassword>
    </div>
</template>

<script>
import Paginator from "../utilities/pagination/Paginator.vue";
import PaginatorDetails from "../utilities/pagination/PaginatorDetails.vue";
import CreateUser from "./CreateUser.vue";
import UserLogs from "./logs/UserLogs.vue";
import EditUser from "./EditUser.vue";
import ChangeUserPassword from "./ChangeUserPassword.vue";

export default {
    components: {
        Paginator,
        PaginatorDetails,
        CreateUser,
        UserLogs,
        EditUser,
        ChangeUserPassword
    },
    mounted() {
        this.getUsers();
    },

    data() {
        return {
            user: null,
            results: null,
            active: {
                dashboard: true,
                createUser: false,
                userLogs: false,
                editUser: false,
                changePassword: false
            },
            params: {
                page: 1
            },
            success_message: null,
            danger_message: null
        };
    },
    methods: {
        editUser: function(user) {
            this.user = user;
            this.setActive("editUser");
        },
        changePassword: function(user) {
            this.user = user;
            this.setActive("changePassword");
        },
        getUsers: function() {
            axios.get("/data/users", { params: this.params }).then(response => {
                this.results = response.data.results;
            });
        },
        deleteUser: function(user) {
            let r = confirm(
                "Are you sure you want to delete  " +
                    user.name +
                    "  from the system"
            );
            if (r) {
                axios
                    .post("data/users/" + user.id, { _method: "DELETE" })
                    .then(response => {
                        this.flashSuccessAndReload("Successfully deleted User");
                    })
                    .catch(errors => {
                        if (errors.response.status === 403) {
                            this.flashDanger("Unauthorized to Delete");
                        }
                    });
            }
        },
        viewUserLogs: function(user) {
            this.user = user;
            this.setActive("userLogs");
        },
        getPage: function(event) {
            this.params.page = event;
            window.scrollTo(0, 0);
            this.getUsers();
        },
        setActive: function(component) {
            Object.keys(this.active).forEach(key => (this.active[key] = false));
            this.active[component] = true;
        },
        flashSuccessAndReload: function(event) {
            this.setActive("dashboard");
            this.flashSuccess(event);
            this.getUsers();
        },
        flashSuccess: function(message) {
            this.success_message = message;
            setTimeout(() => {
                this.success_message = null;
            }, 5000);
        },
        flashDanger: function(message) {
            this.danger_message = message;
            setTimeout(() => {
                this.danger_message = null;
            }, 5000);
        }
    }
};
</script>

<style></style>
