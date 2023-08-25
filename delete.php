<?php
	$pdo = MySQL::connect();

	$id_to_exclude = isset(explode('-',$_GET['url'])[1]) ? explode('-',$_GET['url'])[1] : '';

	if($id_to_exclude == '') {
        echo '<script>window.location = "'.PATH.'"</script>';
		die();
	}else{
		$sql = $pdo->prepare("SELECT * FROM `anotacoes` WHERE `id` = ?");
		$sql->execute(array($id_to_exclude));
		$anotacao = $sql->fetchAll(PDO::FETCH_ASSOC);
		if(count($anotacao) == 0){
	        echo '<script>window.location = "'.PATH.'"</script>';
	        die();
		}else{
			if($anotacao[0]['id_user'] == $_SESSION['login']){
				$sql = $pdo->prepare("DELETE FROM `anotacoes` WHERE `id` = ?");
				if($sql->execute(array($id_to_exclude))){
		            echo '<script>window.location = "'.PATH.'"</script>';
				}
			}
		}

	}

	