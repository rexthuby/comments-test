<script setup>
import {VueAwesomePaginate} from "vue-awesome-paginate";
import {computed} from "vue";

const props = defineProps({
    modelValue: {
        type: Number,
        required: true
    },
    totalItems: {
        type: Number,
        required: true
    },
    itemsPerPage: {
        type: Number,
        default: 10,
        validator: (value) => {
            if (value <= 0) {
                const message = "itemsPerPage attribute must be greater than 0.";
                console.error(message);
                throw new TypeError(message);
            }
            return true;
        }
    },
    maxPagesShown: {
        type: Number,
        default: 3
    },
    onClick: {
        type: Function,
        default: () => {
        }
    }
})

const emit = defineEmits(['update:modelValue'])

const computedValue = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});
</script>

<template>
    <div class="standard-pagination flex justify-center">
        <vue-awesome-paginate :total-items="totalItems"
                              :items-per-page="itemsPerPage"
                              :max-pages-shown="maxPagesShown"
                              v-model="computedValue"
                              :on-click="onClick">
            <template #prev-button>
        <span class="flex justify-center items-center">
          <svg xmlns="http://www.w3.org/2000/svg"
               fill="white"
               width="12"
               height="12"
               viewBox="0 0 24 24">
            <path d="M8.122 24l-4.122-4 8-8-8-8 4.122-4 11.878 12z"/>
          </svg>
        </span>
            </template>
            <template #next-button>
        <span class="flex justify-center items-center">
          <svg xmlns="http://www.w3.org/2000/svg"
               fill="white"
               width="12"
               height="12"
               viewBox="0 0 24 24">
            <path d="M8.122 24l-4.122-4 8-8-8-8 4.122-4 11.878 12z"/>
          </svg>
        </span>
            </template>
        </vue-awesome-paginate>
    </div>
</template>

<style>
.standard-pagination .pagination-container {
    column-gap: 10px;
    align-items: center;
    display: flex;
}

.standard-pagination .paginate-buttons {
    height: 30px;
    width: 30px;
    cursor: pointer;
    border-radius: 4px;
    background-color: transparent;
    border: none;
    color: black;
}

.standard-pagination .back-button,
.standard-pagination .next-button {
    background-color: black;
    color: white;
    border-radius: 8px;
    height: 30px;
    width: 30px;
}

.standard-pagination .active-page {
    background-color: #e5e5e5;
}

.standard-pagination .paginate-buttons:hover {
    background-color: #f5f5f5;
}

.standard-pagination .active-page:hover {
    background-color: #e5e5e5;
}

.standard-pagination .back-button svg {
    transform: rotate(180deg) translateY(-2px);
}

.standard-pagination .next-button svg {
    transform: translateY(2px);
}

.standard-pagination .back-button:hover,
.standard-pagination .next-button:hover {
    background-color: rgb(45, 45, 45);
}

.standard-pagination .back-button:active,
.standard-pagination .next-button:active {
    background-color: rgb(85, 85, 85);
}
</style>
