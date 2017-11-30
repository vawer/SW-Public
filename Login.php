<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='estilos/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='estilos/smartphone.css' />
  </head>
  <body>
  <?php
  if(isset($_SESSION['user'])){
      header("Location: error.php");
  }
  ?>
  <div id='page-wrap'>
	<header class='main' id='h1'>
        <span class='right'><a href='Registro.php'>Registrarse </a></span><span class='right'><a href='Login.php'>Login</a></span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
        <span><a href='layout.php'>Inicio</a></span>
        <span><a href='creditos.php'>Creditos</a></span>
	</nav>
    <section class="main" id="s1">
	<div>
        <table border=4 width=100%><td><br> 
            <form id="registrar" name="registrar" action="Login.php" method="POST" enctype="multipart/form-data">
                Introduce los datos:<br/>
                Email*: <input type="text" name="email" size=50><br/>
                Password*: <input type="password" name="password" size=20><br/>
                <input type="submit" value="Iniciar sesión"><br>
            </form>
                <p>¿No te acuerdas de tu contraseña? <a href="RecuperarContrasena.php">¡Recupérala!</a></p>
            <?php
                if(isset($_POST["email"])){
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
                    if(!$mysqli){
                        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                    }
                    $password = hash('sha256',$password);
                    $Query = "SELECT password FROM user WHERE email='$email'";
                    $res = mysqli_query($mysqli, $Query);
                    $done = 0;
                    while($row = mysqli_fetch_array($res)){
                        if($row['password']==$password){
                            $_SESSION['user'] = $email;
                            if(strcmp($email, "web000@ehu.es") == 0){
                                $_SESSION['type'] = 'Profesor';
                            }else{
                                $_SESSION['type'] = 'Alumno';
                            }
                            echo "<script type='text/javascript'>
                            xmlhttp = new XMLHttpRequest();
                            xmlhttp.open(\"GET\",\"ajax/UserNum.php?fun=enter&q=\"+new Date().getTime(),true);
                            xmlhttp.send();
                            alert('Bienvenido!');</script>";
                            echo "<script language=\"javascript\">window.location=\"index.php\"</script>";
                            exit();
                            $done = 1;
                        }
                    }
                    if($done==0){
                        echo "<script type='text/javascript'>alert('Datos incorrectos');</script>";
                    }
                    mysqli_close($mysqli);
                }
            ?>
        </td></table>
	</div>
    </section>
	<footer class='main' id='f1'>
        <?php
        include 'content.php';
        createFooter();
        ?>
	</footer>
</div>
</body>
</html>

