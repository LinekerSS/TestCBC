<?php

require_once __DIR__ . './function/funcoes.php';

$db_host = "localhost";
$db_name = "nomedobanco";
$db_user = "usuario";
$db_password = "senha";

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
};


if ($_SERVER["REQUEST_METHOD"] === "GET" && $_SERVER["REQUEST_URI"] === "/clubes") {
    // Endpoint para listar todos os clubes
    echo listar_clubes($pdo);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && $_SERVER["REQUEST_URI"] === "/clube") {
    // Endpoint para cadastrar um clube
    echo cadastrar_clube($pdo);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && preg_match("/^\/clubes\/(\d+)\/consumir-recurso$/", $_SERVER["REQUEST_URI"], $matches)) {
    // Endpoint para consumir recurso de um clube
    $clube_id = $matches[1];
    echo consumir_recurso($pdo, $clube_id);
} else {
    // Endpoint inválido
    http_response_code(404);
    echo json_encode(["mensagem" => "Endpoint não encontrado"]);
}


?>