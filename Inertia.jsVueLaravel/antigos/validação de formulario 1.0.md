# Validando formularios com inertia vue e laravel

<br>

No componente princinpal onde está o formulario

```javascript
<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    menubase: '',
    icon: '',
});

function submit() {
    form.post(route('new_menu'));
}

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
</script>
```

no HTML

```html
<form @submit.prevent="submit">
    <div class="row">
        <div class="col-md-12">
            <div
                :class="{ 'input-group input-group-outline  my-3': true, 'is-invalid': form.errors.menubase, 'is-valid': !form.errors.menubase }"
            >
                <input
                    type="text"
                    v-model="form.menubase"
                    name="menubase"
                    placeholder="Nome do Menu"
                    id="menubase"
                    class="form-control"
                />
            </div>
            <div class="text-red-500" v-if="form.errors.menubase">
                {{ Menssagem_Menubase() }}
            </div>
        </div>

        <div class="col-md-12">
            <div
                :class="{ 'input-group input-group-outline  my-3': true, 'is-invalid': form.errors.icon, 'is-valid': !form.errors.icon }"
            >
                <input
                    type="text"
                    v-model="form.icon"
                    name="icon"
                    placeholder="Nome do Icone"
                    id="icon"
                    class="form-control"
                />
            </div>
            <div class="text-red-500" v-if="form.errors.icon">
                {{ Menssagem_MenuIcon() }}
            </div>
            <a
                href="https://www.w3schools.com/icons/icons_reference.asp"
                target="_blank"
            >
                <span>Link para os icones aqui: escolha Google</span>
            </a>
        </div>
    </div>
    <div class="col-md-12 d-flex justify-content-end rigth_div">
        <button type="submit" class="btn border ms-auto">Criar</button>
    </div>
</form>
```
no laravel

```php
   public function newMenuPost(Request $request){
            MenuBd::create($request->validate([
                'menubase' => ['required', 'max:50'],
                'icon' => ['required', 'max:50'],
              ]));
            return to_route('new_menu');
    }

    ```