<script setup>
import SelectInput from "@/shared/ui/inputs/SelectInput.vue";
import {computed} from 'vue'

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean, Array, Object],
        required: true
    },
})

const sortOptions = [
    {value: 'username', text: 'By username'},
    {value: 'username,desc', text: 'By username desc'},
    {value: 'email', text: 'By email'},
    {value: 'email,desc', text: 'By email desc'},
    {value: 'created_at', text: 'By date'},
    {value: 'created_at,desc', text: 'By date desc'},
]

const emit = defineEmits(["update:modelValue"]);

const computedValue = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});

</script>

<template>
    <SelectInput v-model="computedValue" :options="sortOptions" disabled-option-text="Sort comments"></SelectInput>
</template>

<style scoped>

</style>
