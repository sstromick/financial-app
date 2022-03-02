<template>
<div class="grid-container grid-container--large">
    <div class="grid-x grid-margin-x grid-margin-y">
        <div class="cell small-12 large-5">
            <div class="">
                <h1 class="">{{ heading }}</h1>
                <div class="text-25 text-gray font-book">
                    <slot name="text">{{ text }}</slot>

                </div>
            </div>
        </div>

        <div class="cell small-12 large-6 large-offset-1">
            <div class="video relative hover:fill-secondary pointer-events-all cursor-pointer">
                <div class="video__inner">

                    <div class="video__elementWrapper">
                        <video controls @playing="onPlaying($event)" @pause="onPause($event)">
                            <source :src="video" v-if="video" type="video/mp4">
                            <source :src-webm="video.mp4" v-if="video.webm" type="video/webm">
                        </video>
                    </div>

                    <div class="video__overlay abs-fill pointer-events-none flex-center">
                        <img svg-inline class="cursor-pointer" src="@img/svg/play-button.svg">
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
</template>

<script>
export default {
    name: 'BankruptcyVideoSection',
    props: {
        heading: String,
        text: String,
        video: String,
    },
    methods: {
        onPlaying($event) {
            $event.target.closest('.video').classList.add('video--playing');
        },
        onPause($event) {
            $event.target.closest('.video').classList.remove('video--playing');
        },
    }
}
</script>
