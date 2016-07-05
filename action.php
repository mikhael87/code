<?php
session_start();

$con= mysqli_connect("localhost","root","") or die ("Imposible contectar con mysql"); 

mysqli_select_db($con,"prueba") or die ("no database"); 

switch ($_POST['op']) {
	case 'add':
		//verifica si primero existe
		$consult="SELECT COUNT(*) AS num, cantidad FROM carro WHERE producto_id=".$_POST['item'];
		$result = mysqli_query($con,$consult);
		$re= mysqli_fetch_array($result);
		if ($re['num'] > 0) {
			//En caso que ya exista este producto en el carrito
			$new_cant= $re['cantidad']+$_POST['cantidad'];
			$consult="UPDATE carro SET cantidad=". $new_cant ." WHERE producto_id=".$_POST['item'];
			$ok_update = mysqli_query($con,$consult);
		}else {
			//En caso que este producto no exista en el carrito
			$result_ini = mysqli_query($con,"INSERT INTO carro (usuario_id, producto_id, cantidad) VALUES (".$_SESSION['usuario'].", ".$_POST['item'].", ".$_POST['cantidad'].")");
		}
		break;
	case 'remove':
		$remove="DELETE FROM carro WHERE producto_id=".$_POST['item'];
		$result = mysqli_query($con,$remove);
		break;
	default:
		# no hacer nada
		break;
}


$sql="SELECT c.cantidad, p.nombre, p.precio, p.id FROM carro c INNER JOIN productos p ON c.producto_id = p.id";

$result = mysqli_query($con,$sql);

$show=''; $subtotal= 0;
$show.='<table border="1"><tr><td>Accion</td><td>Cantidad</td><td>Nombre</td><td>Precio</td></tr>';
while($row = mysqli_fetch_array($result))
  {
	  $show.='<tr><td><a href="#" onclick="remove_item('.$row["id"].')">Eliminar</a></td>';
	  $show.='<td>'.$row["cantidad"].'</td>';
	  $show.='<td>'.$row["nombre"].'</td>';
	  $show.='<td style="text-align: right">'.$row["precio"] * $row["cantidad"].'</td></tr>';

	  $subtotal+= $row["precio"] * $row["cantidad"];
  }
$iva= $subtotal*0.12;
$total= ($subtotal*0.12) + $subtotal;
$show.='<tr><td style="text-align: right" colspan="3">Sub-Total:</td><td style="text-align: right">'.$subtotal.'</td></tr>';
$show.='<tr><td style="text-align: right" colspan="3">Iva 12%:</td><td style="text-align: right">'.$iva.'</td></tr>';
$show.='<tr><td style="text-align: right" colspan="3">Total:</td><td style="text-align: right"><b>'.$total.'</b></td></tr>';
$show.='</table>';

echo $show;
?>
