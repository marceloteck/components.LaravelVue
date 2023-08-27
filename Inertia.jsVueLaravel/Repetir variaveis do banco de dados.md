# Repetir variaveis do banco de dados

No larave

```php
use App\Models\settingsNewMenu as MenuBd;

public function settings(){
    return Inertia::render('Pages/settings/MenuSettings', [
            'breadcrumb' => 'Configurações',
            'MenuBd' => MenuBd::all(), // banco de dados
        ]);
    }
```

No vue

```html
<div v-if="MenuBd.length > 0">

    <div v-for="(menu, index) in MenuBd" :key="index" class="col-md-12 mb-md-0 mb-3">
      <div class="card card-body">

       <Link :href="route('newSubMenu', { id: menu.id })">
       <h6 class="btn mb-0"><i class="material-icons">{{ menu.icon }}</i> {{ menu.menubase }}</h6>
       </Link> 

      </div>
    </div>
  </div>

  <div class="text-danger btn" v-else>Nenhum Menu Cadastrado</div>

```