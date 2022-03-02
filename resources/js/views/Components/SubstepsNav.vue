<template>
<div class="form__fieldWrapper display-flex flex-wrap cell small-12">
    <div class="grid-x grid-margin-x mt-7 mb-4 align-center w-100">
        <div class="cell shrink">
            <button type="button" class="button button--hollow button--stepNav" @click="$store.dispatch('steps/goToNextStep', { next_step: next_step })">Skip This Step</button>
        </div>

        <div class="cell shrink">
            <button value="submit" name="submit" type="submit" class="button button--stepNav" @submit.prevent="onSubmit($event)">Continue</button>
        </div>

    </div>
    <div class="flex-center w-100">
        <button type="button" class="weight-600 underline uppercase text-primary" @click="$store.dispatch('steps/goToPreviousStep', { previous_step: previous_step })">Back</button>
    </div>
</div>
</template>

<script>
export default {
    name: 'SubstepsNav',
}
</script>
