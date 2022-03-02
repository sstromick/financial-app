<template>
<div class="timer text-primary bg-white text-20 weight-600 lh-1 flex-center">
    <div v-if="bankruptcyTimerCompleted === false" class="timer__inner flex-center"><img svg-inline src="@img/svg/timer.svg" class="mr-1">{{ time }} Left</div>

    <router-link :to="{ name: 'Summary' }" v-if="bankruptcyTimerCompleted === true" class="timer__inner flex-center"><img svg-inline src="@img/svg/timer.svg" class="mr-1">Completed</router-link>
</div>
</template>

<script>
import moment from 'moment';
const timerItem = 'bankruptcy-timer-ms-remaining';
const totalMS = 60 * 60 * 1000; // 60 minutes
let msRemaining = 0;
let storedTime = localStorage.getItem(timerItem);

if (storedTime && Number(storedTime) >= 0) {
    msRemaining = Number(storedTime);
} else if (storedTime < 0) {
    msRemaining = 0;
} else {
    msRemaining = totalMS;
    localStorage.setItem(timerItem, msRemaining);
}

export default {
    data: function () {
        return {
            message: null,
            loaded: false,
            saving: false,
            date: moment(msRemaining),
            countdown: null,
            bankruptcyTimerCompleted: false,
        };
    },
    computed: {
        time: function () {
            return this.date.format('mm:ss');
        }
    },
    created() {

    },
    mounted: function () {
        if (this.submission.reason === "Bankruptcy") {
            if (msRemaining === 0) {
                this.bankruptcyTimerCompleted = true;
            } else {
                this.countdown = setInterval(() => {
                    // Only count down if the bankruptcy disclosure is accepted
                    if (this.submission.accept_bankruptcy_disclosure === true || this.submission.accept_bankruptcy_disclosure === 1) {
                        if (msRemaining <= 1000) {
                            this.bankruptcyTimerCompleted = true;
                            clearInterval(this.countdown);
                            localStorage.setItem(timerItem, 0);
                        } else {
                            this.date = moment(this.date.subtract(1, 'seconds'));
                            msRemaining -= 1000;
                            localStorage.setItem(timerItem, msRemaining);
                        }
                    }

                }, 1000);
            }

        } else {

            if (storedTime) {
                localStorage.removeItem(timerItem);
            }
        }
    },
}
</script>
