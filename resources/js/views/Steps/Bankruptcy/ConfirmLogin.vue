<template>
<section class="section py-4">
    <div class="grid-container mt-6">

        <div class="grid-container grid-container--smaller text-center">
            <h1 class="text-54 weight-100 text-darkGreen">You're almost there!</h1>

            <p class="font-book text-25">Confirm your email address and password to finish your Bankruptcy Counseling session. All of your information will be securely submitted to one of our financial counselors for review.</p>
        </div>

        <form id="submission-form" method="POST" @submit.prevent="onSubmit($event)" class="form mt-4 grid-x grid-margin-x grid-margin-y" v-if="showForgotPasswordForm === false">

            <div class="form__fieldWrapper display-flex flex-wrap cell small-12">
                <input name="email" v-model.trim="user.email" placeholder="Email" type="email" autocomplete="email">

                <label class="form__label display-block visuallyhidden" for="email">Email</label>
            </div>

            <div class="form__fieldWrapper display-flex flex-wrap cell small-12">
                <input name="password" v-model="user.password" placeholder="Password" type="password" autocomplete="password">

                <label class="form__label display-block visuallyhidden" for="password">Password</label>
            </div>
            <div class="cell small-12">
                <p class="text-center text-18 font-book weight-300">As you work your way through our financial analysis, fill out as much information as you can. If you reach a question you aren’t able to answer, you have the ability to skip any step in the process.</p>
            </div>

            <div class="form__fieldWrapper cell small-12">
                <div v-if="message" class="alert text-error text-center weight-500 text-20">{{ message }}</div>
                <div class="flex-center mt-5 mb-3">
                    <button value="submit" name="submit" type="submit" class="button button--stepNav">Confirm Login</button>
                </div>

                <div class="flex-center mb-3">
                    <button type="button" @click="forgotPassword(true)" class="text-17 weight-600 underline uppercase text-secondary">Forgot Password?</button>
                </div>

                <div class="flex-center">
                    <back-button></back-button>
                </div>

            </div>
        </form>

        <div class="grid-container grid-container--smaller" v-if="showForgotPasswordForm === true">
            <div style="width: 60%;" class="mx-auto mt-4">
                <forgot-password-form class="ml-0"></forgot-password-form>

                <button type="button" @click="forgotPassword(false)" class="cancelButton text-17 weight-600 underline uppercase text-primary hover:secondary mt-3">Cancel</button>
            </div>

        </div>
    </div>
</section>
</template>

<script>
import api from '@/api';
import router from '@/router';

export default {
    name: 'BankruptcyConfirmLogin',
    data: function () {
        return {
            message: null,
            loaded: false,
            saving: false,
            showForgotPasswordForm: false
        };
    },
    computed: {},
    methods: {
        onSubmit($event) {
            api.users.verifyLogin({
                    email: this.user.email,
                    password: this.user.password,
                })
                .then((response) => {
                    if (response.data && response.data.verified === true) {
                        this.$store.dispatch('steps/completeStep', {
                            name: this.$route.name,
                            steps: this.steps
                        });

                        this.$store.dispatch('steps/goToNextStep', {
                            next_step: this.next_step
                        });
                    } else {
                        this.message = "Invalid login.";
                    }
                })
                .catch((error) => {
                    console.log(error);

                });

        },
        forgotPassword(state) {
            this.showForgotPasswordForm = state;

            // console.log(this.user.email);
            // window.axios.post('/api/password/forgot-password', {
            //         email: this.user.email,
            //     })
            //     .then((response) => {
            //         console.log("FORGOT PASSWORD RESPONSE IS:");
            //         console.log(response);
            //     })
        },

    },
    mounted() {},

}
</script>
