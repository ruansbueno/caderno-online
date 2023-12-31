<?php

    if(isset($_POST['enviar'])){
        if($_POST['anotacao'] == ''){
            echo '<script>alert("Anotação vazia!")</script>';
        }else{
            $pdo = MySQL::connect();

            $pdo->exec("LOCK TABLES `anotacoes` WRITE");

            $sql = $pdo->prepare('INSERT INTO `anotacoes` VALUES(null, ?,?,?)');
            if($sql->execute(array($_POST['nome'],$_POST['anotacao'],$_SESSION['login']))){
                echo '<script>window.location = "'.PATH.'"</script>';
                die();
            }else{
                echo '<script>alert("Erro")</script>';
            }
            $pdo->exec("UNLOCK TABLES");

        }
        
    }

    $pdo->exec("LOCK TABLES `anotacoes` READ");

    $sql = $pdo->prepare("SELECT id,titulo_anotacao,id_user FROM `anotacoes` WHERE `id_user` = ?");
    $sql->execute(array($_SESSION['login']));

    $anotacao = $sql->fetchAll(PDO::FETCH_ASSOC);

    $pdo->exec("UNLOCK TABLES");
?>



<main>
    <form method="post">
        <input required type="text" name="nome" placeholder="Título da sua anotação">
        <textarea  class="tinymce" name="anotacao" placeholder="Sua anotação"></textarea>
        <input type="submit" value="Salvar" name="enviar">
    </form>

    <section class="anotacoes">
        <h2>Anotações anteriores:</h2>
        <ul>
            <?php
                if(count($anotacao) >= 1){
                    foreach ($anotacao as $key => $value) {
                        echo '<li>
                                  <a href="anotacao-'.$value['id'].'">'.$value['titulo_anotacao'].'</a>
                                  <a href="delete-'.$value['id'].'" class="delete"><i class="fa-regular fa-trash-can"></i></a>
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