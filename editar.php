<?php
    $pdo = MySQL::connect();

    $id = explode('-', $_GET['url'])[1];
    if(isset($_POST['enviar'])){

        if($_POST['anotacao'] == ''){
            echo '<script>alert("Anotação vazia!")</script>'; 
        }else{
          $sql = $pdo->prepare('UPDATE `anotacoes` SET `titulo_anotacao`= ?, `anotacao` = ? WHERE `id` = ? AND `id_user` = ?');

            if($sql->execute(array($_POST['nome'],$_POST['anotacao'],$id,$_SESSION['login']))){
                echo '<script>window.location = "'.PATH.'"</script>';
                die();
            }else{
                echo '<script>alert("Erro")</script>';
            }  
        }
        
    }


    $sql = $pdo->prepare("SELECT * FROM `anotacoes` WHERE `id` = ? AND `id_user` = ?");
    $sql->execute(array($id,$_SESSION['login']));

    $anotacao = $sql->fetch(PDO::FETCH_ASSOC);

    if($anotacao == []){
        echo '<script>alert("Você não tem autorização para editar essa anotação!")</script>';
        echo '<script>window.location = "'.PATH.'"</script>';
        die();
    }else{
?>



<main>
    <form method="post">
        <input required type="text" value="<?= $anotacao['titulo_anotacao'] ?>" name="nome" placeholder="Título da sua anotação">
        <textarea class="tinymce" name="anotacao" placeholder="Sua anotação"><?= $anotacao['anotacao']; ?></textarea>
        <input type="submit" value="Salvar" name="enviar">
    </form>
</main>
</body>
</html>
<?php } ?>