import { computed, ref } from 'vue';
import { defineStore } from 'pinia';
import http from '@/config/http.js';
import { useRouter } from 'vue-router';

// exportar a const UserAuthLogin
export const UseAuthLogin = defineStore('auth', () => {
    const token = ref(localStorage.getItem('token'));
    const user = ref(JSON.parse(localStorage.getItem('user')));

    // armazenar o token no localStorage
    function setToken(tokenValue) {
        localStorage.setItem('token', tokenValue);
        token.value = tokenValue;
      }
    
      // armazenar o user no localStorage
      function setUser(userValue) {
        localStorage.setItem('user', JSON.stringify(userValue));
        user.value = userValue;
      }

      // verificar se o token é valido
      async function checkToken(){
        try {
          const tokenAuth = 'Bearer ' + token.value;
          const { data } = await http.get('/loginUser/verify',{
            headers: {
              Authorization: tokenAuth
            }
          });
          return data;
        } catch (error) {
          console.log(error.response.data);
        }
      }

      // se estiver logado
      const isAuthenticated = computed(() =>{
        return (token.value && user.value) ?? '';
      });

      const UserName = computed(() =>{
        return user.value.name ?? '';
      });

      // Logout de usuario
      const router = useRouter();
      function clearLogout(){
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        token.value = '';
        user.value = '';
        router.push({ name: 'login' });
      }

      // retornar as funções
      return {
        token,
        user,
        setToken,
        setUser,
        checkToken,
        isAuthenticated,
        UserName,
        clearLogout,
      };
});