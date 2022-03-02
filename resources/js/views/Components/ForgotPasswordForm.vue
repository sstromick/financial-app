<template>
<form @submit.prevent="requestResetPassword" method="POST" class="form form--forgotPassword" :class="classes">
    <div class="grid-x grid-margin-y" v-if="done === false">
        <div class="form__fieldWrapper cell small-12">
            <h2 class="text-32 weight-100">Reset Password</h2>
            <label class="form__label display-block visuallyhidden" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" v-model="email" autocomplete="email" required>
        </div>

        <div class="cell small-12">
            <button type="submit" class="button">Send Password Reset Link</button>
        </div>
    </div>

    <div v-if="done === true">
        <h2 class="text-32 weight-100">Password reset link sent!</h2>
        <p class="font-book text-20">Look for our email in your inbox. Open it, then click the "Reset Password" button to start the process of resetting your password!</p>
    </div>
</form>
</template>

<script>
export default {
    data() {
        return {
            email: null,
            has_error: false,
            csrf: null,
            classes: null,
            done: false,
        }
    },
    methods: {
        requestResetPassword() {
            window.axios.post('/api/forgot-password', {
                    email: this.email
                })
                .then((response) => {
                    this.done = true;
                })
        }
    },
    mounted() {}
}
</script>
