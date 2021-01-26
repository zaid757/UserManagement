<template>
    <div>
        <div class="card mt-3">
            <div class="card-body">
                <h3>
                    <button
                        class="btn btn-sm btn-outline-primary mr-3"
                        @click="$emit('view-dashboard')"
                    >
                        <i class="fas fa-chevron-left"></i>Back
                    </button>
                    Update Email {{ user.email }}
                </h3>
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

                <div class="form-group row">
                    <label for="" class="col-3">New Email</label>
                    <div class="col-9">
                        <input
                            type="email"
                            class="form-control"
                            v-model="data.email"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-3"
                        >Enter Password to Confirm</label
                    >
                    <div class="col-9">
                        <input
                            type="password"
                            v-model="data.password"
                            class="form-control"
                        />
                    </div>
                </div>

                <button class="btn btn-primary" @click.prevent="updateEmail">
                    Update Email
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.data.email = this.user.email;
    },
    props: ["user"],
    data() {
        return {
            data: {
                email: "",
                password: ""
            },
            errors: []
        };
    },
    methods: {
        updateEmail: function() {
            this.errors = [];
            axios
                .post("/data/accounts/updates/email/" + this.user.id, {
                    _method: "PUT",
                    email: this.data.email,
                    password: this.data.password
                })
                .then(response => {
                    this.$emit(
                        "updated-email",
                        "Successfully Updated email for " + this.user.name
                    );
                })
                .catch(errors => {
                    console.dir(errors);
                    if (errors.response.status === 403) {
                        this.errors.push(
                            "NOt Authorized to change this data , Please Verify you password is correct"
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
        }
    }
};
</script>

<style></style>
