<script setup>
import SimpleForm from "@/shared/ui/forms/SimpleForm.vue";
import FormField from "@/shared/ui/forms/FormField.vue";
import TextInput from "@/shared/ui/inputs/TextInput.vue";
import {computed, onBeforeMount, reactive, ref} from "vue";
import {ArrowPathIcon} from '@heroicons/vue/24/outline'
import WhiteButton from "@/shared/ui/buttons/WhiteButton.vue";
import FilePicker from "@/features/FilePicker/ui/FilePicker.vue";
import {supportedFileExtension} from "@/entities/Comment/consts/supportedFileExtension.js";
import useVuelidate from "@vuelidate/core";
import * as validationRules from '@/entities/Comment/lib/validationRules.js'
import {storeComment} from "@/features/CommentForm/api/storeComment.js";
import {getCaptchaImage} from "../api/getCaptchaImage.js";
import BasicSpinner from "../../../shared/ui/spinners/BasicSpinner.vue";

const props = defineProps({
    replyTo: {
        type: Number,
        default: null,
    }
})

const formData = reactive({
    username: '',
    email: '',
    url: '',
    body: '',
    captcha: '',
    file: null,
})

const isSendAvailable = ref(true)
const textInputBox = ref(null)
const captchaImageBox = ref(null)

onBeforeMount(() => {
    setCaptcha()
})

const setCaptcha = async () => {
    const response = await getCaptchaImage()
    captchaImageBox.value.innerHTML = response.data
}

const validatedRules = computed(() => ({
    username: validationRules.usernameRule,
    email: validationRules.emailRule,
    url: validationRules.urlRule,
    captcha: validationRules.captchaRule,
    body: validationRules.textRule,
    file: validationRules.fileRule,
}))

const validated = useVuelidate(validatedRules, formData, {$lazy: true})

const sendComment = async () => {
    isSendAvailable.value = false

    const isValid = await validated.value.$validate()
    if (!isValid) {
        isSendAvailable.value = true
        return
    }

    storeComment(prepareStoreData())
    makeDataEmpty()
    isSendAvailable.value = true
}

const makeDataEmpty = () => {
    formData.file = null
    formData.url = ''
    formData.body = ''
    formData.email = ''
    formData.username = ''
    formData.captcha = ''
}

const prepareStoreData = () => {
    return {
        parent_id: props.replyTo,
        username: formData.username,
        email: formData.email,
        url: formData.url,
        captcha: formData.captcha,
        body: formData.body,
        file: formData.file,
    }
}

const addTag = (open, close) => {
    /**
     * @var HTMLDivElement inputBox
     */
    const inputBox = textInputBox.value;
    const input = inputBox.firstChild.firstChild
    const start = input.selectionStart;
    const end = input.selectionEnd;
    if (start !== end) {
        const body = input.value;
        input.value = body.substring(0, start) + open + body.substring(start, end) + close + body.substring(end);
        input.focus();
        const sel = end + (open + close).length;
        input.setSelectionRange(sel, sel);
    }
    return false;
}

const addSelectedTag = (tag) => {
    if (tag === 'a') {
        addTag('<a href="" title="">', '</a>')
    }
    if (tag === 's') {
        addTag('<strong>', '</strong>')
    }
    if (tag === 'c') {
        addTag('<code>', '</code>')
    }
    if (tag === 'i') {
        addTag('<i>', '</i>')
    }
}
const getFirstErrorMessage = (valid) => valid.$errors.map(err => err.$message.toString())[0]
</script>

<template>
    <SimpleForm class="flex flex-col gap-2">
        <div class="grid grid-cols-2 gap-2">
            <FormField label="Username" :warnings="[getFirstErrorMessage(validated.username)]">
                <TextInput v-model="formData.username" placeholder="Username" :required="true"
                           @input="validated.username.$reset()"></TextInput>
            </FormField>
            <FormField label="E-mail" :warnings="[getFirstErrorMessage(validated.email)]">
                <TextInput v-model="formData.email" placeholder="Email" :required="true"
                           @input="validated.email.$reset()"></TextInput>
            </FormField>
        </div>
        <FormField label="Url" :warnings="[getFirstErrorMessage(validated.url)]">
            <TextInput v-model="formData.url" placeholder="Url"
                       @input="validated.url.$reset()"></TextInput>
        </FormField>


        <FormField label="Captcha" :warnings="[getFirstErrorMessage(validated.captcha)]">
            <div>
                <div class="flex items-center gap-1 mb-2">
                    <div ref="captchaImageBox" class="h-12 w-40 bg-gray-100 flex justify-center">
                        <BasicSpinner height-class="h-10" width-class="w-10"></BasicSpinner>
                    </div>
                    <WhiteButton paddingClass="p-1" @click.prevent="setCaptcha" class="rounded-full p-1">
                        <ArrowPathIcon class="h-5 w-5"></ArrowPathIcon>
                    </WhiteButton>
                </div>
                <TextInput v-model="formData.captcha" :required="true"
                           @input="validated.captcha.$reset()"></TextInput>
            </div>
        </FormField>


        <FormField label="Comment text" :warnings="[getFirstErrorMessage(validated.body)]">
            <div>
                <div class="flex items-center gap-1 pb-1">
                    <WhiteButton @click.prevent="addSelectedTag('c')" padding-class="px-1 pb-1">
                        <span class="text-sm">[c]</span>
                    </WhiteButton>
                    <WhiteButton @click.prevent="addSelectedTag('i')" padding-class="px-1 pb-1">
                        <span class="text-sm">[i]</span>
                    </WhiteButton>
                    <WhiteButton @click.prevent="addSelectedTag('s')" padding-class="px-1 pb-1">
                        <span class="text-sm">[s]</span>
                    </WhiteButton>
                    <WhiteButton @click.prevent="addSelectedTag('a')" padding-class="px-1 pb-1">
                        <span class="text-sm">[a]</span>
                    </WhiteButton>
                </div>
                <div ref="textInputBox">
                    <TextInput v-model="formData.body" ref="textInputBox" :required="true" inputType="textarea"
                               @input="validated.body.$reset()"></TextInput>
                </div>
            </div>
        </FormField>
        <FormField label="File" :warnings="[getFirstErrorMessage(validated.file)]">
            <FilePicker v-model="formData.file" @change="validated.file.$reset()"
                        :accept="supportedFileExtension"></FilePicker>
        </FormField>
        <div class="flex justify-end">
            <WhiteButton class="mt-2" @click.prevent="sendComment" :is-disable="!isSendAvailable"
                         padding-class="px-2 py-1"><span
                class="text-sm">Send comment</span>
            </WhiteButton>
        </div>
    </SimpleForm>
</template>

<style scoped>

</style>
