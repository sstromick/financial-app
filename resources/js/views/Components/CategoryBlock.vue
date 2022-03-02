<template>
<div :class="['categoryBlock bg-white', classes]">
    <div class="categoryBlock__inner text-center h-100">
        <input :id="value | parameterize" :type="type" :name="fieldName" v-bind:value="value" class="categoryBlock__input visuallyhidden" :ref="fieldName" @change="$emit('category-clicked', value)">

        <label class="categoryBlock__label h-100 display-block pointer-events-all cursor-pointer display-flex flex-column" :for="value | parameterize">
            <div class="categoryBlock__imageWrapper relative">
                <img :src="image" class="categoryBlock__image mb-3" v-if="imageType !== 'svg'">
                <img svg-inline :src="image" v-if="imageType === 'svg'" class="mb-3">
                <img svg-inline class="categoryBlock__check" src="@img/svg/check.svg">
            </div>

            <h2 class="categoryBlock__heading text-28 weight-500 text-darkGray">{{ label }}</h2>
        </label>

    </div>
</div>
</template>

<script>
export default {
    name: 'CategoryBlock',
    data() {
        return {}
    },
    props: {
        value: {
            type: String,
            required: true,
        },
        classes: String,
        heading: String,
        fieldName: String,
        description: String,
        image: String,
        type: String,
        label: String,
        imageType: String,
    },
    methods: {}
}
</script>
