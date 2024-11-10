<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import { ref } from 'vue';

const props = defineProps({
    videogames: {
        type: Object,
    },
    flash: {
        type: Object,
    }
});

const form = useForm({
    id: '', 
    name: '',
});

const showModalDelete = ref(false);
const msj = ref((props.flash.success != null) ? props.flash.success : '');
const classMsj = ref((props.flash.success != null) ? '' : 'hidden');

const openModalDelete = (v) => {
    form.id = v.id;
    form.name = v.name;
    showModalDelete.value = true;
}

const closeModalDelete = () => {
    showModalDelete.value = false;
}

const deleteVideogame = () => {
    form.delete(route('videogames.destroy', form.id), {
        onSuccess: () => ok('Videogame deleted successfully')
        });
}


const ok = (m) => {
    closeModalDelete();
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000);
};

</script>
<template>
    <Head title="Videogames" />

    <AuthenticatedLayout>
        <template #header>
            Videogames
        </template>

        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
            <div class="flex justify-center items-center w-12 bg-green-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-400">Success</span>
                    <p class="text-sm text-gray-600">{{ msj }}</p>
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-purple-50">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-purple-100">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Videogames</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Genre</th>
                            <th class="px-4 py-3">Image</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-purple-50 divide-y">
                        <tr v-for="(vg, i) in videogames.data" :key="vg.id" class="text-gray-700">
                            <td class="px-4 py-3">{{ i + 1 }}</td>
                            <td class="px-4 py-3">{{ vg.name }}</td>
                            <td class="px-4 py-3">{{ vg.description }}  </td>
                            <td class="px-4 py-3">{{ vg.type }}</td>
                            <td class="px-4 py-3">{{ vg.genre}}</td>
                            <td class="px-4 py-3">
                                <img :src="'storage'+vg.image" width="50">
                            </td>
                            <td class="px-4 py-3 flex space-x-2">
                                <NavLink :href="route('videogames.show', vg.id)">
                                    <SecondaryButton>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </SecondaryButton>
                                </NavLink>
                                <NavLink :href="route('videogames.edit',vg.id)">
                                    <WarningButton>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </WarningButton>
                                </NavLink>
                                <a href="#" class="text-red-600 hover:text-red-900" @click.prevent="openModalDelete(p)">
                                    <DangerButton @click="openModalDelete(vg)" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </DangerButton>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
					class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<pagination :links="videogames.links" />
			</div>
        </div>
        <Modal :show="showModalDelete" @close="closeModalDelete">
            <div class="p-6">
                <p class="text-2xl text-gray-500">
                    Are you sure you want to delete the videogame:
                    <span class="text-2xl font-medium text-gray-900">{{ form.name }}</span>?
                </p>
                <PrimaryButton @click="deleteVideogame">Yes Sir, Delete</PrimaryButton>
            </div>
            <div class="m-6 flex justify-end">
                <SecondaryButton @click="closeModalDelete">Cancelar</SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>