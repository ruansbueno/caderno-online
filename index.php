<?php
    include 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caderno</title>
    <script src="https://cdn.tiny.cloud/1/e3jn3xetmvvk5wrf4uaijzegxnn4qvcxaw1h1df6siokbl8a/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'.tinymce'});</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/font-awesome/all.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <header>
        <?php if(isset($_SESSION['login'])): ?>
            <a href="sair" class="logout">Sair</a>
        <?php endif; ?>
        <h1>Caderno</h1>
    </header>

<?php
    if(isset($_SESSION['login'])){
        if(!isset($_GET['url'])){
            include 'insere.php';
        }else{
            $url = explode('-',$_GET['url'])[0];
            if(file_exists($url.'.php')){
                include $url.'.php';
            }else{
                switch ($url) {
                    case 'sair':
                        if(isset($_SESSION['login'])){
                            session_destroy();
                        }
                        echo '<script>window.location = "'.PATH.'"</script>';
                        break;

                    default:
                        echo '<script>window.location = "'.PATH.'"</script>'; 
                        break;
                }
            }
        }

    }else if(isset($_GET['url']) && explode('/', $_GET['url'])[0] == 'cadastro'){
        include('cadastro.php');
    }else{
        include 'login.php';
    }



