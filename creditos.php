<?php
session_start();
?>
<!DOCTYPE html>
<html>
<style>
    table {
        text-align: left;
        margin: 0 auto;
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
	<nav class='main' id='n1' role='navigation'>
        <?php
            createMenu();
        ?>
		
	</nav>
    <section class="main" id="s1" style="height: 100%">
    
	<div>
	<h3>Aplicación desarrolada por Vesko y Julen<br/>
		para Sistemas Web</h3><br/>
		Estudiantes de Ingeniería Informática (Ingeniería del Software)
	</div>
    <img src="images/SW.png" width="150px"/><br/>
        <div>
            <table>
                <tr>
                    <th colspan="2">Información obtenida de la dirección IP</th>
                </tr><tr>
                    <td>País:</td>
                    <td id="pais"></td>
                </tr><tr>
                    <td>Región:</td>
                    <td id="region"></td>
                </tr><tr>
                    <td>Ciudad:</td>
                    <td id="ciudad"></td>
                </tr><tr>
                    <td>IP pública:</td>
                    <td id="ip"></td>
                </tr>
            </table>
        <?php
        ini_set('max_execution_time', 300);
        $request = 'http://api.population.io/1.0/population/Spain/today-and-tomorrow/';
        $response  = file_get_contents($request);
        $jsonobj  = json_decode($response);
        echo "<br/>Populación en España:<br/>";
        echo $jsonobj->{'total_population'}[0]->{'population'};
        ?>
        </div>
        Ubicación en el mapa:<br/>
        <div id="mapa" style="height: 200px; width: 95%;"></div>
        <a href='index.php'>Volver a la pagina principal</a>
	
    </section>
	<footer class='main' id='f1'>
        <?php
        createFooter();
        ?>
	</footer>
</div>
</body>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4FGd_P0t-3h9OARurBQywZIf7QbE28GM">
</script>
<script>
    var requestURL = "http://ip-api.com/json";
    var request = new XMLHttpRequest();
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function() {
        var info = request.response;
        document.getElementById('pais').innerHTML = info['country'] + " (" + info['countryCode'] + ")";
        document.getElementById('region').innerHTML = info['regionName'] + " (" + info['region'] + ")";
        document.getElementById('ciudad').innerHTML = info['city'];
        document.getElementById('ip').innerHTML = info['query'];
        var lat = info['lat'];
        var lng = info['lon'];
        var latlng = new google.maps.LatLng(lat, lng);
        var myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        };
        var map = new google.maps.Map(document.getElementById("mapa"), myOptions);
        var marker = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
        });
    }
</script>
</html>
