<?php
session_start();
?>
<!DOCTYPE html>
<html>
<style>
    td {
        border: none;
        text-align: left;
    }
</style>
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
<?php
if (isset($_SESSION['user'])) {
    header("Location: error.php");
}
?>
<div id='page-wrap'>
    <header class='main' id='h1'>
        <span class='right'><a href='Registro.php'>Registrarse</a></span> <span class='right'><a
                    href='Login.php'>Login</a></span>
        <h2>Quiz: el juego de las preguntas</h2>
    </header>
    <nav class='main' id='n1' role='navigation'>
        <span><a href='layout.php'>Inicio</a></span>
        <span><a href='creditos.php'>Creditos</a></span>
    </nav>
    <section class="main" id="s1">
        <div>
            <table border=4 width=100%><br>
                <form id="registrar" name="registrar" action="Registro.php" method="POST" enctype="multipart/form-data">
                    <tr>
                        <td colspan='3' style='text-align: center;'>Introduce los datos:
                            <hr/>
                        </td>
                    </tr>
                    <tr>
                        <td>Email*:</td>
                        <td><input type="text" id="email" name="email" size=50 onblur="comprobarEmail()"></td>
                        <td><p id='resultado'></p></td>
                    </tr>
                    <tr>
                        <td>Nombre y apellidos*:</td>
                        <td><input type="text" name="nomape" size=80></td>
                    </tr>
                    <tr>
                        <td>Nick*:</td>
                        <td><input type="text" name="nick" size=40></td>
                    </tr>
                    <tr>
                        <td>Password*:</td>
                        <td><input type="password" id="password" name="password" size=20 onblur="comprobarPassword()">
                        </td>
                        <td><p id='resultado2'></p></td>
                    </tr>
                    <tr>
                        <td>Repetir password*:</td>
                        <td><input type="password" name="password2" size=20></td>
                    </tr>
                    <tr>
                        <td>Foto:</td>
                        <td><input type="file" name="foto"></td>
                    </tr>
                    <tr>
                        <td colspan='3' style='text-align: center;'><input type="submit" id="boton" value="Registrarse"
                                                                           disabled></td>
                    </tr>
                </form>
            </table>
            <?php
            if (isset($_POST["email"])) {
                $email = $_POST["email"];
                $nomape = $_POST["nomape"];
                $nick = $_POST["nick"];
                $password = $_POST["password"];
                $password2 = $_POST["password2"];
                $pattern = '/^([a-z]+[0-9]{3})+\@((ikasle)+\.)+((ehu)+\.)+((es)|(eus))+$/';
                require_once('nusoap-master/src/nusoap.php');

                $soapclient = new nusoap_client('http://swg12.000webhostapp.com/Seguridad/servicios/ComprobarPassword.php?wsdl', true);
                $pass = $soapclient->call('comprobarPassword', array('pass' => $password));
                if (strstr($pass, 'INVALIDA')) {
                    die("Contraseña no válida...");
                }
                $soapclient2 = new nusoap_client('http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl', true);
                $mail = $soapclient->call('comprobar', array('x' => $email));
                if (strstr($mail, 'NO')) {
                    die("Correo inválido...");
                }
                if (preg_match($pattern, $email) == 0) {
                    die('Email incorrecto');
                }
                if (!preg_match('/\s/', $nomape) & strlen($nomape) < 3) {
                    die('Nombre y apellidos incorrectos');
                }
                if (preg_match('/\s/', $nick) | strlen($nick) < 1) {
                    die('Nick incorrecto');
                }
                if (strlen($password) < 6) {
                    die("Longitud insuficiente de la contraseña");
                }
                if ($password != $password2) {
                    die("Las contraseñas no coinciden");
                }

                $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
                if (!$mysqli) {
                    echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                }
                if (!file_exists($_FILES['foto']['tmp_name']) || !is_uploaded_file($_FILES['foto']['tmp_name'])) {
                    $image = '';
                } else {
                    $image = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
                }
                $password = hash('sha256', $password);
                $Query = "INSERT INTO user(email,nombreape,nick,password,foto)
                    VALUES ('$email','$nomape','$nick','$password','{$image}')";
                if (mysqli_query($mysqli, $Query)) {
                    session_start();
                    $_SESSION['user'] = $email;
                    $_SESSION['type'] = 'Alumno';
                    $numero = simplexml_load_file('xml/numusuarios.xml');
                    if ($numero == false) {
                        echo "Error abriendo el archivo xml.";
                    } else {
                        $numero[0] = $numero + 1;
                        $numero->asXML('xml/numusuarios.xml');
                    }
                    echo "<script> alert('Usuario creado correctamente, bienvenido!'); 
                        location.replace(\"\");</script>";
                } else {
                    echo "ERROR: No se pudo registrar el usuario. " . mysqli_error($mysqli);
                }
                mysqli_close($mysqli);
            }
            ?>

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
<script src='jquery.js'>
</script>
<script>
    var valemail = false;
    var valpass = false;

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        switch (xmlhttp.readyState) { //Según el estado de la petición devolvemos un Texto
            case 0:
                document.getElementById('resultado').innerHTML =
                    "Sin iniciar...";
                valemail = false;
                actualizarBoton();
                break;
            case 1:
                document.getElementById('resultado').innerHTML =
                    "<b>Cargando...</b>";
                break;
            case 2:
                document.getElementById('resultado').innerHTML =
                    "<b>Cargado...</b>";
                break;
            case 3:
                document.getElementById('resultado').innerHTML =
                    "Interactivo...";
                break;
            case 4:
                document.getElementById('resultado').innerHTML =
                    response = xmlhttp.responseText;
                if (response.trim() == 'SI') {
                    $('#resultado').text('Email válido');
                    valemail = true;
                } else {
                    $('#resultado').text('Email inválido');
                    valemail = false;
                }
                actualizarBoton();
                break;
        }
    }

    function comprobarEmail() {
        if ($('#email').val().length != 0) {
            xmlhttp.open("GET", "ajax/UsuariosVIP.php?email=" + $('#email').val(), true);
            xmlhttp.send();
        }
    }

    xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function () {
        switch (xmlhttp2.readyState) { //Según el estado de la petición devolvemos un Texto
            case 0:
                document.getElementById('resultado2').innerHTML =
                    "Sin iniciar...";
                valpass = false;
                actualizarBoton();
                break;
            case 1:
                document.getElementById('resultado2').innerHTML =
                    "<b>Cargando...</b>";
                break;
            case 2:
                document.getElementById('resultado2').innerHTML =
                    "<b>Cargado...</b>";
                break;
            case 3:
                document.getElementById('resultado2').innerHTML =
                    "Interactivo...";
                break;
            case 4:
                document.getElementById('resultado2').innerHTML =
                    response = xmlhttp2.responseText;
                if (response.trim() == 'VALIDA') {
                    $('#resultado2').text('Contraseña válida');
                    valpass = true;
                } else {
                    $('#resultado2').text('Contraseña inválida');
                    valpass = false;
                }
                actualizarBoton();
                break;
        }
    }

    function comprobarPassword() {
        if ($('#password').val().length != 0) {
            xmlhttp2.open("GET", "ajax/ComprobarPassword.php?password=" + $('#password').val(), true);
            xmlhttp2.send();
        }
    }

    function actualizarBoton() {
        if (valemail && valpass) {
            $('#boton').removeAttr('disabled');
        } else {
            $('#boton').attr('disabled', 'disabled');
        }
    }
</script>
</html>

