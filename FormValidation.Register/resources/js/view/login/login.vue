<template>
<div class="main">       
        <div class="container">
        <center>
            <div class="middle">
                <div id="login">
                    <form action="javascript:void(0);" method="get">
                    <fieldset class="clearfix">
                        <p>
                            <span class="lock-icon"><i class="fa fa-user"></i></span>
                            <input type="text"  Placeholder="Usuário" required>
                        </p> <!-- JS because of IE support; better: placeholder="Username" -->

                        <p>
                            <span class="lock-icon"><i class="fa fa-lock"></i></span>
                            <input type="password"  Placeholder="Senha" required>
                        </p> <!-- JS because of IE support; better: placeholder="Password" -->
                        
                        <div>
                            <span style="width:48%; text-align:left;  display: inline-block;">
                                <a class="small-text" href="#">Recuperar Senha?</a> <br>
                                <a class="small-text" href="/register">Cadastrar</a>
                            </span>
                            <span style="width:50%; text-align:right;  display: inline-block;">
                                <input type="submit" value="Login">
                            </span>
                            <br>
                        </div>

                    </fieldset>
                    </form>

                </div> <!-- end login -->
                <div class="logo">
                    somente view                    
                    
                </div>
                
                
                </div>
            </center>
        </div>
    </div>

</template>

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

#login form input[type="text"],
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
