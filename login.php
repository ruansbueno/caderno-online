<main>
        <form method="post">
            <input required type="text" name="nome" placeholder="Nome">
            <input type="password" name="senha" placeholder="Senha" required></textarea>
            <input type="submit" value="Entrar" name="enviar">
        </form>
        <p>Ainda não tem uma conta?</p><a style="margin-left: 5px;" href="cadastro">Cadastre-se!</a>
</main>
</body>
</html>

<?php 
    if(isset($_POST['enviar'])){
        $pdo = MySQL::connect();
        $pdo->exec("LOCK TABLES `users` READ");
        $sql = $pdo->prepare("SELECT * FROM `users` WHERE `nome` = ?");
        $sql->execute(array(htmlspecialchars($_POST['nome'])));
        $user = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(count($user) == 1){
            if(password_verify($_POST['senha'], $user[0]['senha'])){
                $_SESSION['login'] = $user[0]['id'];
                echo '<script>window.location = "'.PATH.'"</script>';
                die();
            }else{
                echo '<script>alert("Usuário e/ou senha incorretos")</script>';
                echo '<script>window.location = "'.PATH.'"</script>';
                die();
            }
        }else{
            echo '<script>alert("Usuário e/ou senha incorretos")</script>';
            echo '<script>window.location = "'.PATH.'"</script>';
            die();
        }

        $pdo->exec("UNLOCK TABLES");
    }
?>