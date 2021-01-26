<template>
    <div>
        <div class="card mt-3" v-if="active.dashboard">
            <div class="card-body">
                <h3>User Account Settings</h3>

                <hr />

                <div
                    class="alert alert-warning"
                    role="alert"
                    v-if="errors.length > 0"
                >
                    <ul>
                        <li v-for="error in errors" v-bind:key="error.data">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <div
                    class="alert alert-success"
                    role="alert"
                    v-if="success_message !== null"
                >
                    {{ success_message }}
                </div>

                <table class="table table-hover table-borderless">
                    <tbody v-if="user !== null">
                        <tr>
                            <th>Name</th>

                            <td v-if="!active.editname">
                                {{ user.name }}
                                <span
                                    class="badge badge-warning ml-3"
                                    style="cursor:pointer"
                                    @click="active.editName = true"
                                >
                                    Update
                                </span>
                            </td>

                            <td v-if="active.editName">
                                <div class="form-group form-inline">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="data.name"
                                    />
                                    <button
                                        class="btn btn-primary btn-sm ml-2"
                                        @click.prevent="updateName"
                                    >
                                        Update
                                    </button>
                                    <button
                                        class="btn btn-danger btn-sm ml-2"
                                        @click.prevent="active.editName = false"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                {{ user.email }}
                                <span
                                    class="badge badge-warning ml-3"
                                    style="cursor:pointer"
                                    @click="setActive('updateEmail')"
                                    >Update</span
                                >
                            </td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ user.role.ucFirst() }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>
                                **********
                                <span
                                    class="ml-3 badge badge-primary"
                                    style="cursor: pointer"
                                    @click="sendResetLink"
                                    >Send Reset Link</span
                                >
                            </td>
                        </tr>
                        <tr>
                            <th>User Since</th>
                            <td>{{ user.user_since }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <UpdateEmail
            v-if="active.updateEmail && user !== null"
            v-bind:user="user"
            v-on:view-dashboard="setActive('dashboard')"
            v-on:updated-email="flashSuccessAndReload"
        >
        </UpdateEmail>
    </div>
</template>

<script>
import UpdateEmail from "./UpdateEmail.vue";

export default {
    components: {
        UpdateEmail
    },

    mounted() {
        this.getUser();
    },
    data() {
        return {
            user: null,
            data: {
                name: ""
            },
            active: {
                dashboard: true,
                updateEmail: false,
                editName: false
            },
            errors: [],
            success_message: null
        };
    },

    methods: {
        sendResetLink: function() {
            axios
                .post("/data/users/updates/send-reset-link/" + this.user.id)
                .then(
                    response =>
                        (this.success_message =
                            "succesfully send reset link to your email.please follow the instructions ")
                );
        },
        getUser: function() {
            axios.get("/data/accounts/user").then(response => {
                this.user = response.data.user;
                this.data.name = this.user.name;
            });
        },
        updateName: function() {
            this.errors = [];
            axios
                .post("/data/accounts/updates/name/" + this.user.id, {
                    _method: "PUT",
                    name: this.data.name
                })
                .then(response => {
                    this.flashSuccessAndReload("Successfully updated name");
                })
                .catch(errors => {
                    if (errors.response.status === 403) {
                        this.errors.push(
                            "You are not authorized to change the name"
                        );
                    }
                    if (errors.response.status === 422) {
                        Object.keys(errors.response.data.errors).forEach(
                            key => {
                                errors.response.data.errors[key].forEach(err =>
                                    this.errors.push(err)
                                );
                            }
                        );
                    }
                });
        },

        setActive: function(component) {
            Object.keys(this.active).forEach(key => (this.active[key] = false));
            this.active[component] = true;
        },
        flashSuccessAndReload: function(message) {
            this.setActive("dashboard");
            this.flashSuccess(message);
            this.getUser();
        },
        flashSuccess: function(message) {
            this.success_message = message;
            setTimeout(() => {
                this.success_message = null;
            }, 5000);
        }
    }
};
</script>

<style></style>
