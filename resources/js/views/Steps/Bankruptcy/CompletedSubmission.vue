<template>
    <completed-submission>
        <template v-slot:content>
            <div class="display-flex align-center flex-column h-100">
                <div class="text-110 font-heading text-white weight-500 lh-1">
                    100%
                </div>
                <h1 class="text-white">
                    A financial counselor will connect with you soon!
                </h1>
                <p class="text-offwhite text-25 font-book">
                    A financial counselor will reach out soon to complete the
                    process & provide your certificate. If you have time to chat
                    with a financial counselor now, we can finalize your
                    counseling session today! Click on the IRIS icon below.
                </p>

                <div
                    class="mt-7 display-flex align-middle text-offwhite text-20 font-book"
                >
                    <img svg-inline src="@img/svg/info.svg" class="mr-1" /> Chat
                    available during Apprisen business hours.
                </div>
            </div>
        </template>
    </completed-submission>
</template>

<script>
export default {
    name: "BankruptcyCompletedSubmission"
};

//facebook tracking
fbq("track", "CompleteRegistration");
</script>
