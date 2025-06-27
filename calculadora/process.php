<?php
session_start(); // Inicia a sessão para armazenar o estado da calculadora entre as requisições

// Recupera os dados anteriores ou define valores padrão
$input = $_SESSION['input'] ?? ""; // Valor atual exibido no visor da calculadora (vindo da sessão)
$operator = $_POST['op'] ?? null; // Operador clicado (+, -, *, /), vindo do formulário
$number = $_POST['num'] ?? null; // Número clicado (0 a 9 ou "c"), vindo do formulário
$equalPressed = isset($_POST['equal']); // Verifica se o botão "=" foi pressionado

// Botão "C" — limpa o visor
if ($number === "c") {
    $_SESSION['input'] = ""; // Limpa o valor armazenado no visor
    header("Location: index.php"); // Redireciona de volta para a página principal (limpa o POST)
    exit(); // Encerra o script
}

// Número clicado (0 a 9)
if ($number !== null && $number !== "c") {
    $input .= $number; // Adiciona o número ao valor atual do visor
    $_SESSION['input'] = $input; // Atualiza a sessão com o novo valor
    header("Location: index.php"); // Redireciona para recarregar a interface
    exit();
}

// Operador clicado (+, -, *, /)
if ($operator !== null) {
    $input .= $operator; // Adiciona o operador ao valor atual do visor
    $_SESSION['input'] = $input; // Atualiza a sessão
    header("Location: index.php"); // Redireciona para a interface principal
    exit();
}

// Botão "=" pressionado — executa o cálculo
if ($equalPressed) {
    $rawInput = $input; // Guarda a expressão original para exibição
    $safeInput = preg_replace('/[^0-9+\-*\/().]/', '', $rawInput); // Remove quaisquer caracteres não permitidos

    if (!empty($safeInput)) {
        try {
            $result = eval("return $safeInput;"); // Avalia a expressão (com cuidado, pois eval pode ser perigoso)
            if ($result === false || $result === null) {
                $_SESSION['input'] = "Erro!"; // Caso a avaliação falhe
            } else {
                $_SESSION['input'] = "$rawInput = $result"; // Mostra a expressão original seguida do resultado
            }
        } catch (Throwable $e) {
            $_SESSION['input'] = "Erro!"; // Captura qualquer exceção durante a avaliação
        }
    } else {
        $_SESSION['input'] = "Inválido!"; // Se não houver expressão válida
    }

    header("Location: index.php"); // Atualiza a interface com o resultado
    exit();
}
