<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
    videogame: {
        type: Object,
    },
    platforms:{ 
        type: Object,
    },
});


</script>


<template>
    <Head title="Videogame" />

    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ videogame.name }} 
                <NavLink :href="route('videogames.index')" >
                    <DarkButton class="ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
        </template>
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs ">
                <p  > Description: <span class="text-gray-900 font-semibold" >{{ videogame.description }}</span> </p>
                <p  > Type: <span class="text-gray-900 font-semibold" >{{ videogame.type }}</span> </p>
                <p  > Platforms: 
                    <span v-for="p,i in platforms"  class="text-gray-900 font-semibold" >
                        <a v-if="i==(platforms.length-1)">{{ p.name}}</a>
                        <a v-else>{{ p.name + ',' }}</a>
                    </span> 
                </p>
                <p  > Genre: <span class="text-gray-900 font-semibold" >{{ videogame.genre }}</span> </p>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs ">
                <img :src="'../storage'+videogame.image" :alt="videogame.name" class="w-full h-64 object-cover rounded-lg" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
