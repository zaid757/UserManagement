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
                    Create new user
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

                <form @submit="formSubmit" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="" class="col-3">Name</label>
                        <div class="col-9">
                            <input
                                type="text"
                                class="form-control"
                                v-model="data.name"
                            />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-3">Email</label>
                        <div class="col-9">
                            <input
                                type="email"
                                class="form-control"
                                v-model="data.email"
                            />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-3">Role</label>
                        <div class="col-9">
                            <select class="form-control" v-model="data.role">
                                <option :value="'user'">User</option>
                                <option :value="'admin'">Admin</option></select
                            >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-3">Password</label>
                        <div class="col-9">
                            <input
                                type="password"
                                v-model="data.password"
                                class="form-control"
                                placeholder="Must contain a lower and uppercase letter a number and a special character"
                            />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-3">Confirm Password</label>
                        <div class="col-9">
                            <input
                                type="password"
                                v-model="data.confirm_password"
                                class="form-control"
                            />
                        </div>
                    </div>

                    <div class="class form-group row">
                        <label for="" class="col-3">Upload Picture </label>
                        <div class="col-9">
                            <input
                                type="file"
                                class="form-control"
                                v-on:change="onChange"
                            />
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        Create User
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                name: "",
                image: "",
                email: "",
                role: "user",
                password: "",
                confirm_password: ""
            },
            errors: []
        };
    },
    methods: {
        onChange(e) {
            this.image = e.target.files[0];
        },
        formSubmit(e) {
            e.preventDefault();
            let existingObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            let data = new FormData();
            data.append("image", this.image);
            data.append("role", this.data.role);
            data.append("name", this.data.name);
            data.append("email", this.data.email);
            data.append("password", this.data.password);
            data.append("confirm_password", this.data.confirm_password);
            this.errors = [];
            axios
                .post("/data/users", data)
                .then(response =>
                    this.$emit(
                        "created-user",
                        "Successfully Created user:  " +
                            response.data.user.name +
                            " | email: " +
                            response.data.user.email
                    )
                )
                .catch(errors => {
                    if (errors.response.status === 422) {
                        this.flashErrors(errors.response.data.errors);
                    }
                    if (errors.response.status === 403) {
                        this.errors = [
                            "You are not authorized to create Users"
                        ];
                    }
                });
        },
        flashErrors: function(errors) {
            for (const [key, value] of Object.entries(errors)) {
                for (let item in value) {
                    this.errors.push(value[item]);
                }
            }
        }
    }
};
</script>

<style></style>
