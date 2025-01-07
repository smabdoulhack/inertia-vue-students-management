<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router, Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { computed, ref, watch } from 'vue';

defineProps({
    students: {
        type: Object,
        required: true,
    },
    classes: {
        type: Object,
        required: true,
    }
});

const deleteForm = useForm({});

const deleteStudent = (studentId: string | number) => {
    if (confirm("Are you sure you want to delete this student?")) deleteForm.delete(route('students.destroy', studentId));
}

let search = ref(usePage().props.search),
    class_id = ref(usePage().props.class_id ?? ''),
    pageNumber = ref(1)

//avec computed, lorsqu'une des composantes de l'url change, on la variable est mise à jour
const studentUrl = computed(() => {
    const url = new URL(route("students.index"))

    url.searchParams.append("page", pageNumber.value.toString())

    // le changement de mot clé de la recherche met à jour l'url
    if (search.value) {
        url.searchParams.append("search", search.value)
    }

    // le changement du filtre de classe met à jour l'url
    if (class_id.value) {
        url.searchParams.append("class_id", class_id.value)
    }

    console.log("the url has changed");

    return url
})

const updatedPageNumber = (link: string) => {
    pageNumber.value = link.url.split("=")[1]
}

// Dès que l'url change, la page est mise à jour systématiquement
watch(() => studentUrl.value, (updatedStudentUrl) => {
    router.visit(updatedStudentUrl, {
        preserveScroll: true,
        preserveState: true,
        replace: true
    })
})

// Commencer l'affichage des résultats de recherches par la première page peu importe la page sur laquelle la recherche est faite
watch(() => search.value, (value) => {
    if (value) {
        pageNumber.value = 1
    }
})

watch(() => class_id.value, (value) => {
    if (value) {
        pageNumber.value = 1
    }
})

</script>

<template>

    <Head title="Students List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students List</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <!-- <pre> {{ students }} </pre> -->

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <div class="flex justify-between pb-4 bg-white dark:bg-gray-900">
                                <div class="flex justify-start align-middle gap-4 bg-white dark:bg-gray-900">
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute top-3 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="search" id="table-search" v-model="search"
                                            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Search a student">
                                    </div>
                                    <div>
                                        <select id="small" v-model="class_id"
                                            class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option selected>Filter by class</option>
                                            <option v-for="item in classes.data" :key="item.id" :value="item.id">{{
                                                item.name
                                            }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <Link
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        :href="route('students.create')">
                                    Add student
                                    </Link>
                                </div>
                            </div>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <!-- <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-search" type="checkbox"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                            </div>
                                        </th> -->
                                        <th scope="col" class="px-6 py-3">
                                            Student Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Class
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Section
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="students.data.length" v-for="student in students.data"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ student.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ student.email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ student.class.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ student.section.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ student.created_at }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <Link :href="route('students.edit', student.id)"
                                                class="mx-2 font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Edit
                                            </Link>
                                            <button @click="deleteStudent(student.id)"
                                                class="mx-2 font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3">
                                <Pagination :data="students" :updatedPageNumber="updatedPageNumber" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
