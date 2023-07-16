<!--
  Não esqueça de inserir essas duas CDN para alerta de notificação de erros
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css
" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js"></script>
-->
<template>
    <div class="main">       
            <div class="container">
            <div style="text-align: center;">
                <div class="middle">
                    <div id="login">

                        <fieldset class="clearfix">                    
                            <form @submit.prevent="cadastarUser">
                            <p>
                                <span class="lock-icon"><i class="fa fa-user"></i></span>
                                <input type="text"  Placeholder="Usuário" id="name" v-model="user.name" required>
                            </p> <!-- JS because of IE support; better: placeholder="Username" -->
                            <p>
                                <span class="lock-icon"><i class="fa fa-user"></i></span>
                                <input type="text"  Placeholder="Email" id="email" v-model="user.email" required>
                            </p> <!-- JS because of IE support; better: placeholder="Username" -->

                            <p>
                                <span class="lock-icon"><i class="fa fa-lock"></i></span>
                                <input type="password"  Placeholder="Senha" id="password"  v-model="user.password" required>
                            </p> <!-- JS because of IE support; better: placeholder="Password" -->
                            <p>
                                <span class="lock-icon"><i class="fa fa-lock"></i></span>
                                <input type="password"  Placeholder="Repetir Senha">
                            </p> <!-- JS because of IE support; better: placeholder="Password" -->
 >
                            <div>
                                <span style="width:48%; text-align:left;  display: inline-block;">
                                    <a class="small-text" href="/login">Login</a>
                                </span>
                                <span style="width:50%; text-align:right;  display: inline-block;">
                                    <input type="submit" value="Cadastrar">
                                </span>
                                <br>
                            </div>
                          </form>

    
                        </fieldset>
                    
    
                    </div> <!-- end login -->
                    <div class="logo">
                        Logo                    
                        
                    </div>
                    
                    
                    </div>
                </div>
            </div>
        </div>
    
    </template>
<script setup>
import http from '../../config/http.js';
import { reactive } from 'vue';
import { useRouter } from 'vue-router'; 

const user = reactive({
  name: '',
  email: '',
  password: ''
});

const router = useRouter(); 

async function cadastarUser(){
  try {
    const {data} = await http.post('/registerUser', user);
    Swal.mixin({
        toast: true,
      }).fire({
      icon: (data.error == true) ? "error" : "success",
      title: data.message,
      customClass: {
        confirmButton: 'btn_Custom'
      }
    }).then((result) => {
      if (result.isConfirmed && data.success == true) { 
        router.push({ name: 'login' });
      }
    });
  } catch (error) {
    console.log(error?.response?.data);
  }
}
</script>

    
    <style scoped>
    .conlCenter{
        text-align: center;
    }
    
    .lock-icon {
        background-color: #fff;
        border-radius: 3px 0px 0px 3px;
        color: #000;
        display: block;
        float: left;
        height: 50px;
        font-size:24px;
        line-height: 50px;
        text-align: center;
        width: 50px;
    }

    
    
    div.main {
      background: #0264d6; /* Old browsers */
      background: --moz-radial-gradient(center, ellipse cover,  #0264d6 1%, #1c2b5a 100%); /* FF3.6+ */
      background: --webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(1%,#0264d6), color-stop(100%,#1c2b5a)); /* Chrome,Safari4+ */
      background: -webkit-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* Chrome10+,Safari5.1+ */
      background: -o-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* Opera 12+ */
      background: -ms-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* IE10+ */
      background: radial-gradient(ellipse at center,  #0264d6 1%,#1c2b5a 100%); /* W3C */
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0264d6', endColorstr='#1c2b5a',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
      height: calc(100vh);
      width: 100%;
    }
    
    [class*="fontawesome-"]:before {
      font-family: 'FontAwesome', sans-serif;
    }
    
    * {
      box-sizing: border-box;
      margin: 0px auto;
    }
    
    body {
      color: #606468;
      font: 87.5%/1.5em 'Open Sans', sans-serif;
      margin: 0;
    }
    
    a {
      color: #eee;
      text-decoration: none;
    }
    
    a:hover {
      text-decoration: underline;
      color: #fff;
    }
    
    input {
      border: none;
      font-family: 'Open Sans', Arial, sans-serif;
      font-size: 14px;
      line-height: 1.5em;
      padding: 0;
      --webkit-appearance: none;
    }
    
    
    p {
      line-height: 1.5em;
    }
    
    .clearfix {
      zoom: 1;
    }
    
    .clearfix:before,
    .clearfix:after {
      content: ' ';
      display: table;
    }
    
    .clearfix:after {
      clear: both;
    }
    .container {
      left: 50%;
      position: fixed;
      top: 50%;
      transform: translate(-50%, -50%);
    }
    
    #login form {
      width: 250px;
    }
    
    #login, .logo {
      display: inline-block;
      width: 40%;
    }
    
    
    #login {
      border-right: 1px solid #fff;
      padding: 0px 22px;
      width: 59%;
    }
    
    .logo {
      color: #fff;
      font-size: 50px;
      line-height: 125px;
    }
    
    
    #login form input {
      height: 50px;
    }
    
    fieldset {
      padding: 0;
      border: 0;
      margin: 0;
    }
    
    #login form input[type="text"],input[type="email"],
    input[type="password"] {
      background-color: #fff;
      border-radius: 0px 3px 3px 0px;
      color: #000;
      margin-bottom: 1em;
      padding: 0 16px;
      width: 200px;
    }
    
    #login form input[type="submit"] {
      border-radius: 3px;
      -moz-border-radius: 3px;
      -webkit-border-radius: 3px;
      background-color: #000000;
      color: #eee;
      font-weight: bold;
      text-transform: uppercase;
      padding: 5px 10px;
      height: 30px;
    }
    
    #login form input[type="submit"]:hover {
      background-color: #9c6010;
    }
    
    #login > p {
      text-align: center;
    }
    
    #login > p span {
      padding-left: 5px;
    }
    
    .middle {
      display: flex;
      width: 600px;
    }
    </style>
    