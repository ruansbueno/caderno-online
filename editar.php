<?php
    $pdo = MySQL::connect();

    $id = explode('-', $_GET['url'])[1];
    if(isset($_POST['enviar'])){
        $sql = $pdo->prepare('UPDATE `anotacoes` SET `titulo_anotacao`= ?, `anotacao` = ? WHERE `id` = ? AND `id_user` = ?');

        if($sql->execute(array(htmlspecialchars($_POST['nome']),htmlspecialchars($_POST['anotacao']),$id,$_SESSION['login']))){
            echo '<script>alert("Salvo com sucesso!")</script>';
            echo '<script>window.location = "'.PATH.'"</script>';

        }else{
            echo '<script>alert("Erro")</script>';
        }
    }


    $sql = $pdo->prepare("SELECT * FROM `anotacoes` WHERE `id` = ? AND `id_user` = ?");
    $sql->execute(array($id,$_SESSION['login']));

    $anotacao = $sql->fetch(PDO::FETCH_ASSOC);

    if($anotacao == []){
        echo '<script>alert("Você não tem autorização para editar essa anotação!")</script>';
         echo '<script>window.location = "'.PATH.'"</script>';
    }else{
?>



<main>
    <form method="post">
        <input required type="text" value="<?php echo $anotacao['titulo_anotacao'] ?>" name="nome" placeholder="Título da sua anotação">
        <textarea name="anotacao" placeholder="Sua anotação" required><?php echo $anotacao['anotacao']; ?></textarea>
        <input type="submit" value="Salvar" name="enviar">
    </form>

    <section class="anotacoes">
        <h2>Anotações anteriores:</h2>
        <ul>
            <?php
            	$sql = $pdo->prepare("SELECT id,titulo_anotacao,id_user FROM `anotacoes` WHERE `id_user` = ?");
    		$sql->execute(array($_SESSION['login']));

    		$anotacao = $sql->fetchAll(PDO::FETCH_ASSOC);
                if(count($anotacao) >= 1){
                    foreach ($anotacao as $key => $value) {
                        echo '<li>
                                 <a href="anotacao-'.$value['id'].'">'.$value['titulo_anotacao'].'</a> | <a href="delete-'.$value['id'].'">Excluir</a>
                             </li>';
                    }
                }else{
                    echo '<h3>Você ainda não tem anotações.</h3>';
                }

            ?>
        </ul>
    </section>
</main>
</body>
</html>
<?php } ?>