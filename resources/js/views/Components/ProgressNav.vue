<template>
<div id="off-canvas" class="off-canvas position-left data-off-canvas bg-primary" data-transition="overlap" data-off-canvas data-content-scroll="false">
    <div class="off-canvas__inner h-100 display-flex flex-column">
        <div class="off-canvas__top">
            <button data-toggle="off-canvas" class="button--offCanvasToggle"><img svg-inline src="@img/svg/close.svg"></button>
        </div>

        <div class="off-canvas__middle relative flex-1">
            <div class="nav h-100 noscrollbar-scroll-y">
                <div class="nav__inner h-100">
                    <div class="grid-x h-100 overflow-">
                        <div class="milestone milestone--intro cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/iris-small.svg" class="svg--irisNavMilestone">
                                </div>

                                <div class="cell auto milestone__right">
                                    <p class="text-27 weight-300 font-heading text-white pl-4">Hi, I’m <strong>IRIS!</strong> I’m here to track your
                                        progress and answer any questions you have. Click my icon below if you want to chat! </p>
                                </div>
                            </div>
                        </div>

                        <router-link :to="{ name: 'SubmissionReason' }" id="milestone-getting-started" class="milestone cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/check-circle.svg">
                                    <img svg-inline src="@img/svg/hollow-circle.svg">
                                </div>

                                <div class="cell auto milestone__right">
                                    <h2 class="text-25 font-book text-white weight-500 mb-1 lh-1">Getting started</h2>
                                    <p class="text-20 weight-300 text-white">Tell us which financial topic you would like to focus on.</p>
                                </div>
                            </div>
                        </router-link>

                        <router-link :to="{ name: 'SubmissionCustomActionPlan' }" id="milestone-getting-acquainted" class="milestone cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/check-circle.svg">
                                    <img svg-inline src="@img/svg/hollow-circle.svg">
                                </div>

                                <div class="cell auto milestone__right">
                                    <h2 class="text-25 font-book text-white weight-500 mb-1 lh-1">Getting acquainted</h2>
                                    <p class="text-20 weight-300 text-white">Provide your name and e-mail so we can be in touch.</p>
                                </div>
                            </div>
                        </router-link>

                        <router-link :to="{ name: 'SubmissionIncomeDependents' }" id="milestone-income-dependents" class="milestone cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/check-circle.svg">
                                    <img svg-inline src="@img/svg/hollow-circle.svg">
                                </div>

                                <div class="cell auto milestone__right">
                                    <h2 class="text-25 font-book text-white weight-500 mb-1 lh-1">Income</h2>
                                    <p class="text-20 weight-300 text-white">Tell us how many people your income supports.</p>
                                </div>
                            </div>
                        </router-link>

                        <router-link :to="{ name: 'SubmissionIncomes' }" id="milestone-income-types" class="milestone cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/check-circle.svg">
                                    <img svg-inline src="@img/svg/hollow-circle.svg">
                                </div>

                                <div class="cell auto milestone__right">
                                    <h2 class="text-25 font-book text-white weight-500 mb-1 lh-1">Income Types</h2>
                                    <p class="text-20 weight-300 text-white">Select which types of income you receive.</p>
                                </div>
                            </div>
                        </router-link>

                        <router-link :to="{ name: 'SubmissionAutomaticDebts' }" id="milestone-debts" class="milestone cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/check-circle.svg">
                                    <img svg-inline src="@img/svg/hollow-circle.svg">
                                </div>

                                <div class="cell auto milestone__right">
                                    <h2 class="text-25 font-book text-white weight-500 mb-1 lh-1">Debts</h2>
                                    <p class="text-20 weight-300 text-white">Provide your information so we can automatically pull your debts.</p>
                                </div>
                            </div>
                        </router-link>

                        <router-link :to="{ name: 'Expenses' }" id="milestone-expenses" class="milestone cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/check-circle.svg">
                                    <img svg-inline src="@img/svg/hollow-circle.svg">
                                </div>

                                <div class="cell auto milestone__right">
                                    <h2 class="text-25 font-book text-white weight-500 mb-1 lh-1">Expenses</h2>
                                    <p class="text-20 weight-300 text-white">Tell us about the expenses you incur each month.</p>
                                </div>
                            </div>
                        </router-link>

                        <router-link :to="{ name: 'Summary' }" id="milestone-additional-information" class="milestone cell small-12">
                            <div class="grid-x grid-margin-x">
                                <div class="cell shrink milestone__left">
                                    <img svg-inline src="@img/svg/check-circle.svg">
                                    <img svg-inline src="@img/svg/hollow-circle.svg">
                                </div>

                                <div class="cell auto milestone__right">
                                    <h2 class="text-25 font-book text-white weight-500 mb-1 lh-1">Additional Information</h2>
                                    <p class="text-20 weight-300 text-white">Tell us anything else we should know about your finances.</p>
                                </div>
                            </div>
                        </router-link>

                    </div>

                </div>
            </div>
        </div>

        <div class="off-canvas__bottom display-flex align-middle">
            <questions-iris></questions-iris>
        </div>

    </div>
</div>
</template>

<script>
export default {
    name: 'ProgressNav'
}
</script>
