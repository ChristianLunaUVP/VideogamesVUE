<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref } from 'vue';
import select2 from 'select2';
select2();
import Select2 from 'vue3-select2-component';

const props = defineProps({
    platforms: {
        type: Array,
        default: () => [],
    },
    videogame: {
        type: Object,
        default: () => null,
    },
    platformsofvideogame: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    id: '', 
    name: '',
    description: '',
    type: '',
    genre: '',    
    image: null,
    platforms: [],
});

const title_form = ref(
    (props.videogame == null) ? 'Create Videogame' : 'Edit Videogame'
);

const req = ref('required');
const srcImg = ref('../../storage/img/example.jpg');

const msj = ref('');
const classMsj = ref('hidden');

const options = ref([]);

if (props.platforms && Array.isArray(props.platforms)) {
    props.platforms.forEach((row) => {
        options.value.push({ id: row.id, text: row.name });
    });
}

if (props.videogame != null) {
    form.id = props.videogame.id;
    form.name = props.videogame.name;
    form.description = props.videogame.description;
    form.type = props.videogame.type;
    form.genre = props.videogame.genre;
    srcImg.value = '../../storage/' + props.videogame.image;
    if (props.platformsofvideogame && Array.isArray(props.platformsofvideogame)) {
        props.platformsofvideogame.forEach((row) => {
            form.platforms.push(row.id);
        });
    }
}

const save = () => {
    if (props.videogame == null) {
        form.post(route('videogames.store'), {
            onSuccess: () => { ok('Videogame created successfully') }
        });
    } else {
        form.put(route('videogames.update', form.id), {
            onSuccess: () => { ok('Videogame updated successfully') }
        });
    }
}

const ok = (message) => {
    form.reset();
    msj.value = message;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000);
}

const showImg = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        srcImg.value = URL.createObjectURL(file);
    }
}
</script>

<template>
    <Head title="Videogame" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                {{ title_form }}
                <NavLink :href="route('videogames.index')">
                    <PrimaryButton>
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="#ffffff" d="M48.5 224L40 224c-13.3 0-24-10.7-24-24L16 72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8L48.5 224z"/>
                        </svg>
                    </PrimaryButton>
                </NavLink>
            </div>
        </template>

        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
            <div class="flex justify-center items-center w-12 bg-lightgray">
                <svg class="w-6 h-6 text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill="currentColor" d="M10 20a10 10 0 0 1 0-20a10 10 0 1 1 0 20m-2-5l9-8.5L15.5 5L8 12L4.5 8.5L3 10z"/>
                </svg>
            </div>
            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-lightgray">Success</span>
                    <p class="text-sm text-gray-600">{{ msj }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <form class="mt-6 mb-6 space-y-6 max-w-xl" @submit.prevent="save" enctype="multipart/form-data">
                    <InputGroup :text="'Name'" :required="true" v-model="form.name">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.name" />
                    <InputGroup :text="'Description'" :required="true" v-model="form.description">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.description" />
                    <InputGroup :text="'Type'" :required="true" v-model="form.type">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 9h3.75m-4.5 2.625h4.5M12 18.75 9.75 16.5h.375a2.625 2.625 0 0 0 0-5.25H9.75m.75-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.type" />
                    <InputGroup :text="'Genre'" :required="true" v-model="form.genre">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9 3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5 5.25 5.25" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.genre" />
                    <template v-if="props.videogame == null">
                        <InputGroup @change="showImg" :text="'Image'" :required="true" type="file" :accept="'image/*'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </InputGroup>
                    </template>
                    <template v-else>
                        <InputGroup @change="showImg" :text="'Image'" type="file" :accept="'image/*'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </InputGroup>
                    </template>
                    <InputError :message="form.errors.image" />
                    <span class="mt-5">Añadir Plataformas</span>
                    <Select2 v-model="form.platforms" :options="options"
                      :settings="{ multiple: true, width: '100%' }"
                      @change="form.platforms = $event.target.value" 
                    />
                    <InputError :message="form.errors.platforms" />

                    <PrimaryButton>Save</PrimaryButton>
                </form>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="srcImg" class="w-full h-64 object-cover rounded-lg" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>