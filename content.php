<?php
function createHeader()
{
    if (isset($_SESSION['user'])) {
        $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
        if (!$mysqli) {
            echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        } else {
            $useremail = $_SESSION['user'];
            $Query = "SELECT * FROM user WHERE email='$useremail'";
            $res = mysqli_query($mysqli, $Query);
            while ($row = mysqli_fetch_array($res)) {
                echo $_SESSION['type'] . ", ";
                echo $row['nick'] . ' ';
                if ($row['foto'] != null) {
                    echo "<img src=\"data:image/jpeg;base64," . base64_encode($row['foto']) . "\" width=40px> ";
                }
            }
            mysqli_close($mysqli);
            echo "<span class='right'><a href='#' onClick='xmlhttp3 = new XMLHttpRequest();
                xmlhttp3.open(\"GET\",\"ajax/UserNum.php?fun=logout&q=\"+new Date().getTime(),true);
                xmlhttp3.send();
                alert(\"Hasta otra!\");
                location.replace(\"logout.php\");'>Logout</a></span>";
        }
    } else {
        echo "<span class='right'><a href='Registro.php'>Registrarse</a></span> <span class='right'><a href='Login.php'>Login</a></span>";
    }
}

function createMenu()
{
    if(isset($_SESSION['user'])){
        $useremail = $_SESSION['user'];
        if(strcmp($_SESSION['type'],'Alumno')==0) {
            echo "<span><a href='index.php'>Inicio</a></span>
                <span><a href='GestionPreguntas.php'>Gestionar preguntas</a></span>
                <span><a href='creditos.php'>Creditos</a></span>";
        }else{
            echo "<span><a href='index.php'>Inicio</a></span>
                <span><a href='RevisarPreguntas.php'>Revisar preguntas</a></span>		
                <span><a href='creditos.php'>Creditos</a></span>";
        }
    }else{
        echo "<span><a href='index.php'>Inicio</a></span>
                <span><a href='Jugar.php'>Jugar</a></span>
                <span><a href='creditos.php'>Creditos</a></span>";
    }
}

function createFooter()
{
    echo '<p><a href="https://en.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
        <a href="https://github.com/vawer/SW-Public">Link GITHUB</a>';
}
?>