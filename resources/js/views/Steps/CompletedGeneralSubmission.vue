<template>
    <completed-submission>
        <template v-slot:content>
            <div class="display-flex align-center flex-column h-100">
                <div class="text-110 font-heading text-white weight-500 lh-1">
                    100%
                </div>
                <h1 class="text-white">You're done! Now stay tuned...</h1>
                <p class="text-offwhite text-25 font-book">
                    Congratulations! You just took your first step toward a
                    healthy financial future. One of our Financial Specialists
                    will review your information to create a custom financial
                    action plan and connect with you to discuss next steps.
                </p>
            </div>
        </template>
    </completed-submission>
</template>

<script>
export default {
    name: "CompletedGeneralSubmission"
};

//facebook tracking
fbq("track", "CompleteRegistration");
</script>
