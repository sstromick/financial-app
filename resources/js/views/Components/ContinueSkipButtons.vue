<template>
<div class="grid-x grid-margin-x mt-7 mb-4">
    <div class="cell shrink">
        <button type="button" class="button button--hollow button--stepNav" @click="$store.dispatch('steps/goToNextStep', { next_step: next_step })">Skip This Step</button>
    </div>

    <div class="cell shrink">
        <button value="submit" name="submit" type="submit" class="button button--stepNav">Continue</button>
    </div>
</div>
</template>

<script>
export default {
    name: 'ContinueSkipButtons',
}
</script>
