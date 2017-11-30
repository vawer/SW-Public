<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
}else{
    if (!(strcmp($_SESSION['type'], "Profesor")==0)) {
        header("Location: error.php");
    }
}
if (isset($_GET['id'])) {
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    } else {
        $Query = "SELECT * FROM preguntas WHERE ID=" . $_GET['id'];
        $res = mysqli_query($mysqli, $Query);
        while ($row = mysqli_fetch_array($res)) {
            echo "<table>
                    <form name='preg' id='preg'>
                        <tr>
                            <td>Autor: </td>
                            <td><input type='text' readonly='readonly' value='" . $row['eMail'] . "' style='background-color: #e4e4e4;'/></td>
                        </tr>
                        <tr>
                            <td>Enunciado: </td>
                            <td><input id='enunciado' type='text' value='" . $row['Enunciado'] . "'/></td>
                        </tr>
                        <tr>
                            <td>Respuesta correcta: </td>
                            <td><input id='correcta' type='text' value='" . $row['Correcta'] . "'/></td>
                        </tr>
                        <tr>
                            <td>Respuesta incorrecta: </td>
                            <td><input id='incorrecta1' type='text' value='" . $row['Incorrecta1'] . "'/></td>
                        </tr>
                        <tr>
                            <td>Respuesta incorrecta: </td>
                            <td><input id='incorrecta2' type='text' value='" . $row['Incorrecta2'] . "'/></td>
                        </tr>
                        <tr>
                            <td>Respuesta incorrecta: </td>
                            <td><input id='incorrecta3' type='text' value='" . $row['Incorrecta3'] . "'/></td>
                        </tr>
                        <tr>
                            <td>Complejidad: </td>
                            <td><input id='complejidad' type='text' value='" . $row['Complejidad'] . "'/></td>
                        </tr>
                        <tr>
                            <td>Tema: </td>
                            <td><input id='tema' type='text' value='" . $row['Tema'] . "'/></td>
                        </tr>
                        <tr>
                            <td colspan='2'><input type='button' onclick='modificar()' value='Modificar pregunta' style='width: 150px;'/></td>
                        </tr>
                    </form>
                </table>";
        }
        mysqli_close($mysqli);
    }
}
?>