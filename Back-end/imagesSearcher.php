<?php

include("connection.php");

$searchTerm = $_REQUEST["var1"];
$mySQLQuery = "SELECT * FROM tag WHERE nombre = '$searchTerm'";
$retval = mysqli_query($con, $mySQLQuery);
$num_rows = $retval->num_rows;
	if ($num_rows == 0){
		?>
        <h3>Sorry, there are not images with that tag</h3> 
		<?php
	}else{
		// the tag exists on the database
		$row = $retval->fetch_assoc();
		$tagId = $row["id"];
		$tagName = $row["nombre"];
		$mySQLQueryImages = "SELECT imagen.ruta FROM imagen INNER JOIN imagentag ON imagentag.idImagen=imagen.id WHERE imagentag.idTag ='$tagId'";
		$retval2 = mysqli_query($con, $mySQLQueryImages);
		$num_rows = $retval2->num_rows;
		if ($num_rows > 0){
			while( $row2 = $retval2->fetch_assoc() ) {
    			$paths[] = $row2["ruta"];
			}
		}
		
		echo json_encode($paths);
	}

?>