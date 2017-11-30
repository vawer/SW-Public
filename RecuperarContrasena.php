<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: error.php");
}
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
            <?php
            if (isset($_GET['id'])) {
                echo '<form>Introduce la contraseña dos veces para reestablecerla:</br></br>
                            <input type="text" id="cod" hidden="hidden" value="'.$_GET['id'].'"/>
                            <input type="password" id="pass1" size="50"/></br>
                            <input type="password" id="pass2" size="50"/></br></br>
                            <input type="button" value="Confirmar" onclick="cambiar()"/>
                        </form>';
            } else {
                echo '<form>Introduce email para cambiar la contraseña:</br></br>
                        <input type="text" id="email" size="50"/></br></br>
                        <input type="button" value="Enviar" onclick="enviarMail()"/></form>';
            }
            ?>
            </br>
            <div id="respuesta"></div>
        </div>
    </section>
    <footer class='main' id='f1'>
        <?php
        createFooter();
        ?>
    </footer>
</div>
</body>

<script>
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        switch (xhr.readyState) {
            case 1:
                document.getElementById('respuesta').innerHTML = "<img src='images/loading.gif' height='200px'/>";
                break;
            case 4:
                document.getElementById('respuesta').innerHTML = xhr.responseText;
                break;
        }
    }

    function enviarMail() {
        var email = document.getElementById('email').value;
        console.log(email);
        xhr.open('GET', 'ajax/CambiarContrasena.php?email=' + email, true);
        xhr.send();
    }

    function cambiar(){
        var pass1 = document.getElementById('pass1').value;
        var pass2 = document.getElementById('pass2').value;
        var id = document.getElementById('cod').value;
        if(pass1 == pass2){
            xhr.open('GET', 'ajax/CambiarContrasena.php?id='+id+'&password='+pass1, true);
            xhr.send();
        }else{
            document.getElementById('respuesta').innerHTML = "Las contraseñas no coinciden.";
        }

    }
</script>
</html>
