<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <img :src="$page.props.app_logo"  alt="logo">
    </Link>
</template>
