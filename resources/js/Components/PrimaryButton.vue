<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    loading: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button :type="type" :disabled="loading" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">

        <span v-if="loading">
            Loading...
        </span>

        <span v-else>
            <slot />
        </span>

    </button>
</template>
