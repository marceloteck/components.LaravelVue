<template>
    <MainLayout>
        <AppHead title="Título pages" description="esta é uma descrição" />
        <homeview />
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/PagesView/Layout/main_layout.vue';
import { inject } from 'vue';
const { imagePath } = inject('globalVariables');
</script>
