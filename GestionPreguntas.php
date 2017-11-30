<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
}else{
    if (!(strcmp($_SESSION['type'], "Alumno")==0)) {
        header("Location: error.php");
    }
}
?>
<!DOCTYPE html>
<html>
  <style>
    div.aviso {
        border-style: groove;
      }
    td.form {
        border: none;
        text-align: left;
    }
  </style>
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
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<?php
			include 'content.php';
			createHeader();
		?>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation' style="height: 100%;">
        <?php
        createMenu();
        ?>
	</nav>
    <section class="main" id="s1" style="height: 100%;">
    <div class='aviso'>
        <p id='npreguntas'></p>
    </div>
    <div class='aviso'>
        <p>Número de usuarios conectados: </p><p id='usuarios'></p>
    </div>
    <div>
    <table border=4 width=100%>
        <form id="fpreguntas" name="fpreguntas">
            <tr><td class='form'>Email*:</td><td class='form'><input type="text" name="Email" id="email" size="32" readonly="readonly" value='<?php echo $_SESSION['user']; ?>'></td></tr>
            <tr><td class='form'>Enunciado de la pregunta*:</td><td class='form'><input type="text" name="Pregunta" id="pregunta" size="80"></td></tr>
            <tr><td class='form'>Respuesta correcta*:</td><td class='form'><input type="text" name="Correcta" id="correcta" size="80"></td></tr>
            <tr><td class='form'>Respuesta incorrecta*:</td><td class='form'><input type="text" name="Incorrecta1" id="incorrecta1" size="80"></td></tr>
            <tr><td class='form'>Respuesta incorrecta*:</td><td class='form'><input type="text" name="Incorrecta2" id="incorrecta2" size="80"></td></tr>
            <tr><td class='form'>Respuesta incorrecta*:</td><td class='form'><input type="text" name="Incorrecta3" id="incorrecta3" size="80"></td></tr>
            <tr><td class='form'>Complejidad (1..5)*:</td><td class='form'><input type="text" name="Complejidad" id="complejidad" size="32"></td></tr>
            <tr><td class='form'>Tema (subject):</td><td class='form'><input type="text" name="Subject" id="subject" size="32"></td></tr>
            <tr><td colspan='2' style='text-align: center;' class='form'><input type="button" value="Enviar quiz" onclick='enviar()'></td></tr>
        </form>
    </table>
	</div>
    <button type="button" onclick='verPreguntas()'>Ver preguntas</button> 
    <div id='response'>
    </div>
    <div id='preguntas'>
    </div>
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
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
     {
     if (xmlhttp.readyState==4 && xmlhttp.status==200)
     {document.getElementById("response").innerHTML=xmlhttp.responseText; }
     }
    function enviar(form){
        var email = document.getElementById("email").value;
        var pregunta = document.getElementById("pregunta").value;
        var correcta = document.getElementById("correcta").value;
        var incorrecta1 = document.getElementById("incorrecta1").value;
        var incorrecta2 = document.getElementById("incorrecta2").value;
        var incorrecta3 = document.getElementById("incorrecta3").value;
        var complejidad = document.getElementById("complejidad").value;
        var subject = document.getElementById("subject").value;
        var url = 'email=' + email +
            '&pregunta=' + pregunta +
            '&correcta=' + correcta +
            '&incorrecta1=' + incorrecta1 +
            '&incorrecta2=' + incorrecta2 +
            '&incorrecta3=' + incorrecta3 +
            '&complejidad=' + complejidad +
            '&subject=' + subject;
        xmlhttp.open("GET","ajax/InsertarPreguntaAJAX.php?"+url,true);
        xmlhttp.send();
        $('#fpreguntas')[0].reset();
    }

    xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange=function()
     {
     if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
     {document.getElementById("preguntas").innerHTML=xmlhttp2.responseText; }
     }
    function verPreguntas(){
        xmlhttp2.open("GET","ajax/VerPreguntasAJAX.php",true);
        xmlhttp2.send();
    }

    

    function contadorPreguntas(){
        var total = 0;
        var propias = 0;
        var email = $('#email').val();
        $.ajax({
            type: "GET",
            url: "xml/preguntas.xml",
            cache: false,
            dataType: "xml",
            success: function(xml) {
                $(xml).find('assessmentItem').each(function() {
                    var author = $(this).attr('author');
                    total++;
                    if(email === author){
                        propias++;
                    }
                })
                $('#npreguntas').text('Mis preguntas/Todas las preguntas: ' + propias + '/' + total);
            }
        });
    }
    contadorPreguntas();
    setInterval(contadorPreguntas, 20000);

    xmlhttp3 = new XMLHttpRequest();
    xmlhttp3.onreadystatechange=function()
     {
     if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
     {document.getElementById("usuarios").innerHTML=xmlhttp3.responseText; }
     }

    function consultarUsuarios(){
        xmlhttp3.open("GET","ajax/UserNum.php?fun=consulta&q="+new Date().getTime(),true);
        xmlhttp3.send();
    }
    consultarUsuarios();
    setInterval(consultarUsuarios, 10000);
    
</script>
</html>
