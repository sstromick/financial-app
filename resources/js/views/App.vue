<template>
    <div class="off-canvas-wrapper">
        <progress-nav></progress-nav>

        <div
            class="off-canvas-content data-off-canvas-content"
            data-off-canvas-content
        >
            <div id="progress-bar-wrapper" class="progressBarWrapper">
                <div id="progress-bar" class="progressBar"></div>
            </div>

            <div
                class="grid-container grid-container--large py-4 py-6--xxlarge"
            >
                <div class="display-flex align-middle">
                    <button
                        data-toggle="off-canvas"
                        class="button--offCanvasToggle mr-3"
                    >
                        <img svg-inline src="@img/svg/open.svg" />
                        <!--<img svg-inline src="@img/svg/close.svg">-->
                    </button>

                    <div id="progress-wrapper">
                        <div
                            id="progress-percentage-wrapper"
                            class="font-heading weight-bold text-35 text-secondary display-flex align-middle"
                        >
                            <div id="progress-percentage" class="">
                                {{ progress | placeholder("0") }}
                            </div>
                            %<span
                                class="font-heading text-28 text-gray weight-400"
                                >&nbsp;Complete</span
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="isIE11" class="container mx-auto text-center my-8">
                <h2>
                    Please use a chrome, edge, safari, or firefox browser to
                    view this site.
                </h2>
            </div>

            <div v-else class="container px-4 px-8--large">
                <transition name="step">
                    <router-view></router-view>
                </transition>
            </div>
            <bottom-bar></bottom-bar>
            <create-account-modal></create-account-modal>
            <login-modal></login-modal>
            <disclosure-modal></disclosure-modal>
            <bankruptcy-timer
                v-if="
                    submission.reason === 'Bankruptcy' &&
                        (submission.accept_bankruptcy_disclosure === true ||
                            submission.accept_bankruptcy_disclosure === 1)
                "
            ></bankruptcy-timer>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import submissions from "../api/submissions";

export default {
    name: "App",
    components: {},
    data() {
        return {};
    },
    computed: {
        ...mapGetters({}),
        isIE11: function() {
            var sAgent = window.navigator.userAgent;
            var Idx = sAgent.indexOf("MSIE");

            // If IE, return version number.
            if (Idx > 0) return true;
            // If IE 11 then look for Updated user agent string.
            else if (!!navigator.userAgent.match(/Trident\/7\./)) return true;
            else return false; //It is not IE
        }
    },
    mounted() {
        Vue.prototype.$referrer = document.referrer;
        //if utm parameters, save infusionsoft tag id to be applied later
        //tag will be passed in the utm_content parameter
        let refererId = null;
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("utm_content")) {
            console.log("update refer id");
            refererId = urlParams.get("utm_content");
            Vue.prototype.$referrer_tag_id = refererId;
        }
    }
};
</script>
