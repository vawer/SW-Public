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
            <img src="images/quiz.png" height="150px">
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
