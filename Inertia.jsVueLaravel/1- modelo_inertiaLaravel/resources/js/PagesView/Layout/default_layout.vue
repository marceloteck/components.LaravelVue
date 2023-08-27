<template>
    <Loading v-if="carregamento.isLoading" />
    <slot />
</template>
  
<script setup>
    import { provide, reactive } from 'vue';
    const { carregamento, globalVariables } = defineProps(['carregamento', 'globalVariables']);

    const localCarregamento = reactive(carregamento);

    provide('carregamento', localCarregamento);
    provide('globalVariables', globalVariables);
</script>  
