<template>
    <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar as -->
  <div class="container px-5">
                <Link href="/" class="navbar-brand text-dark">Name Website</Link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto me-lg-5">
                        <li class="nav-item">
                            <Link href="/" class="nav-a">
                                Inicio
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link href="/pagina01" class="nav-a">
                                Página 01  
                            </Link>
                        </li>
    
                        <li class="nav-item ">
                            <Link href="/menu1" class="nav-a">
                                Menu 1  
                            </Link>
                        </li>
                        <li class="nav-item ">
                            <Link href="/login" class="nav-a">
                                login  
                            </Link>
                        </li>
                        
                    </ul>
                
                </div>
            </div>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <template>
            Olá visitante
        </template>
      </li> 
      
      <li class="nav-item">
        <Link href="/" class="nav-a"  data-widget="control-sidebar" data-slide="true" role="button">
            <i class="fa-solid fa-right-from-bracket"></i>
        </Link>
      </li>
    </ul>


</nav>
<!-- /.navbar -->
</template>

<script setup>

</script>