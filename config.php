<?php
	session_start();

	define('PATH', 'http://localhost/caderno/');
	define('DB_NAME', 'caderno');
	define('DB_USER', 'root');
	define('DB_PASS', '');

    include 'MySQL.php';
    $pdo = MySQL::connect();