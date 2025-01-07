<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';



const props = defineProps({
    classes: {
        type: Object,
        required: true,
    },
    student: {
        type: Object,
        required: true,
    }
});

console.log("classes :", props.classes.data);

let sections = ref({})
let student = usePage().props.student.data;

const form = useForm({
    name: student.name,
    email: student.email,
    class_id: student.class.class_id,
    section_id: student.section.section_id,
})

watch(() => form.class_id, (newValue) => {
    getSections(newValue)
})

const getSections = (classId) => {
    console.log("class ", classId);
    axios.get("/api/sections?class_id=" + classId).then((response) => {
        console.log("sections : ", response.data);
        sections.value = response.data;
    })
}

onMounted(() => {
    getSections(form.class_id)
})



const updateStudent = async () => {
    form.put(route('students.update', student.id))
}
</script>

<template>

    <Head title="Update Student" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Student</h2>
        </template>

        <pre>
    Form object : {{ student }}
</pre>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div class="p-6 bg-white">

                        <form class="max-w-sm mx-auto" @submit.prevent="updateStudent">
                            <div class="mb-5">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    name</label>
                                <input type="text" id="name" v-model="form.name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    :class="{ 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500': form.errors.name }" />
                                <InputError :message="form.errors.name" class="mt-2" />

                            </div>

                            <div class="mb-5">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    email</label>
                                <input id="email" v-model="form.email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    :class="{ 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500': form.errors.email }"
                                    placeholder="name@flowbite.com" />
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <div class="mb-5">
                                <label for="countries"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select your
                                    Class</label>
                                <select id="countries" v-model="form.class_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    :class="{ 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500': form.errors.class_id }">
                                    <option value="">Select a class</option>
                                    <option v-for="item in classes.data" :key="item.id" :value="item.id">{{ item.name}}</option>
                                </select>
                                <InputError :message="form.errors.class_id" class="mt-2" />
                            </div>

                            <div class="mb-5">
                                <label for="countries"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select your
                                    Section</label>
                                <select id="countries" v-model="form.section_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    :class="{ 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500': form.errors.section_id }">
                                    <option>Select a section</option>

                                    <option v-for="section in sections.data" :value="section.id" :key="section.id"
                                        :selected=" section.id == student.section.id">{{
                                        section.name }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.section_id" class="mt-2" />
                            </div>

                            <!-- <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">Erreur !</span> Message d'erreur
                                </div>
                            </div> -->
                            <div class="flex justify-between">

                                <Link :href="route('students.index')"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                Cancel</Link>
                                <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
