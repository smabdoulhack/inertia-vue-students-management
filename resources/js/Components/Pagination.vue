<script setup>
defineProps({
    data: {
        type: Object,
        required: true,
    },
})

import { usePage, router } from '@inertiajs/vue3';

const updatePageNumber = (link) => {
    let pageNumber = link.url.split("=")[1];

    router.visit('/students?page=' + pageNumber, {
        preserveScroll: true, // preserve scroll position
    });

}
</script>

<template>
    <div class="flex justify-between items-center">

        <small>
            Showing from {{ data.meta.from }} to {{ data.meta.to }} of {{ data.meta.total }}
        </small>

        <nav aria-label="Page navigation example">
            <ul class="inline-flex -space-x-px text-base h-10">
                <li v-for="(link, index) in data.meta.links" :key="index">

                    <button @click.prevent="updatePageNumber(link)" aria-current="page"
                        :disabled="!link.url || link.active"
                        class="flex items-center justify-center px-4 h-10  border-gray-300 hover:bg-blue-100  dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                        :class="{
                            'text-blue-600 border hover:text-blue-700 bg-blue-50': link.active,
                            'text-gray-500': !link.active
                        }">
                        <span v-html="link.label"></span>
                    </button>

                </li>
            </ul>
        </nav>

    </div>
</template>