<script setup>
import CommentsList from '@/widgets/CommentsList/ui/CommentsList.vue'
import MainContentWrapper from "@/entities/MainPageBlocks/ui/MainContentWrapper.vue";
import ContentTitle from "@/entities/MainPageBlocks/ui/ContentTitle.vue";
import {ChatBubbleLeftIcon} from '@heroicons/vue/24/outline'
import CommentForm from "@/features/CommentForm/ui/CommentForm.vue";
import StandardPagination from "@/entities/MainPageBlocks/ui/StandardPagination.vue";
import {onBeforeMount, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";
import {getPaginatedComments} from "../api/getPaginatedComments.js";

const props = defineProps({
    page: {
        type: String,
        required: false,
        default: null
    },
    sort: {
        type: String,
        required: false,
        default: null
    }
})

const router = useRouter()
const route = useRoute()

const currentPage = ref(props.page ?? 1)
const currentSort = ref(props.sort ?? '')

const paginatedComments = ref(null)

watch(route, (to) => {
    let page = null;
    let sort = null;

    if (to.query?.page) {
        page = to.query.page
    }
    if (to.query?.sort) {
        sort = to.query.sort
    }

    setComments(page, sort)
})

const setSort = (value) => {
    currentSort.value = value
    router.push({name: 'Home', query: getCurrentQuery()})
}

const switchPage = (page) => {
    currentPage.value = page
    router.push({name: 'Home', query: getCurrentQuery()})
};

const getCurrentQuery = () => {
    const query = {}
    if (currentPage.value) {
        query.page = currentPage.value
    }
    if (currentSort.value) {
        query.sort = currentSort.value
    }
    return query
}

onBeforeMount(() => {
    setComments(props.page, props.sort)
})

const setComments = async (page, sort) => {
    const response = await getPaginatedComments(page, sort)

    if (response.status !== 200) {
        router.push({name: 'NotFound'})
    }
    paginatedComments.value = response.data
}

const sortOptions = [
    {value: 'username', text: 'By username'},
    {value: 'username,desc', text: 'By username desc'},
    {value: 'email', text: 'By email'},
    {value: 'email,desc', text: 'By email desc'},
    {value: 'created_at', text: 'By date'},
    {value: 'created_at,desc', text: 'By date desc'},
]

</script>

<template>
    <MainContentWrapper>
        <ContentTitle title="Comments">
            <template #additional-left>
                <ChatBubbleLeftIcon class="icon"></ChatBubbleLeftIcon>
            </template>
        </ContentTitle>
        <CommentForm class="mb-2"></CommentForm>
        <div v-if="paginatedComments">
            <select :value="sort" @change="e => setSort(e.target.value)" class="sort">
                <option disabled value="">
                    Choose sort
                </option>
                <option v-for="(option,idx) in sortOptions" :key="idx" :value="option.value">
                    {{ option.text }}
                </option>
            </select>
            <CommentsList :comments="paginatedComments.data"></CommentsList>
            <StandardPagination v-if="paginatedComments.meta.last_page > 1"
                                :total-items="paginatedComments.meta.total"
                                :items-per-page="paginatedComments.meta.per_page"
                                :max-pages-shown="3"
                                v-model="paginatedComments.meta.current_page"
                                :on-click="switchPage" class="py-6"></StandardPagination>
        </div>
    </MainContentWrapper>
</template>

<style scoped>
.icon {
    transform: scale(-1, -1);
    @apply h-8 w-8
}
.sort{
    @apply mb-2 px-3 py-2 max-w-full focus:ring focus:outline-none border-gray-700 rounded w-full border bg-white
}
</style>
