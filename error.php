<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css'/>
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='estilos/wide.css'/>
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='estilos/smartphone.css'/>
</head>
<body>
<div id='page-wrap'>
    <header class='main' id='h1'>
        <?php
        include 'content.php';
        createHeader();
        ?>
        <h2>Quiz: el juego de las preguntas</h2>
    </header>
    <nav class='main' id='n1' role='navigation'>
        <?php
        createMenu();
        ?>
    </nav>
    <section class="main" id="s1">
        <div>
            ACCESO A ESTE APARTADO NO AUTORIZADO EN ESTE MOMENTO.
            <?php
            if(isset($_SESSION['user'])){
                echo "</br>No puedes acceder a este apartado porque estás logeado como " . $_SESSION['type'];
            }else{
                echo "</br>No puedes acceder porque no has iniciado sesión.";
                echo "</br><a href='Login.php'>Iniciar sesión</a></br><a href='Registro.php'>Registrarse</a>";
            }
            ?>
        </div>
    </section>
    <footer class='main' id='f1'>
        <?php
        createFooter();
        ?>
    </footer>
</div>
</body>
</html>
