<!doctype html>
<?php
require('secPdLic.php');
include('cnxh.php');
require('fxPreguntas.php');
$funciones=new fxpreguntas();
$conexion=new conexion();
$conexion->conectar();
$nombreBD='pdlic2015';
$tituloEx='Quizz 1';
$nPreguntas=26;
$nQuizz=1;
$Cuenta=$_SESSION["Cuenta"];
//$paginaSig='contPd.php';
//$mismaPag='pEC.html';
//$longitudUsr=9;
//$longitudClv=6;
?>
<html lang="es">
	<head>
		<link href="Favicon.ico" type="image/x-icon" rel="shortcut icon" />
		<title>Coordinación General de Lenguas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"'>	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><!-- jQuery library -->
		<link rel="stylesheet" href="hugix.css" type="text/css" media="screen" /><!-- Mi hoja de estilos-->
		<link rel="stylesheet" href="css/hugixBS.css" type="text/css" media="screen" /><!-- Mi 2a hoja de estilos-->
		
		<script>
			function habilita(){
				for(var i=1;i<=26;i++){
					document.getElementById('sel'+i).disabled=false;
				}
			}
		
			function dirCGL()
			{
				var direccion="http://www.cgl.unam.mx";
				location.href=direccion;
			}
			
			function dirUNAM()
			{
				var direccion="http://www.unam.mx";
				location.href=direccion;
			}
			
			function Califica(){
				var suma=[];
				for(var i=1;i<=10;i++){
					document.getElementById('sel'+i).disabled=true;
					var valor=document.getElementById('sel'+i).value;
					if(valor=='xh'){
						valor=1;						
					}
					else{
						valor=0;
					}
					//valor=parseInt(valor);
					//alert("El tipo de valor es "+typeof(valor));
					//alert("El valor suma["+i+"] es de "+valor);
					suma[i]=parseInt(valor);					
				}
				var calificacion=null;
				for(var h=1;h<suma.length;h++){
					calificacion+=suma[h];
				}				
				alert("Tu calificación en la primera parte es de "+[(calificacion/10)*10]);
				//alert("Los valores obtenidos son: "+suma);
				
				var sumaT=[];
				var rTextos=["is","are","are","is","is","are","are","are","is","is","is","am","is","is","are","am"];
				for(var j=11;j<=26;j++){
					//alert ("Valor cadena "+(j-11)+" es : "+rTextos[j-11]);
					document.getElementById('sel'+j).disabled=true;
					var valorT=document.getElementById('sel'+j).value;
					if(valorT==rTextos[j-11]){
						//alert("El valor de la respuesta es "+valorT+" y el del arreglo es: "+rTextos[j-11]);
						valor=1;
					}
					else{
						valor=0;
					}
					sumaT[j-11]=parseInt(valor);
				}
				var calificacionT=null;
				for(var h=1;h<sumaT.length;h++){
					calificacionT+=sumaT[h];
				}				
				alert("Tu calificación en la segunda parte es de "+[(calificacionT/16)*10]);
				//alert("Los valores obtenidos son: "+sumaT);
				var c_Total=calificacion+calificacionT;
				alert("Tu calificación total es: "+c_Total+ " sobre 26, o bien, "+[(c_Total/26)*10]);
				document.getElementById('Calificacion').value=c_Total;
				//alert("Ya se mandó la calificación, la cual debe ser: "+c_Total);				
				$("#quizz").submit();
			}
			
				$(document).ready(function(){
				$("#vRespuesta").click(function (){
					var nulo=0;
				var faltantes=[];
				for(var i=1;i<=26;i++){
					var valor=document.getElementById('sel'+i).value;
					//alert("El valor en la pregunta "+i+" es "+valor);
					if(valor=='xh'){
						valor=1;
						//alert("El valor en la pregunta "+i+" ya transformado es "+valor);
					}
					if(valor==''){
						//alert("Te falta contestar el ejercicio "+i);
						faltantes[nulo]=i;
						nulo++;
					}
				}
				if(nulo!=0)
				{
					var faltan=faltantes.toString();
					if(faltantes.length==1){
						alert("Te falta contestar el ejercicio: "+faltan);
					}
					else{
						alert("Te falta contestar los ejercicios: "+faltan);
					}
				}
				else{
					alert("Ahora se calificará el examen, ya no puedes cambiar tus respuestas");
					Califica();
				}
				//alert("El valor que obtuvo nulo fue: "+nulo);
				return false;
				});
				
				$("#contestaT").click(function (){
					//alert("Entró al contestaT");
					for(var i=1;i<=10;i++){
						var idSel="sel"+i;
						document.getElementById(""+idSel).selectedIndex="2";
						//alert("Ya seleccionó el index 2");
					}
					for(var i=11;i<=26;i++){
						document.getElementById('sel'+i).value="are";
					}
				});
				
				
			});
			
			function aMinuscula(campo){				
				var x = document.getElementById(''+campo+'');
				x.value = x.value.toLowerCase();
				var opciones=document.getElementById(''+campo+'').value;
				if(x.value.length==2  ){
					switch(opciones){
							case "is":
							case "ar":
							case "am"://alert ("Bien, puedes continuar");
							break;
							default:
							alert("This is not a valid answer, remember use \nthe correct form of the verb to be");	
							x.value="";
					}
				}
				if(x.value.length==3 && x.value!="are"){
					alert("This is not a valid answer, remember use \nthe correct form of the verb to be");
					x.value="";
				}
			}
			
		</script>
		<?php
		function opciones($num_pregunta,$op_correcta){						
			$opc=[0,1,2,3];	
			echo"<select id='sel$num_pregunta'>
			  <option selected "; echo ($opc[0]==$op_correcta) ? "value='' " : "value='' "; echo "id='".$num_pregunta."op".$opc[0]."' ></option>
			  <option "; echo ($opc[1]==$op_correcta) ? "value=xh " : "value=xi "; echo "id='".$num_pregunta."op".$opc[1]."' >am</option>
			  <option  "; echo ($opc[2]==$op_correcta) ? "value=xh " : "value=xc "; echo "id='".$num_pregunta."op".$opc[2]."' >is</option>
			  <option  "; echo ($opc[3]==$op_correcta) ? "value=xh " : "value=xa "; echo "id='".$num_pregunta."op".$opc[3]."' >are</option>
			</select>";
			//echo"<script>cambia($num_pregunta,$op_correcta);</script>";
		}
		function texto($num_pregunta){
			echo"<input type='text' id='sel".$num_pregunta."' onkeyup='aMinuscula(\"sel$num_pregunta\")' size='5' maxlength='3' style='line-height: 80%;' >";
		}
		?>
	</head>
	<body style="margin-top: 0%; font-size:1.4em" onload='habilita()'>
		<style>
			p{
				color: #FFF;
				font-size:18px;
				margin-left:20%;
			}
			select{
				color: #000;
			}
			option{
				color: #233072;
			}
			
			
		</style>
		
		<nav class="navbar navbar-inverse">			
				<div class="navbar-header">					
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>					  
					<a class="navbar-brand" >
						<img src="images/LogoUNAMamarillo.png" alt="UNAM" height="80%" width="5.5%" onclick='dirUNAM()' style="cursor:pointer; position:absolute; top:16%; left:5%; height=10%;">
					</a>
					<a class="navbar-brand" >
						<img alt="" src="images/LogoCGLblanco.png" alt="CGL" height="70%" width="12%" onclick='dirCGL()' style="cursor:pointer; position:absolute; top:20%; left:15%;">
					</a>
					
					  <!--<a class="navbar-brand" href="#">CGL</a>-->
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					  <p style="text-align: right;"><font style="color:#fff;font-size:2em; font-weight:bold;"><br/><?php echo $tituloEx;?></font></p>
					  
				</div><!--/.nav-collapse -->				
		  
		</nav>

		<br/>
		<div class="container container-fluid">	
			<?php
			$calificacionQ=$funciones->consultaUnica("SELECT q$nQuizz FROM $nombreBD Where Cuenta='$Cuenta'");
			if($calificacionQ==0){
				//echo"La calificacion del quizz fue $calificacionQ es 0";
			?>
			<form action="quizz.php" method="POST" id="quizz">
				<font style="color:#CB9D01; font-size:18px; text-align:center;"><b>Chose the correct form of the verb to be: am, is or are</b></font><br/><br/>			
				<p>
					<!--Las opciones de respuestas son: 1->am,2->is,3->are -->
					1. It <?php opciones(1,2)?> really hot today!<br/><br/><br/>
					2. Call me later, please. I <?php opciones(2,1)?> at school now.<br/><br/><br/>
					3. They <?php opciones(3,3)?>not Japanese.<br/><br/><br/>
					4. You <?php opciones(4,3)?> Penny's friend, right?<br/><br/><br/>
					5. My name <?php opciones(5,2)?> not Akira.<br/><br/><br/>
					6. We <?php opciones(6,3)?> from Salamanca, Spain.<br/><br/><br/>
					7. That <?php opciones(7,2)?> incredible!<br/><br/><br/>
					8. I <?php opciones(8,1)?> fine, thank you.<br/><br/><br/>
					9. Clara and Steve <?php opciones(9,3)?> my best friends.<br/><br/><br/>
					10. He <?php opciones(10,2)?> an English teacher in my school.<br/><br/><br/><br/>
				</p>
				<p style="line-height:200%; margin-left: 2%;">
					<font style="color:#CB9D01; font-size:18px; text-align:center;"><b>Complete the text with the correct form of the verb to be  (am, is or are).</b></font><br/><br/>
					Peter <?php texto(11)?> from New York, but Pam and her brother Joe <?php texto(12)?> from Los Angeles, California. New  York  and  California <?php texto(13)?> cities  in  the  United States.  Berlin <?php texto(14)?> a  city in  Germany. Sandra <?php texto(15)?> from  Berlin.  Joe and  Peter <?php texto(16)?> her  friends.  They <?php texto(17)?> in  the  same  class. Sandra's parents <?php texto(18)?> on a trip to Ireland to  visit her  aunt Danielle.  She <?php texto(19)?> a  nice and interesting woman.  Peter calls Sandra  on  the  phone  and  says:  "My mother <?php texto(20)?> in the hospital. It  <?php texto(21)?>  nothing  serious. I <?php texto(22)?> at  home  with  my  grandmother." Sandra  says: "What time <?php texto(23)?> it? It <?php texto(24)?> 3am. "<?php texto(25)?> n't you tired?" Peter answers: "No, I <?php texto(26)?> not."
					
				</p>
				<input type=button style='margin-left:35%;' class='btn' id='vRespuesta' value='Calificar examen'>				
				<input type=button style='margin-left:35%;' class='btn' id='contestaT' value='Contestar todo bien'>
				<input type='hidden' id='Calificacion' name='Calificacion' value='nulo'>
				<input type='hidden' id='nPreguntas' name='nPreguntas' value='<?php echo$nPreguntas;?>'>
				<input type='hidden' id='nQuizz' name='nQuizz' value='<?php echo $nQuizz;?>'>
				<br/>
				<br/>	
				</form>
			<?php }
			else{
				echo"<br/><br/>You have already answered this Quizz, please try another one<br/><br/>";
			}?>
			<br/>
			<br/>
			<u><a href='paqtlic.php'> Regresar</a></u>
			<br/>
			<br/>
			<u><a href='salirPdLic.php'> Cerrar sesión </a></u>
		</div><!-- container -->
		<br/>
			<br/>
			<br/>
			<br/> 
			<br/>
			<br/> 
		<br/>
		<br/>
		<br/>
		<br/>
		<footer class="footer">
			<div class="container">
				<p class="text-muted"><font style="font-size: 0.9em">
					Hecho en M&eacute;xico, <a href="http://www.unam.mx">Universidad Nacional Aut&oacute;noma de M&eacute;xico (UNAM)</a>, todos los derechos reservados 2009 - 2015. Esta p&aacute;gina puede ser reproducida con fines no lucrativos, siempre y cuando se cite la fuente completa y su direcci&oacute;n electr&oacute;nica, y no se mutile. De otra forma requiere permiso previo por escrito de la instituci&oacute;n.<a href="creditos.html">Cr&eacute;ditos</a></font>
				</p>
			</div>
		</footer>
		<!--Ingeniero Hugo Luna a.k.a. hugix4-->
	</body>
</html>
