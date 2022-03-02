<template>
<section>
    <div class="grid-container grid-container--large">
        <div class="grid-x grid-margin-x">
            <div class="cell small-12 medium-6">
                <img svg-inline src="@img/svg/iris-desk.svg" class="w-100">
            </div>

            <div class="cell small-12 medium-5 medium-offset-1">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</section>
</template>

<script>
export default {
    name: 'CompletedSubmission',
    mounted() {
        document.documentElement.classList.add('completed');
    }
}
</script>
