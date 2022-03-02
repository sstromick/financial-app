<template>
<button type="button" class="weight-600 underline uppercase text-17 text-primary hover:secondary font-body" @click="$store.dispatch('steps/goToPreviousStep', { previous_step: previous_step })">Back</button>
</template>

<script>
export default {
    name: 'BackButton',
}
</script>
