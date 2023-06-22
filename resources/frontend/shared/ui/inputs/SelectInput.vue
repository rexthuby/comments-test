<script setup>
import {computed} from "vue";
import InputIcon from "@/shared/ui/inputs/InputIcon.vue";

const props = defineProps({
  iconSvgPath: {
    type: String,
    required: false,
  },
  selectName: {
    type: String,
    required: false
  },
  disabledOptionText: {
    type: String,
    required: false,
    default: 'Select one'
  },
  options: {
    type: Array,//<{ value: string|number, text: string }[]>
    required: true,
  },
  modelValue: {
    type: [String, Number, Boolean, Array, Object],
    required: true
  },
});

const emit = defineEmits(["update:modelValue"]);

const computedValue = computed({
  get: () => props.modelValue,
  set: (value) => {
    emit("update:modelValue", value);
  },
});
</script>

<template>
  <div class="relative">
    <select
        :name="selectName ?? ''"
        v-model="computedValue"
        :class="[
    'px-3 py-2 max-w-full focus:ring focus:outline-none border-gray-700 rounded w-full border bg-white',
    iconSvgPath ? 'pl-10' : '',]">
      <option disabled value="">
        {{ disabledOptionText }}
      </option>
      <option
          v-for="(option,idx) in options"
          :key="idx"
          :value="option.value"
      >
        {{ option.text}}
      </option>
    </select>
    <InputIcon v-if="iconSvgPath" box-height-class="h-full" :svg-path="iconSvgPath"/>
  </div>
</template>
