# GIF de carregemento com vue.js na atualização das páginas

No arquivo ```resources/js/router.js``` informar quando mostrar e esconder o gif de carregamento:

```
import isLoadingStore from './config/isLoadingStore'; 

// alterar o titulo do site dinamicamente
    router.beforeEach(async (to, from, next) => {
        // saber quando a página está carregando
        isLoadingStore.commit('setIsLoading', true);
    });

    router.afterEach(() => {
        // Defina isLoading como false após a navegação
        isLoadingStore.commit('setIsLoading', false);
    }); 
```
<br>

No arquivo  ```resources/js/componets.js``` importar o componente: <br>
```routerviewpage.vue```, onde irar chamar o GIF e o ```<router-view />```
<br>

```
import routerviewpage from "@/components/routerviewpage.vue";

app.component('routerviewpage', routerviewpage);
```

No arquivo ```resources/js/app.js``` importa o componente a configuração do isLoadingStore.

```
import isLoadingStore from './config/isLoadingStore'; 

app.use(isLoadingStore);
```
