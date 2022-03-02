import $ from "jquery";
window.$ = window.jQuery = $;
import foundation from "foundation-sites";
import tippy from "tippy.js";

import {
    getViewport,
    throttle,
    debounce,
    watchAwaitSelector,
    convertPixelsToRem
} from "./functions";

window.addEventListener("load", event => {
    start(event);
});

function start(event) {
    "use strict";

    const bottomBar = document.getElementById("bottom-bar");
    const recaptchaBadge = document.querySelector(".grecaptcha-badge");

    $("#login-modal").on("closed.zf.reveal", function() {
        location.reload();
    });

    $(document).foundation();

    window.viewport = getViewport();
    window.viewportWidth = window.viewport.width;
    window.viewportHeight = window.viewport.height;
    const bodyExtraPadding = 160;

    let bottomBarHeight = bottomBar.getBoundingClientRect().height;
    document.body.style.paddingBottom =
        convertPixelsToRem(bottomBarHeight + bodyExtraPadding) + "rem";

    recaptchaBadge.style.bottom = convertPixelsToRem(bottomBarHeight) + "rem";

    throttle("resize", "resize.optimized");
    window.addEventListener(
        "resize.optimized",
        debounce(function() {
            window.viewport = getViewport();

            bottomBarHeight = bottomBar.getBoundingClientRect().height;
            document.body.style.paddingBottom =
                convertPixelsToRem(bottomBarHeight + bodyExtraPadding) + "rem";

            recaptchaBadge.style.bottom =
                convertPixelsToRem(bottomBarHeight) + "rem";
        }, 250)
    );

    watchAwaitSelector(function(elements) {
        for (let element of elements) {
            // Remove the inline style used to prevent display on initial page load
            element.style.display = "";
        }
    }, "#login-modal, #create-account-modal");
}
