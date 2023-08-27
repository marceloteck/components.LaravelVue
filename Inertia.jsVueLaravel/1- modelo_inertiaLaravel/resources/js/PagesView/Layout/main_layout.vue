<template>
  <main>
    <navbar />
    <slot />
    <thefooter />
  </main>
</template>

<script setup>
import { provide } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
const currentPage = usePage();
provide('currentPage', currentPage);
</script>
