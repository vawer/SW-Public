<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
}else{
    if (!(strcmp($_SESSION['type'], "Profesor")==0)) {
        header("Location: error.php");
    }
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
<style>
    div>table{
        text-align: left;
        margin: 0 auto;
    }
    input{
        width: 400px;
    }
</style>
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
    <section class="main" id="s1" style="height: 100%;">
        <?php
        $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
        if (!$mysqli) {
            echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        } else {
            $Query = "SELECT ID, Enunciado FROM preguntas";
            $res = mysqli_query($mysqli, $Query);
            echo "Elige la pregunta a revisar: <select id='preguntas' name='preguntas' onchange='cambiar()'>";
            while ($row = mysqli_fetch_array($res)) {
                echo "<option value='" . $row['ID'] . "'>Pregunta " . $row['ID'] . "</option>";
            }
            echo "</select>";
            mysqli_close($mysqli);
        }
        ?>
        <div id="formulario"></div>
        <div id="actualizar"></div>
    </section>
    <footer class='main' id='f1'>
        <?php
        createFooter();
        ?>
    </footer>
</div>
</body>
<script src="jquery.js"></script>
<script>
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        switch(xhr.readyState) {
            case 1:
                document.getElementById('formulario').innerHTML = "<img src='images/loading.gif' height='200px'/>";
                break;
            case 4:
                document.getElementById('formulario').innerHTML = xhr.responseText;
                break;
        }
    }
    cambiar();
    function cambiar(){
        var id = document.getElementById('preguntas').value;
        xhr.open('GET', 'ajax/PreguntaEditar.php?id=' + id, true);
        xhr.send();
    }

    xhr2 = new XMLHttpRequest();
    xhr2.onreadystatechange = function(){
        if(xhr2.readyState==4){
            cambiar();
            document.getElementById('actualizar').innerHTML = xhr2.responseText;
        }
    }

    function modificar(){
        var url = "?id=" + $('#preguntas').val()
            + "&enunciado=" + $('#enunciado').val()
            + "&correcta=" + $('#correcta').val()
            + "&incorrecta1=" + $('#incorrecta1').val()
            + "&incorrecta2=" + $('#incorrecta2').val()
            + "&incorrecta3=" + $('#incorrecta3').val()
            + "&complejidad=" + $('#complejidad').val()
            + "&tema=" + $('#tema').val();
        xhr2.open('GET', 'ajax/ActualizarPregunta.php'+url, true);
        xhr2.send();
    }
</script>
</html>
