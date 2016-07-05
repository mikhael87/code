<html>
<head>

<title>jQuery Hello World</title>
<script type="text/javascript" src="js/jquery.js"></script>

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap-theme.css">

<script>
	$(document).ready(function() {
		var op= ''; item=''; cantidad='';
		show_car(item, cantidad, op);
	});

	function add_item(item) {
		var cantidad= $('#item_cantidad_'+item).val();
		var op= 'add';

		show_car(item, cantidad, op);
	}

	function remove_item(item) {
		var op= 'remove';
		var cantidad='';

		show_car(item, cantidad, op);
	}

	function show_car(item, cantidad, op) {
		$.ajax({
		    url:'action.php',
		    type:'POST',
		    dataType:'html',
		    data: 'item='+item+'&cantidad='+cantidad+'&op='+op,
		    success:function(data, textStatus){
		        $('#car_content').html(data);
		    }});
	}

</script>

</head>
<body>
	<?php

	session_start();
	$_SESSION["usuario"]= 1;

	$con= mysqli_connect("localhost","root","") or die ("Imposible contectar con mysql"); 

	mysqli_select_db($con,"prueba") or die ("no database"); 

	//$result_ini = mysqli_query($con,"INSERT INTO productos (id, nombre, descripcion, precio) VALUES (NULL, 'Coca-Cola', 'Bebida de cola', '1,5')");

	$sql="SELECT * FROM productos";

	$result = mysqli_query($con,$sql);

	$show='';
	$show.='<table border="1"><tr>
	<td>Accion</td>
	<td>Cantidad</td>
	<td>Nombre</td>
	<td>Precio</td></tr>';
	while($row = mysqli_fetch_array($result))
	  {
		  $show.='<tr><td><a href="#" onclick="add_item('.$row["id"].')">Agregar</a></td>';
		  $show.='<td><input id="item_cantidad_'.$row["id"].'" type="text" value="1" /></td>';
		  $show.='<td>'.$row["nombre"].'</td>';
		  $show.='<td>'.$row["precio"].'</td></tr>';
	  }
	$show.='</table>';

	echo $show;

	mysqli_close($con);

	?>

	<div id="car">
		<h1>Carrito de compras</h1>
		<div id="car_content">
			
		</div>
	</div>
</body>
</html>
