<?php
    $pdo = MySQL::connect();

    $id = explode('-', $_GET['url'])[1];

    $sql = $pdo->prepare('SELECT * FROM `anotacoes` WHERE `id` = ?');

    $sql->execute(array($id));

    $anotacao = $sql->fetch(PDO::FETCH_ASSOC);

    if($anotacao['id_user'] != $_SESSION['login']){
        echo '<script>alert("Você não tem autorização para ler essa anotação!")</script>';
         echo '<script>window.location = "'.PATH.'"</script>';
    }

    

?>

    <main>
        <section class="anotacoes">
            <h2><?php echo $anotacao['titulo_anotacao']; ?></h2>
            <a class="edit" href="editar-<?php echo $anotacao['id']; ?>">Editar</a>
            <p><?php echo $anotacao['anotacao']; ?></p>
            <a class="button" href="<?php echo PATH; ?>">Voltar à Home</a>
        </section>
    <main>

</body>

</html>