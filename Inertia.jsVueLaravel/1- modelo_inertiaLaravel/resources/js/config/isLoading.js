import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

// Gif de carregamento
const carregamento = reactive({ isLoading: false });
const showLoading = () => { carregamento.isLoading = true; };
const hideLoading = () => { carregamento.isLoading = false; };
router.on('start', showLoading);
router.on('finish', hideLoading);

export default carregamento;