<template>
    <section class="section py-4">
        <div class="grid-container mt-6">
            <div
                class="grid-container grid-container--smaller text-center mb-8"
            >
                <h1 class="text-54 weight-100 text-darkGreen">
                    Great! One more step before we get started.
                </h1>

                <p class="font-book text-25">
                    There's a $25.00 fee associated with our Pre-Bankruptcy
                    Counseling. Enter your payment information below to get
                    started! We recommend the use of a debit card to pay the
                    session fee.
                </p>
            </div>

            <!-- @TODO: Add Process Payment Form -->
            <form
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form mt-4 grid-x grid-margin-x align-center"
                enctype="multipart/form-data"
            >
                <div
                    class="form__fieldWrapper display-flex flex-wrap cell small-12"
                ></div>

                <div class="form__fieldWrapper cell shrink">
                    <div class="grid-x grid-margin-x flex-center">
                        <div class="cell shrink">
                            <button
                                value="submit"
                                name="submit"
                                type="submit"
                                class="button button--stepNav"
                            >
                                Process Payment
                            </button>
                        </div>

                        <div class="cell small-12 flex-center mt-5">
                            <back-button></back-button>
                        </div>
                    </div>
                </div>
            </form>

            <div
                v-if="message"
                class="alert text-error text-center my-3 weight-500 text-20"
            >
                {{ message }}
            </div>

            <div
                class="grid-container grid-container--smaller text-center mt-6"
            >
                <p class="font-book text-20 font-book">
                    Your security is of utmost important to us. That’s why we
                    use
                    <a
                        href="https://go.wepay.com/"
                        target="_blank"
                        class="weight-500 font-body text-gray"
                        >WePay</a
                    >, a trusted payment processing tool that uses advanced
                    security technology to ensure your payment information is
                    always safe and secure.
                </p>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "BankruptcyOverThreshold",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false
        };
    },
    methods: {
        onSubmit($event) {
            this.saving = true;
            this.message = false;
        }
    },
    mounted() {}
};
</script>
