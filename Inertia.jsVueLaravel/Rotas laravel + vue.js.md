# Como enviar uma variavel pela url

No web.php

```php
    Route::get('/settings/sub-menu/{id}', [settingscontroller::class, 'newSubMenu'])->name('newSubMenu');
```

No vue

```html
<Link :href="route('newSubMenu', { id: menu.id })">Nome link aqui<Link>
```


Outras Rotas no Laravel

```php
// grupos com middleware
Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index.home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::post('/settings/new-menu', [settingscontroller::class, 'newMenuPost'])->name('new_menu');

    Route::get('/settings/sub-menu/{id}', [settingscontroller::class, 'newSubMenu'])->name('newSubMenu');
});

Route::middleware('auth')->group(function () { 
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

´´´