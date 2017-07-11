<?php
	
	include_once( dirname( __FILE__ ) . '/../class/Database.class.php' );
	
	$get = $_GET['data'];
	$pdo = Database::getInstance()->getPdoObject();

	function InsertInfo($data,$pdo)
	{
		$query = $pdo->prepare( 'INSERT INTO message VALUES( null,:tarea,:comentario,:user,:estado,:Nombre)' );
		if($query->execute( array( ':tarea' => $data['tarea'], ':comentario' => $data['comentario'],':user' => $data['user'], ':estado' => $data['estado'],':Nombre'=>$data['nombreUser'] ) ))
		{
			return $data['user'];
		}
		else
		{
			echo "<pre>";
			print_r($query->errorInfo());
			print_r($data);
			echo "</pre>";
			
			
		}
	}
	function getTareas($data,$pdo)
	{
		$query = $pdo->prepare( 'SELECT COUNT(estado) as estado ,user,tarea,comentario,Nombre from message where user = :user');
		if($query->execute(array(":user"=>$data['user'])))
		{
			$valor=0;
			// $data=array();
			while ($row = $query->fetch()) {
				$data[]=array(
					'user' => $row['user'],
					'estados' => $row['estado'],
					'tarea' => $data['tarea'],
					'comentario' => $data['comentario'],
					'Nombre' => $row['Nombre'],
					);
			}
			return $data;
		}
		else
		{
			echo "<pre>";
			print_r($query->errorInfo());
			echo "</pre>";
			
			
		}
	}
	if($get==1){
		$response=InsertInfo($_POST,$pdo );

		if($response > 0)
		{
			$responses=getTareas($_POST,$pdo);
			echo json_encode($responses);
		}
	}

	
?>