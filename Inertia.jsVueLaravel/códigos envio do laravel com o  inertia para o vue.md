# Como enviar variáveis do Laravel para o Vue usando o Inertia.js

O Inertia.js é uma poderosa biblioteca que permite criar aplicativos de página única (SPA) de forma mais simples e eficiente, combinando as vantagens do Vue.js com a estrutura familiar do Laravel. Neste artigo, vou mostrar várias maneiras de enviar variáveis do Laravel para o Vue usando o Inertia.js.

## Exemplo 1: Através de Props (Parâmetros)

No Laravel:
```php
public function index()
{
    $variavel = 'Exemplo de variável do Laravel';

    return Inertia::render('ExemploComponente', [
        'variavelProp' => $variavel,
    ]);
}
```
No Vue:

```vue
<template>
  <div>
    <p>{{ variavelProp }}</p>
  </div>
</template>

<script setup>
const { variavelProp } = usePage().props;
</script>

```

# Exemplo 2: Usando o Método `inertia()`
<br>
No Laravel:

```php
public function index()
{
    $variavel = 'Exemplo de variável do Laravel';

    return inertia('ExemploComponente', ['variavelProp' => $variavel]);
}
```


No Vue:


```vue
<template>
  <div>
    <p>{{ variavelProp }}</p>
  </div>
</template>

<script setup>
const { variavelProp } = usePage().props;
</script>
```

# Exemplo 3: Incluindo Dados ao Renderizar a Página
<br>
No Laravel:

```php
public function index()
{
    $variavel = 'Exemplo de variável do Laravel';

    return Inertia::render('ExemploComponente', [
        'variavelProp' => $variavel,
    ]);
}

```

No Vue:

```vue
<template>
  <div>
    <p>{{ variavelProp }}</p>
  </div>
</template>

<script setup>
const { variavelProp } = usePage().props;
</script>

```

# Exemplo 4: Utilizando o Helper page
<br>
No Laravel:

```php
public function share(Request $request)
{
    return [
        'variavelGlobal' => 'Exemplo de variável global do Laravel',
    ];
}

```

No Vue (dentro de qualquer componente):

```vue
<template>
  <div>
    <p>{{ variavelGlobal }}</p>
  </div>
</template>

<script setup>
const { variavelGlobal } = page;
</script>

```

# Exemplo 5: Através do Evento success
<br>
No Laravel:

```php
public function store(Request $request)
{
    // Processar os dados e salvar no banco de dados

    return Redirect::route('index.home')->with('success', 'Cadastro realizado com sucesso!');
}

```
No Vue (em qualquer página que redirecione para a rota com a mensagem de sucesso):

```vue
<template>
  <div>
    <p v-if="successMessage">{{ successMessage }}</p>
    <!-- Resto do conteúdo do componente -->
  </div>
</template>

<script setup>
import { ref } from 'vue';
const successMessage = ref(null);

const onSuccess = () => {
  successMessage.value = page.props.success;
};
</script>

```
# Exemplo 6: Através da Sessão
<br>
No Laravel:

```php
public function index()
{
    session(['variavelSessao' => 'Exemplo de variável da sessão do Laravel']);

    return Inertia::render('ExemploComponente');
}

```
No Vue (dentro de qualquer componente):

```vue
<template>
  <div>
    <p>{{ session('variavelSessao') }}</p>
  </div>
</template>

```




