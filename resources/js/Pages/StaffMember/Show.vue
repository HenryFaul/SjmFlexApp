<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, ref, watch, inject} from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {router, useForm, usePage} from "@inertiajs/vue3";
import InputError from '@/Components/InputError.vue';



const swal = inject('$swal');


const props = defineProps({
    staff_member: Object,
});
const permissions = computed(() => usePage().props.permissions)

/*'title','first_name','last_name','is_active','staff_clock_no'*/

let Form = useForm({

    first_name: props.staff_member.first_name ?? null,
    last_name: props.staff_member.last_name ?? null,
    title: props.staff_member.title ?? null,
    is_active: props.staff_member.is_active ?? false,
    staff_clock_no: props.staff_member.staff_clock_no ?? null,

});

const updateStaff = () => {
    Form.put(route('staff.update', props.staff.staff.id),
        {
            preserveScroll: true,
            onSuccess: () => {
                swal(usePage().props.jetstream.flash?.banner || '');
                toggleEdit();
            },
        }
    );
}

const emptyErrors = computed(() => Object.keys(Form.errors).length === 0 && Form.errors.constructor === Object)

const editDisabled = ref(true);
const toggleEdit = () => {
    editDisabled.value = !editDisabled.value;
};

//const roles_permissions = computed(() => usePage().props.roles_permissions);
//const can_manage_users = computed(() => usePage().props.roles_permissions.permissions.includes("manage_users"));

</script>

<template>
    <AppLayout title="Staff">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Staff / <span class="text-indigo-400">{{ Form.first_name }} {{ Form.last_name }} </span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div
                        :class="!emptyErrors ?'m-2 p-2 rounded-md rounded-md shadow-sm border border-red-500':  editDisabled ? 'm-2 p-2':'m-2 p-2 rounded-md rounded-md shadow-sm border border-indigo-500' ">
                        <div class="">
                            <form>
                                <div class="text-lg mb-4 text-indigo-400">Staff details</div>
                                <div class="space-y-12">
                                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                                        <div>
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Static Information</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Static Staff information.</p>
                                        </div>

                                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">

                                            <div class="sm:col-span-3">
                                                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                                                <div class="mt-2">
                                                    <input v-model="Form.title" :disabled="editDisabled" type="text" name="title" id="title"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                </div>
                                                <InputError class="mt-2" :message="Form.errors.title"/>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                                                <div class="mt-2">
                                                    <input v-model="Form.first_name" :disabled="editDisabled" type="text" name="first_name" id="first_name"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                </div>
                                                <InputError class="mt-2" :message="Form.errors.first_name"/>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="last_legal_name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
                                                <div class="mt-2">
                                                    <input v-model="Form.last_name" :disabled="editDisabled" type="text" name="last_legal_name" id="last_legal_name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                </div>
                                                <InputError class="mt-2" :message="Form.errors.last_name"/>
                                            </div>


                                            <div class="sm:col-span-3">
                                                <label for="id_reg_no" class="block text-sm font-medium leading-6 text-gray-900">Clock No</label>
                                                <div class="mt-2">
                                                    <input v-model="Form.staff_clock_no" type="text" :disabled="editDisabled" name="id_reg_no" id="id_reg_no" autocomplete="id_reg_no" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                </div>
                                                <InputError class="mt-2" :message="Form.errors.staff_clock_no"/>
                                            </div>


                                            <div class="sm:col-span-3">
                                                <label for="id_reg_no" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                                                <div class="mt-2">
                                                    <select v-model="Form.is_active"
                                                            class="input-filter-l block w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <option :value=1>Active</option>
                                                        <option :value=0>Inactive</option>
                                                    </select>

                                                </div>
                                                <InputError class="mt-2" :message="Form.errors.is_active"/>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="mt-6 flex items-center justify-end gap-x-6">

                                    <SecondaryButton class="m-1" @click="toggleEdit">
                                        Edit
                                    </SecondaryButton>

                                    <SecondaryButton v-if="!editDisabled && can_manage_users" @click="updateStaff" class="m-1">
                                        Save
                                    </SecondaryButton>
                                </div>
                            </form>
                        </div>


                    </div>

                </div>

            </div>


        </div>
    </AppLayout>
</template>
