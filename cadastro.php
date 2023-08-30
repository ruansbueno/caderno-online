<main>
        <form method="post">
            <input required type="text" name="nome" placeholder="Nome">
            <input type="password" name="senha" placeholder="Senha" required></textarea>
            <input type="submit" value="Cadastre-se" name="cadastrar">
        </form>
</main>
</body>
</html>

<?php 
    if(isset($_POST['cadastrar'])){
        $pdo = MySQL::connect();
        $pdo->exec("LOCK TABLES `users` READ");
        $sql = $pdo->prepare("SELECT * FROM `users` WHERE `nome` = ?");
        $sql->execute(array(htmlspecialchars($_POST['nome'])));
        $user = $sql->fetchAll(PDO::FETCH_ASSOC);
        $pdo->exec("UNLOCK TABLES");

        if(count($user) == 0){
            $pdo->exec("LOCK TABLES `users` WRITE");

            $sql = $pdo->prepare('INSERT INTO `users` VALUES (null, ?,?)');
            if($sql->execute(array(htmlspecialchars($_POST['nome']),password_hash($_POST['senha'], PASSWORD_DEFAULT)))){
                echo '<script>alert("Cadastrado com sucesso!")</script>';
                echo '<script>window.location = "'.PATH.'"</script>';
                die();
            }
            $pdo->exec("UNLOCK TABLES");
        }else{
            echo '<script>alert("Esse usuário já existe!")</script>';
            echo '<script>window.location = "'.PATH.'cadastro"</script>';
            die();
        }
    }
?>