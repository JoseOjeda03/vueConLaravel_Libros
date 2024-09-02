<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import NavLink from '@/Components/NavLink.vue'
import Pagination from '@/Components/Pagination.vue'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import WarninButton from '@/Components/WarninButton.vue'
import DarkButton from '@/Components/DarkButton.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputGroup from '@/Components/InputGroup.vue'

import { ref } from 'vue';

const props = defineProps({
    books: { type: Object }, flash: { type: Object }

});


const form = useForm({ id: '', title: '' })
const showModalDel = ref(false);
const msj = ref((props.flash.success != null) ? props.flash.success : '');
const classMsj = ref((props.flash.success != null) ? '' : 'hidden');

const openModalDel = (b) => {

    form.id = b.id;
    form.title = b.title;
    showModalDel.value = true;
}
const closeModalDel = () => {
    showModalDel.value = false;
}

const ok =(m) =>{


closeModalDel();
form.reset();
msj.value= m;
classMsj.value ='block'

setTimeout(()=>{
    classMsj.value= 'hidden';
},8000);
}

const deleteBook =() =>{
    form.delete(route('books.destroy',form.id),{
        onSuccess: () =>{ok('Book deleted')}
    });
}

</script>

<template>

    <Head title="Authors" />
    <AuthenticatedLayout>
        <template #header>

            Books
            <DarkButton><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </DarkButton>
        </template>
        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
            <div class="flex justify-center items-center w-12 bg-green-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z">
                    </path>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Success</span>
                    <p class="text-sm text-gray-600">{{ msj }}</p>
                </div>
            </div>
        </div>


        <div class="w-full overflow-hidden rounded-lg border shadow-md">
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Isbn</th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">page</th>
                            <th class="px-4 py-3">Detail</th>
                            <th class="px-4 py-3">Edit</th>
                            <th class="px-4 py-3">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-700 bg-gray-800">
                        <tr v-for="b, i in books.data" :key="b.id" class="text-gray-700">

                            <td class="px-4 py-3 texr-sm">
                                {{ (i + 1) }}
                            </td>
                            <td class="px-4 py-3 texr-sm">
                                {{ (b.isbn) }}
                            </td>
                            <td class="px-4 py-3 texr-sm">
                                {{ (b.title) }}
                            </td>
                            <td class="px-4 py-3 texr-sm">
                               <img :src="'storage'+b.image" width="50"> 
                            </td>
                            <td class="px-4 py-3 texr-sm">
                                <NavLink :href="route('books.show',b.id)">
                                <SecondaryButton><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </SecondaryButton>
                            </NavLink>
                            </td>
                            <td class="px-4 py-3 texr-sm">
                                <NavLink :href="route('books.edit',b.id)"> 
                                <WarninButton><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </WarninButton>
                            </NavLink>
                            </td>
                            <td class="px-4 py-3 texr-sm">
                                <DangerButton @click="openModalDel(b)"><svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                                    </svg>

                                </DangerButton>
                            </td>

                        </tr>
                    </tbody>

                </table>

            </div>
            <div
                class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                <pagination :links="books.links" />
            </div>

        </div>


        <Modal :show="showModalDel" @close="closeModalDel">

            <div class="p-6">

                <p class="text-2xl text-gray-500">
                    Are you sure delete to
                    <span class="text-2xl font-medium text-gray-900">{{ form.title }}</span>?
                </p>
                <PrimaryButton @click="deleteBook">yes, delete</PrimaryButton>


            </div>
            <div class="mt-6 flex justify-end"></div>
            <SecondaryButton @click="closeModalDel">Cancel</SecondaryButton>
        </Modal>
    </AuthenticatedLayout>
</template>