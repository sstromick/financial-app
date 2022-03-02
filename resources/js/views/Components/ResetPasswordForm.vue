<template>
<form autocomplete="off" @submit.prevent="resetPassword" method="post" class="form form--resetPassword">
    <div v-if="done === false">

        <h2 class="weight-100 text-30">Reset Password</h2>
        <div class="grid-x grid-margin-y">
            <div class="form__fieldWrapper cell small-12">
                <label for="email" class="form__label display-block visuallyhidden">Email Address</label>
                <input type="email" id="email" class="form-control" placeholder="Email Address" v-model="email" autocomplete="email" required>
            </div>
            <div class="form__fieldWrapper cell small-12">
                <label for="password" class="form__label display-block visuallyhidden">Password</label>
                <input name="password" type="password" id="password" placeholder="Password" v-model="password" required>
            </div>
            <div class="form__fieldWrapper cell small-12">
                <label for="password_confirmation" class="form__label display-block visuallyhidden">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" v-model="password_confirmation" required>
            </div>

            <div class="cell small-12">
                <button type="submit" class="button">Update Password</button>
            </div>
        </div>
    </div>

    <div v-if="done === true" class="cell small-12">
        <h2 class="text-32 weight-100">Password has been reset!</h2>
        <p class="font-book text-20">You can now <button class="text-primary text-20 weight-600" @click="login">log in</button> using your new password, and continue where you left off!</p>
    </div>

</form>
</template>

<script>
export default {
    data() {
        return {
            token: null,
            email: null,
            password: null,
            password_confirmation: null,
            has_error: false,
            done: false,
        }
    },
    methods: {
        resetPassword() {
            window.axios.post('/api/reset-password', {
                    token: this.$route.params.token,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                .then((response) => {
                    this.done = true;
                })
        },
        login() {
            $("#login-modal").foundation('open');
        },
    }
}
</script>
