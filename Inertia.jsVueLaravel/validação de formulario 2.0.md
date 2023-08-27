# Validação usando o  VUELIDATE

# VALIDAÇÃO COM VUELIDATE PRONTA E FUNCIONANDO (código final)

```html
<script>
import useValidate from '@vuelidate/core'
import { required, maxLength } from '@vuelidate/validators'
import { ref, computed } from 'vue'
import { useForm, usePage, router  } from '@inertiajs/vue3'


export default {

    setup() {
    const { idMenu } = usePage().props;
    
    const submit = ref(false);
    const IsLoading = ref(false);

    const state = useForm({
      name: '',
      href: '',
      route: '',
      idMenu: idMenu,
    });

    // reset
    const reset = () => {
        const hrefInput = document.getElementById('href');
        const routeInput = document.getElementById('Route');

        hrefInput.disabled = false; 
        routeInput.disabled = false;

        state.name = ""; 
        state.href = ""; 
        state.route = "";

        submit.value = false;
    };

    // bloquear input não escolhido ( disabled )
    const SelectInput = computed( () => {
        const hrefInput = document.getElementById('href');
        const routeInput = document.getElementById('Route');
        
        return (Selected) => {
            if (Selected === 'route' && state.route !== "") {
                hrefInput.disabled = true;
                routeInput.disabled = false;
            } else if (Selected === 'href'  && state.href !== "") {
                hrefInput.disabled = false;
                routeInput.disabled = true;
            } else {
                hrefInput.disabled = false;
                routeInput.disabled = false;
            }
        };
    });

    const Limitname = 19; // Limite maximo para o imput Name

    // Validação dos Inputs
    const rules = computed(() => {
        const validateHref  = state.href.trim().length > 0 && state.route.trim().length === 0;
        const validateRoute = state.route.trim().length > 0 && state.href.trim().length === 0;

        const nameValidation = { name: { required, maxLength: maxLength(Limitname) } }
        const linkValidation = {  };

        if (validateHref) {
            linkValidation.href = { required };
        } else if (validateRoute) {
            linkValidation.route = { required };
        } else {
            linkValidation.href = { required };
            linkValidation.route = { required };
        }

        return {
            ...nameValidation,
            ...linkValidation
        };
    })


    const ValidateInputs = (NameInput) => {
        if(NameInput === "name" && state.name !== "" || state.name.trim().length > 0) return true; else
        if(NameInput === "href" && state.href !== "" || state.href.trim().length > 0) return true; else
        if(NameInput === "route" && state.route !== "" || state.route.trim().length > 0) return true; else
        if(NameInput === "name_izero" && state.name === "" || state.name.trim().length === 0) return true; else
        return false;
    }

    const ValidateMsgs = (errors) => {
        if(errors === "required") return 'Campo obrigatório!'; else
        if(errors === "limitMax") return 'Limite de ' + Limitname +' caracteres atingido!'; else
        if(errors === "limitHrefRoute") return 'Digite uma Url ou uma Rota';
    }

    const ClassInputs = (ClassDiv) => {
        if(ClassDiv === "invalid") return 'is-invalid'; else
        if(ClassDiv === "valid") return 'is-valid';
    }

    const v$ = useValidate(rules, state);

    return { 
        state, 
        v$, 
        SelectInput,
        submit,
        IsLoading,
        Limitname,
        idMenu,
        reset,
        ValidateInputs,
        ValidateMsgs,
        ClassInputs,
              
    }
 },
 methods: {
    alertSuccess(){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Sub Menu criado com sucesso',
            showConfirmButton: false,
            timer: 1500
            })
    },
    alertError(){
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Erro ao criar Sub menu',
            showConfirmButton: false,
            timer: 1500
            })
    },
    async submitPost(){
        try {
            this.IsLoading = true;
            router.post(route('newSubMenuPost'), this.state, {
                    onBefore: (visit) => {},
                    onStart: (visit) => {},
                    onProgress: (progress) => {},
                    onSuccess: (page) => { this.alertSuccess(); this.reset(); },
                    onError: (errors) => { this.alertError(); },
                    onCancel: () => {},
                    onFinish: visit => { this.IsLoading = false; },
                });
        } catch (error) {
            console.log(error);
        }
    },
    submitForm() {
    this.v$.$validate(); // valida todos os inputs
    this.submit = true;

    if (!this.v$.$error) {
      this.submitPost();
    }
  },
    submitTrue(){
        if(this.submit == true) return true;
        else return false;
    },
    errorsMsgInput(NameInput){
        
        // Validação Input NAME
       if(NameInput === "name" && (this.ValidateInputs('name') || (this.submitTrue()))) // se input name for maior ou igual a 1 ou diferente de nada
       {
        this.v$.name.$validate();
        const validatorName = () =>{ return this.v$.name.$errors[0].$validator; };

        if(!this.v$.name.$errors[0]) return ['', this.ClassInputs('valid')]; else
        if(validatorName() === "maxLength") return [this.ValidateMsgs('limitMax'), this.ClassInputs('invalid')];else
        if(validatorName() === "required" && (this.submitTrue())) return [this.ValidateMsgs('required'), this.ClassInputs('invalid')]; else return[];

       } else

       // Validação Input HREF
       if(NameInput === "href" && ((this.ValidateInputs('href') || this.ValidateInputs('route')) || (this.submitTrue()))) 
       {
        this.v$.$validate();
        try {
            const validatorHref = () =>{ return this.v$.href.$errors[0].$validator; };
            if(NameInput === "href"){
                if(!this.v$.href.$errors[0]) return ['', this.ClassInputs('valid')]; else
                if(validatorHref() === "required" && (this.submitTrue())) return [this.ValidateMsgs('limitHrefRoute'), this.ClassInputs('invalid')];
            } 
            else return [];
            
        } catch (error) { } return [];

       }else

       // Validação Input ROUTE
       if(NameInput === "route" && ((this.ValidateInputs('href') || this.ValidateInputs('route')) || (this.submitTrue()))) 
       {
        this.v$.$validate();
        try {
                const validatorRoute = () =>{ return this.v$.route.$errors[0].$validator; };
                if(NameInput === "route"){
                    if(!this.v$.route.$errors[0]) return ['', this.ClassInputs('valid')]; else
                    if(validatorRoute() === "required" && (this.submitTrue())) return [this.ValidateMsgs('required') + ' ROUTE', this.ClassInputs('invalid')]; 
                } else return [];

            } catch (error) { } return [];
       }
    },
  }, 
}
</script>
<template>
    <settings>
        <template #header>Criar Sub </template>

        <form @submit.prevent="submitForm" >

            <LoadingContainer v-if="IsLoading" />


            <div class="row">
                <div class="col-md-12">
                    <!-- is-invalid      is-valid -->
                    <div :class="`input-group input-group-outline my-3  ${ errorsMsgInput('name')[1] }`">
                        <input type="text" name="NameSubMenu" v-model="state.name" placeholder="Nome do Sub Menu"
                            id="NameSubMenu" class="form-control">
                            
                    </div>
                    <span class="text-red-500" v-if="errorsMsgInput('name')">
                        {{ errorsMsgInput('name')[0] }}
                    </span>
                </div>


                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="col-md-12">
                                <div :class="`input-group input-group-outline my-3  ${ errorsMsgInput('href')[1] }`">
                                    <input  type="text" @change="SelectInput('href')" v-model="state.href" name="href" placeholder="Link da página" id="href" class="form-control">   
                                </div>
                               <span class="text-red-500" v-if="errorsMsgInput('href')">
                                    {{ errorsMsgInput('href')[0] }}
                                </span>
                                    <br>
                                    <br>
                            </div>
                        </div>

                        <div class="col-md-1 text-center align-self-center">
                            Ou
                        </div>

                        <div class="col">

                            <div class="col-md-12">
                                <div :class="`input-group input-group-outline my-3  ${ errorsMsgInput('route')[1] }`">
                                    <input type="text" @change="SelectInput('route')" v-model="state.route" name="Route" placeholder="Nome da Rota" id="Route" class="form-control">
                                       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-end rigth_div">
                <button type="reset" @click="reset" class="btn border ">novo</button>
                <button type="submit" :disabled="state.processing" class="btn border ms-auto">Criar</button>
            </div>

        </form>
    </settings>
</template>


```

---
---
---
---



# com Vuelidate versão 2
```html

<template>
    <div class="root">
      <h2>Create an Account</h2>
      <p>
        <input type="text" placeholder="Email" v-model="state.email" />
        <span :class="`text-red-500 ${ errorsMsgEmail()[1] }`" v-if="errorsMsgEmail()">
          {{ errorsMsgEmail()[0] }}
        </span>
        
    </p>
      <p>
        <input
          type="password"
          placeholder="Password"
          v-model="state.password.password"
        />
        <span class="text-red-500" v-if="errorPass()">
            {{ errorPass()[0] }}
        </span>
      </p>
      <p>
        <input
          type="password"
          placeholder="Confirm Password"
          v-model="state.password.confirm"
        />
        <span class="text-red-500" v-if="errorPassPass()">
            {{ errorPassPass()[0] }}
        </span>
      </p>
      <button @click="submitForm">Submit</button>
    </div>
  </template>


<script>
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs } from '@vuelidate/validators'
import { reactive, computed } from 'vue'

export default {
    setup() {
    const state = reactive({
      email: '',
      password: {
        password: '',
        confirm: '',
      },
    })

    const rules = computed(() => {
    return {
        email: { 
            required, 
            email,
        },
        password: {
            password: { required, minLength: minLength(6) },
            confirm: { required, sameAs: sameAs(state.password.password) },
        },
    }
    })

    const v$ = useValidate(rules, state)

    return { state, v$ }
 },

 methods: {
    submitForm() {
        this.v$.$validate() // checks all inputs
        if (!this.v$.$error) {
            alert('Form successfully submitted.')
        } else {
            alert('Form failed validation')
        }
    },
    errorsMsgEmail(){
        if(this.state.email.trim().length >= 1 ){
            this.v$.email.$validate();
            if(this.v$.email.$errors[0]){ 
                return  [this.v$.email.$errors[0].$message, 'is-class'];
            }else{
                return ['Válido', 'text-decoration-line-through'];
            }
        }
    },
    errorPass(){
        if(this.state.password.password.trim().length >= 1 ){
            this.v$.password.$validate();
            if(this.v$.password.password.$errors[0]){ 
                return  [this.v$.password.password.$errors[0].$message, 'is-class'];
            }else{
                return ['Válido', 'text-decoration-line-through'];
            }
        }
    },
    errorPassPass(){
        if(this.state.password.confirm.trim().length >= 1 || this.state.password.password.trim().length >= 1 ){
            this.v$.password.$validate();
            if(this.v$.password.confirm.$errors[0]){ 
                return  [this.v$.password.confirm.$errors[0].$message, 'is-class'];
            }else{
                return ['Válido', 'text-decoration-line-through'];
            }
        }
    },
  },

}
 
</script>

<style lang="css">
.root {
  width: 400px;
  margin: 0 auto;
  background-color: #fff;
  padding: 30px;
  margin-top: 100px;
  border-radius: 20px;
}

input {
  border: none;
  outline: none;
  border-bottom: 1px solid #ddd;
  font-size: 1em;
  padding: 5px 0;
  margin: 10px 0 5px 0;
  width: 100%;
}

button {
  background-color: #3498db;
  padding: 10px 20px;
  margin-top: 10px;
  border: none;
  color: white;
}
</style>

```







## TIPO 2
```html
<template>
    <div class="root">
      <h2>Create an Account</h2>
      <p>
        <input type="text" placeholder="Email" v-model="state.email" />
        <span v-if="v$.email.$error">
          {{ v$.email.$errors[0].$message }}
        </span>
      </p>
      <p>
        <input
          type="password"
          placeholder="Password"
          v-model="state.password.password"
        />
        <span v-if="v$.password.password.$error">
          {{ v$.password.password.$errors[0].$message }}
        </span>
      </p>
      <p>
        <input
          type="password"
          placeholder="Confirm Password"
          v-model="state.password.confirm"
        />
        <span v-if="v$.password.confirm.$error">
          {{ v$.password.confirm.$errors[0].$message }}
        </span>
      </p>
      <button @click="submitForm">Submit</button>
    </div>
  </template>


<script>
import useValidate from '@vuelidate/core'
import { required, email, minLength, sameAs, helpers } from '@vuelidate/validators'
import { reactive, computed } from 'vue'

export default {
    setup() {
    const state = reactive({
      email: '',
      password: {
        password: '',
        confirm: '',
      },
    })

    // validação personalizada
    //const mustBeLearnVue = (value) => value.includes('learnvue')
    //mustBeLearnVue:   helpers.withMessage('Must be learnvue', mustBeLearnVue),
    const rules = computed(() => {
    return {
        email: { 
            required, 
            email,
        },
        password: {
            password: { required, minLength: minLength(6) },
            confirm: { required, sameAs: sameAs(state.password.password) },
        },
    }
    })

    const v$ = useValidate(rules, state)

    return { state, v$ }
 },

 methods: {
    submitForm() {
        this.v$.$validate() // checks all inputs
        if (!this.v$.$error) {
            // if ANY fail validation
            alert('Form successfully submitted.')
        } else {
            alert('Form failed validation')
        }
    },
  },

}

</script>

<style lang="css">
.root {
  width: 400px;
  margin: 0 auto;
  background-color: #fff;
  padding: 30px;
  margin-top: 100px;
  border-radius: 20px;
}

input {
  border: none;
  outline: none;
  border-bottom: 1px solid #ddd;
  font-size: 1em;
  padding: 5px 0;
  margin: 10px 0 5px 0;
  width: 100%;
}

button {
  background-color: #3498db;
  padding: 10px 20px;
  margin-top: 10px;
  border: none;
  color: white;
}
</style>
```







# Validação de formulario no vue com laravel manualmente


No componente vue

```html

<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue';

const form = useForm({
    menubase: '',
    icon: '',
});

function submit() {
    form.post(route('new_menu'));
    submitClicked.value = true;
}
const submitClicked = ref(false);
const SucessOn = computed(() =>{
    if(!Menssagem_Menubase() && !Menssagem_MenuIcon()){
        return ['Enviado com Sucesso!', 'text-success'];
    }else{
        return ['Verifique o erro e tente novamente', 'text-danger'];
    }
});


const Menssagem_Menubase = () => {
    if (form.errors.menubase == "validation.max.string") {
        return "Limite de caracteres atingido!";
    }
    else if (form.errors.menubase == "validation.required") {
        return "Campo obrigatório";
    }
}
const Menssagem_MenuIcon = () => {
    if (form.errors.icon == "validation.max.string") {
        return "Limite de caracteres atingido!";
    }
    else if (form.errors.icon == "validation.required") {
        return "Campo obrigatório";
    }

}


const LimitMenubase = 19;
const LimitIcon = 225;

const isClass = computed(() => {
    // MenuBase
    const trimmedLength = form.menubase.trim().length;
    const hasErrorMenubase = form.errors.menubase;
    const isValidLengthMenubase = trimmedLength > 0 && trimmedLength <= LimitMenubase;
    // Icon
    const trimmedLengthIcon = form.icon.trim().length;
    const hasErrorIcon = form.errors.icon;
    const isValidLengthIcon = trimmedLengthIcon > 0 && trimmedLengthIcon <= LimitIcon;

    // Validação invalid
    const ValidateMenuBase_invalid = (hasErrorMenubase && !isValidLengthMenubase || trimmedLength > LimitMenubase);
    const ValidateIcon_invalid = (hasErrorIcon && !isValidLengthIcon || trimmedLengthIcon > LimitIcon); 
    // Validação valid
    const ValidateMenuBase_valid = (!hasErrorMenubase && isValidLengthMenubase || trimmedLength > 0 && trimmedLength < LimitMenubase);
    const ValidateIcon_valid = (!hasErrorIcon && isValidLengthIcon || trimmedLengthIcon > 0 &&  trimmedLengthIcon < LimitIcon);


    return (field) => ({
        'input-group': true,
        'input-group-outline': true,
        'my-3': true,
        'is-invalid':
            (field === 'menubase' && ValidateMenuBase_invalid) ||
            (field === 'icon' && ValidateIcon_invalid),
        'is-valid':
            (field === 'menubase' && ValidateMenuBase_valid) ||
            (field === 'icon' && ValidateIcon_valid),
    });
});

</script>
<template>
    <settings>
        <template #header>Criar novo menu do site</template>

        <form @submit.prevent="submit">
            <div class="row">
                <div class="col-md-12">
                    <div :class="isClass('menubase')">
                        <input type="text" v-model="form.menubase" name="menubase" placeholder="Nome do Menu" id="menubase"
                            class="form-control">
                    </div>
                    <div class="text-red-500" v-if="form.errors.menubase">{{ Menssagem_Menubase() }}</div>
                </div>

                <div class="col-md-12">
                    <div :class="isClass('icon')">
                        <input type="text" v-model="form.icon" name="icon" placeholder="Nome do Icone" id="icon"
                            class="form-control">
                    </div>
                    <div class="text-red-500" v-if="form.errors.icon">{{ Menssagem_MenuIcon() }}</div>
                    <a href="https://www.w3schools.com/icons/icons_reference.asp" target="_blank">
                        <span>Link para os icones aqui: escolha Google</span>
                    </a>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-end rigth_div">
                <button type="submit" class="btn border ms-auto">Criar</button>
            </div>
            <div :class="`btn text-center text-success ${ SucessOn[1] }`" v-if="submitClicked">{{ SucessOn[0] }}</div>
        </form>
    </settings>
</template>

```


No controller do laravel

```php
public function newMenuPost(Request $request){
    MenuBd::create($request->validate([
        'menubase' => ['required', 'max:19'],
        'icon' => ['required', 'max:225'],
        ]));
    return to_route('new_menu');
}

```
<br>
<br>

---

# Outras versões funcionando

```html
<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue';

const { idMenu } = usePage().props;
const submitClicked = ref(false);
const ErrorActive = ref(false);

const form = useForm({
    name: '',
    href: '',
    route: '',
    idMenu: idMenu,
});

const LimiteName = 19;
const LimitMinName = 3;

function maxLength(baseInput, int){
    if(baseInput.trim().length <= int){
        return [true, baseInput.trim().length];
    }
    return [false, baseInput.trim().length];
}

function minLength(baseInput, int){
    if(baseInput.trim().length >= int){
        return [true, baseInput.trim().length];
    }
    return [false, baseInput.trim().length];
}

const FormName = computed(() => {
const Limit  = maxLength(form.name, LimiteName)[0] && minLength(form.name, LimitMinName)[0];
const LimitMin = (minLength(form.name, LimitMinName)[1] < LimitMinName);
const LimitMaior = (minLength(form.name, LimitMinName)[1] >= 1);

if(minLength(form.name, LimitMinName)[0]){
    if(Limit){
        return ['is-valid','tudo certo aqui', 'text-success'];
    }else if(!Limit){
        return ['is-invalid', 'Limite utrapassado', 'text-red-500']
    }
}else if(LimitMin && LimitMaior){
    return ['is-invalid','No minimo 3 caracteres', 'text-red-500'];
}else{
    return [];
}



});

</script>
<template>
    <settings>
        <template #header>Criar Sub </template>
        <form @submit.prevent="submitValidate">
            <div class="row">
                <div class="col-md-12">
                    <div :class="`input-group input-group-outline my-3 ${ FormName[0] }`">
                        <input type="text" name="NameSubMenu" v-model="form.name" placeholder="Nome do Sub Menu"
                            id="NameSubMenu" class="form-control">
                    </div>
                    <div :class="FormName[2]" v-if="FormName[0]">{{ FormName[1] }}</div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="col-md-12">
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" v-model="form.href" name="href" placeholder="Link da página" id="href"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1 text-center align-self-center">
                            Ou
                        </div>

                        <div class="col">

                            <div class="col-md-12">
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" v-model="form.route" name="Route" placeholder="Nome da Rota" id="Route"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-end rigth_div">
                <button type="reset" @click="reset" class="btn border ">novo</button>
                <button type="submit" class="btn border ms-auto">Criar</button>
            </div>

        </form>
    </settings>
</template>
```

# VALIDAÇÃO MANUAL GUARDADA
```HTML
<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue';

const { idMenu } = usePage().props;
const submitClicked = ref(false);
const SuccessOk = ref(false);
const ErrorActive = ref(false);

const form = useForm({
    name: '',
    href: '',
    route: '',
    idMenu: idMenu,
});

function submitValidate(){
    if(form.name && (form.href || form.route) && Validatename_valid && (Validateroute_valid ||  ValidateHref_valid)){
        submit();
    }else{
        const requeridVal = "validation.required";

        if(form.errors.name === undefined)
        {
            form.errors.name = requeridVal;
        }

        form.errors.href = requeridVal;
        form.errors.route = requeridVal;
        ErrorActive.value = true;
        submitClicked.value = true;
    }
}

async function submit() {
    try {
        form.post(route('newSubMenuPost'));
            submitClicked.value = true;
            SuccessOk.value = true;
            ErrorActive.value = false;

    } catch (error) {
        ErrorActive.value = true;
    }

    
}

const reset = () => {
    const hrefInput = document.getElementById('href');
    const routeInput = document.getElementById('Route');

    form.name = "";
    form.href = "";
    form.route = "";

    hrefInput.disabled = false;
    routeInput.disabled = false;
    
    submitClicked.value = false;
    ErrorActive.value = false;
};

//#region MENSAGENS

const SucessOn = computed(() => {
    if (!Menssagem_name() && SuccessOk && (!Menssagem_Menuroute() || !Menssagem_MenuHref())) {
        return ['Enviado com Sucesso!', 'text-success'];
    } else if(ErrorActive) {
        return ['Verifique o erro e tente novamente', 'text-danger'];
    }else{
        return '';
    }
});
function Msg(errors){
    if (errors == "validation.max.string") {
        return "Limite de caracteres atingido!";
    }
    else if (errors == "validation.required") {
        return "Campo obrigatório";
    }
}

const Menssagem_name = () => Msg(form.errors.name);
const Menssagem_Menuroute = () =>  Msg(form.errors.route);
const Menssagem_MenuHref = () =>  Msg(form.errors.href);

    // bloquear input não escolhido
    const SelectInput = computed(() => {
    const hrefInput = document.getElementById('href');
    const routeInput = document.getElementById('Route');
    
    return (Selected) => {
        if (Selected === 'route' && form.route !== "") {
            hrefInput.disabled = true;
            routeInput.disabled = false;
        } else if (Selected === 'href'  && form.href !== "") {
            hrefInput.disabled = false;
            routeInput.disabled = true;
        } else {
            hrefInput.disabled = false;
            routeInput.disabled = false;
        }
    };
});

function InputErros(){
    if(Validatename_valid.value || (Validateroute_valid.value || ValidateHref_valid.value)){
        ErrorActive.value = false;
        submitClicked.value = false;
    }
}


// limite de caracteres
const Limitname = 19;
const Limitroute = 225;
const LimitHref = 225;

const Validatename_invalid = ref(false);
const Validateroute_invalid = ref(false);
const ValidateHref_invalid = ref(false);

const Validatename_valid = ref(false);
const Validateroute_valid = ref(false);
const ValidateHref_valid = ref(false);

// class de aviso
const isClass = computed(() => {
    // name
    const trimmedLength = form.name.trim().length;
    const hasErrorname = form.errors.name;
    const isValidLengthname = trimmedLength > 0 && trimmedLength <= Limitname;
    // route
    const trimmedLengthroute = form.route.trim().length;
    const hasErrorRoute = form.errors.route;
    const isValidLengthroute = trimmedLengthroute > 0 && trimmedLengthroute <= Limitroute;

    const trimmedLengthHref = form.href.trim().length;
    const hasErrorHref = form.errors.href;
    const isValidLengthHref = trimmedLengthHref > 0 && trimmedLengthHref <= LimitHref;

    // Validação invalid
    Validatename_invalid.value = (hasErrorname && !isValidLengthname || trimmedLength > Limitname);
    Validateroute_invalid.value = (hasErrorRoute && !isValidLengthroute || trimmedLengthroute > Limitroute);
    ValidateHref_invalid.value = (hasErrorHref && !isValidLengthHref || trimmedLengthHref > LimitHref);
    // Validação valid
    Validatename_valid.value = (!hasErrorname && isValidLengthname || trimmedLength > 0 && trimmedLength < Limitname);
    Validateroute_valid.value = (!hasErrorRoute && isValidLengthroute || trimmedLengthroute > 0 && trimmedLengthroute < Limitroute);
    ValidateHref_valid.value = (!hasErrorHref && isValidLengthHref || trimmedLengthHref > 0 && trimmedLengthHref < LimitHref);


    // condicional de validação
    (Validatename_valid.value) ? form.errors.name = undefined : '';
    (Validateroute_valid.value || ValidateHref_valid.value) ? (form.errors.href = undefined, form.errors.route = undefined) : '';
    //(Validatename_valid.value || (Validateroute_valid.value || ValidateHref_valid.value)) ? (ErrorActive.value = false, submitClicked.value = false) : '';
  

    return (field) => ({
        'input-group': true,
        'input-group-outline': true,
        'my-3': true,
        'is-invalid':
            (field === 'name' && Validatename_invalid.value) || 
            (field === 'route' && Validateroute_invalid.value) ||
            (field === 'href' && ValidateHref_invalid.value),
        'is-valid':
            (field === 'name' && Validatename_valid.value) || 
            (field === 'route' && Validateroute_valid.value)||
            (field === 'href' && ValidateHref_valid.value),
    });
});
//#endregion
</script>
<template>
    <settings>
        <template #header>Criar Sub </template>

        <form @submit.prevent="submitValidate">
            <div class="row">
                <div class="col-md-12">
                    <div :class="isClass('name')">
                        <input type="text" @input="InputErros()" name="NameSubMenu" v-model="form.name" placeholder="Nome do Sub Menu"
                            id="NameSubMenu" class="form-control">
                    </div>
                    <div class="text-red-500" v-if="form.errors.name">{{ Menssagem_name() }}</div>
                </div>


                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="col-md-12">
                                <div :class="isClass('href')">
                                    <input @input="InputErros()" type="text" @change="SelectInput('href')" v-model="form.href" name="href" placeholder="Link da página" id="href"
                                        class="form-control">
                                </div>
                                <div class="text-red-500" v-if="form.errors.href">{{ Menssagem_MenuHref() }}</div>
                            </div>
                        </div>

                        <div class="col-md-1 text-center align-self-center">
                            Ou
                        </div>

                        <div class="col">

                            <div class="col-md-12">
                                <div :class="isClass('route')">
                                    <input @input="InputErros()" type="text" @change="SelectInput('route')" v-model="form.route" name="Route" placeholder="Nome da Rota" id="Route"
                                        class="form-control">
                                </div>
                                <div class="text-red-500" v-if="form.errors.route">{{ Menssagem_Menuroute() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="`btn text-center text-success ${ SucessOn[1] }`" v-if="submitClicked || (submitClicked && ErrorActive)">
                    {{ SucessOn[0] }}
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-end rigth_div">
                <button type="reset" @click="reset" class="btn border ">novo</button>
                <button type="submit" class="btn border ms-auto">Criar</button>
            </div>

        </form>
    </settings>
</template>
```
