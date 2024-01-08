<script setup>
import DialogModal from "@/Components/DialogModal.vue";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {onUpdated, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputError from '@/Components/InputError.vue';
import Banner from '@/Components/Banner.vue';


const props = defineProps({ProductionModel: Object, showModelParent:Boolean, completeFunction:Function, flex_types: Object})


let modelUpdateForm = useForm({

    model_name: props.ProductionModel.model_name ?? null,
    flex_type_id:  props.ProductionModel.flex_type_id ?? null,
    reference_id: props.ProductionModel.reference_id ?? null,
    comment: props.ProductionModel.comment ?? null,
    is_active: props.ProductionModel.is_active ?? null

});

onUpdated(() => {
        modelUpdateForm.model_name= props.ProductionModel.model_name ?? null,
        modelUpdateForm.flex_type_id=  props.ProductionModel.flex_type_id ?? null,
        modelUpdateForm.reference_id= props.ProductionModel.reference_id ?? null,
        modelUpdateForm.comment= props.ProductionModel.comment ?? null,
        modelUpdateForm.is_active= props.ProductionModel.is_active ?? null
})

const close = () => {
    props.completeFunction(true)
}

const update = () => modelUpdateForm.put(
    route('production-model.update', { production_model: props.ProductionModel.id }),
    {
        preserveScroll: false,
        onSuccess: () => {modelUpdateForm.reset();
        close();
        },
    }
)

const deleteModel = () => {

    if (confirm("Sure you want to delete: "+props.ProductionModel.model_name)){

        modelUpdateForm.delete(route('production-model.destroy',{production_model: props.ProductionModel.id}),
            {
                preserveScroll: false,
                onSuccess: () => {modelUpdateForm.reset();
                    close();
                },
            }
        );

    }else{
        close();
    }
}


const submitForm = () => {
    update();
}

</script>
<template>
    <div>
        <dialog-modal :show="showModelParent" >

            <template #title>
                Edit Production Model : {{modelUpdateForm.model_name}}
            </template>

            <template #content>
                <div>

                    <form @submit.prevent="submitForm" >

                        <div  class="grid grid-cols-6 gap-4">

                            <div class="col-span-4">
                                <label class="block mb-1 text-gray-500 dark:text-gray-300 font-medium">Model</label>
                                <input v-model="modelUpdateForm.model_name" type="text" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500" />

                                <InputError class="mt-2" :message="modelUpdateForm.errors.model_name" />
                            </div>

                            <div class="col-span-4">

                                <label class="block mb-1 text-gray-500 dark:text-gray-300 font-medium">FlexType</label>
                                <select v-model="modelUpdateForm.flex_type_id" class="input-filter-l w-full rounded-md rounded-md shadow-sm border border-gray-300" >

                                    <option v-for="n in flex_types" :key="n.id" :value="n.id">{{ n.flex_name }}</option>

                                </select>

                                <InputError class="mt-2" :message="modelUpdateForm.errors.flex_type_id" />

                            </div>

                            <div class="col-span-4">
                                <label class="block mb-1 text-gray-500 dark:text-gray-300 font-medium">Ref Id</label>
                                <input v-model="modelUpdateForm.reference_id" type="text" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500" />

                                <InputError class="mt-2" :message="modelUpdateForm.errors.reference_id" />
                            </div>

                            <div class="col-span-4">
                                <label class="block mb-1 text-gray-500 dark:text-gray-300 font-medium">Comment</label>
                                <input v-model="modelUpdateForm.comment" type="text" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500" />
                                <InputError class="mt-2" :message="modelUpdateForm.errors.comment" />

                            </div>

                            <div class="col-span-4">

                                <label class="block  mb-1 text-gray-500 dark:text-gray-300 font-medium">IsActive</label>
                                <select v-model="modelUpdateForm.is_active" class="input-filter-l w-2/3 rounded-md rounded-md shadow-sm border border-gray-300" >

                                    <option value="1">Yes</option>
                                    <option value="0">No</option>

                                </select>

                                <InputError class="mt-2" :message="modelUpdateForm.errors.is_active" />

                            </div>

                        </div>
                    </form>

                </div>


            </template>

            <template #footer>

                <SecondaryButton class="bg-red-400" @click="deleteModel">
                    Delete
                </SecondaryButton>
                <SecondaryButton class="ml-1 bg-green-400"  @click="update">
                    Save
                </SecondaryButton>
                <SecondaryButton class="ml-1" @click="close()">
                    Close
                </SecondaryButton>
            </template>
        </dialog-modal>
    </div>
</template>


