<?php
    $pdo = MySQL::connect();

    $id = isset(explode('-',$_GET['url'])[1]) ? explode('-',$_GET['url'])[1] : '';
    if($id == ''){
        echo '<script>window.location = "'.PATH.'"</script>';
        die();
    }else{
        $sql = $pdo->prepare('SELECT * FROM `anotacoes` WHERE `id` = ?');

        $sql->execute(array($id));

        $anotacao = $sql->fetch(PDO::FETCH_ASSOC);

        if($anotacao == []){
            echo '<script>window.location = "'.PATH.'"</script>';
            die();
        }else if($anotacao['id_user'] != $_SESSION['login']){
            echo '<script>alert("Você não tem autorização para ler essa anotação!")</script>';
            echo '<script>window.location = "'.PATH.'"</script>';
            die();
        }
    }

    

?>

    <main>
        <section class="anotacoes" style=" 
            -webkit-box-shadow: 0px 0px 26px -10px rgba(0,0,0,0.66);
            -moz-box-shadow: 0px 0px 26px -10px rgba(0,0,0,0.66);
            box-shadow: 0px 0px 26px -10px rgba(0,0,0,0.66);
            padding: 20px;
            border-radius: 15px;"
            >
            <h2 style="font-weight:600"><?= $anotacao['titulo_anotacao']; ?></h2>
            <div class="tools">
                <a class="edit" href="editar-<?= $anotacao['id']; ?>"><i class="fa-solid fa-pencil"></i> &nbsp;&nbsp;Editar</a>
                <a class="delete" href="delete-<?= $anotacao['id']; ?>"><i class="fa-regular fa-trash-can"></i></a>
            </div>
            <p><?= $anotacao['anotacao']; ?></p>
            <a class="button" href="<?= echo PATH; ?>">Voltar à Home</a>
        </section>
    <main>

</body>

</html>