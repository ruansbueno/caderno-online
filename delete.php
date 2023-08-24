<?php
	$pdo = MySQL::connect();

	$id_to_exclude = explode('-',$_GET['url'])[1];

	$sql = $pdo->prepare("SELECT * FROM `anotacoes` WHERE `id` = ?");
	$sql->execute(array($id_to_exclude));
	$anotacao = $sql->fetch(PDO::FETCH_ASSOC);

	if(count($anotacao) == 0){
		echo '<script>alert("Essa anotação não existe!")</script>';
        echo '<script>window.location = "'.PATH.'"</script>';
	}else{
		if($anotacao['id_user'] == $_SESSION['login']){
			$sql = $pdo->prepare("DELETE FROM `anotacoes` WHERE `id` = ?");
			if($sql->execute(array($id_to_exclude))){
				echo '<script>alert("Anotação excluída com sucesso!")</script>';
	            echo '<script>window.location = "'.PATH.'"</script>';
			}
		}
	}
	