<?php


// Listar todos os clubes
function listar_clubes($pdo) {
    $query = "SELECT * FROM clube";
    $stmt = $pdo->query($query);
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Cadastrar um clube
function cadastrar_clube($pdo) {
    $nome = $_POST["nome_clube"];
    $saldo_disponivel = $_POST["saldo_disponivel"];

    $query = "INSERT INTO clube (nome_clube, saldo_disponivel) VALUES (:nome_clube, :saldo_disponivel)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":nome_clube", $nome);
    $stmt->bindParam(":saldo_disponivel", $saldo_disponivel);
    $stmt->execute();

    $novo_clube = [
        "id" => $pdo->lastInsertId(),
        "nome_clube" => $nome,
        "saldo_disponivel" => $saldo_disponivel
    ];

    return json_encode($novo_clube);
}

// Consumir recurso de um clube
function consumir_recurso($pdo, $clube_id) {
    $recurso_id = $_POST["recurso_id"];
    $valor_consumo = $_POST["valor_consumo"];

    // Verificar se o clube existe
    $query = "SELECT * FROM clube WHERE id = :clube_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":clube_id", $clube_id);
    $stmt->execute();
    $clube = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$clube) {
        return json_encode(["mensagem" => "Clube não encontrado"]);
    }

    // Verificar se o recurso existe
    $query = "SELECT * FROM recursos WHERE id = :recurso_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":recurso_id", $recurso_id);
    $stmt->execute();
    $recurso = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recurso) {
        return json_encode(["mensagem" => "Recurso não encontrado"]);
    }

    // Verificar saldo disponível do clube
    $novo_saldo_clube = $clube["saldo_disponivel"] - $valor_consumo;
    if ($novo_saldo_clube < 0) {
        if ($valor_consumo > $recurso["saldo_disponivel"]) {
            return json_encode(["mensagem" => "O saldo disponível do clube é insuficiente"], 400);
        } else {
            return json_encode(["mensagem" => "O saldo disponível do clube é insuficiente"]);
        }
    }

    // Atualizar saldos
    $query = "UPDATE clube SET saldo_disponivel = :novo_saldo_clube WHERE id = :clube_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":novo_saldo_clube", $novo_saldo_clube);
    $stmt->bindParam(":clube_id", $clube_id);
    $stmt->execute();

    // Verificar saldo disponível do recurso
    $novo_saldo_recurso = $recurso["saldo_disponivel"] - $valor_consumo;
    $query = "UPDATE recursos SET saldo_disponivel = :novo_saldo_recurso WHERE id = :recurso_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":novo_saldo_recurso", $novo_saldo_recurso);
    $stmt->bindParam(":recurso_id", $recurso_id);
    $stmt->execute();

    $resposta = [
        "mensagem" => "Consumo realizado com sucesso",
        "clube" => $clube["nome_clube"],
        "saldo_anterior" =>  $clube["saldo_disponivel"],
        "saldo_atual" => sprintf("%.2f", $novo_saldo_clube),
        
    ];

    return json_encode($resposta);
}



?>