# 📄 Documentação Técnica — Calculadora PHP com Sessão e Avaliação de Expressões

## 📌 Visão Geral

Este sistema simula uma **calculadora funcional** utilizando HTML (frontend) e PHP (backend), com suporte a operações básicas (+, -, \*, /), controle por **sessões** e segurança básica na avaliação de expressões. O sistema usa dois arquivos principais:

* `index.php`: Interface do usuário (visualmente interativa)
* `process.php`: Lógica do processamento de dados (back-end PHP)

---

## 🔁 Sessões em PHP (`session_start()`)

A função `session_start()` é usada para iniciar uma **sessão PHP**. Isso permite **armazenar informações entre requisições HTTP**, como por exemplo:

```php
$_SESSION['input'] = "5+3";
```

Com isso, conseguimos manter o conteúdo do visor da calculadora mesmo após cliques consecutivos de botões.

---

## 🧠 Lógica de Processamento (`process.php`)

### 🔍 Variáveis principais:

| Variável | Função |
| --------------- | -------------------------------------------------- |
| `$input` | Armazena a expressão atual do visor |
| `$operator` | Armazena o operador clicado (+, -, etc.) |
| `$number` | Armazena o número clicado (0 a 9 ou "c") |
| `$equalPressed` | Booleano que indica se o botão "=" foi pressionado |

---

## 🧼 Limpeza de dados (Botão "C")

```php
if ($number === "c") {
$_SESSION['input'] = "";
header("Location: index.php");
exit();
}
```

Essa parte **reseta a calculadora** limpando a sessão e recarregando a página com o visor vazio.

---

## 🔢 Entrada de números

```php
if ($number !== null && $number !== "c") {
$input .= $number;
$_SESSION['input'] = $input;
header("Location: index.php");
exit();
}
```

Se um número for clicado, ele é **concatenado ao valor atual do visor**. O operador `.=` adiciona o novo número ao final da string existente.

---

## ➕ Entrada de operadores

```php
if ($operator !== null) {
$input .= $operator;
$_SESSION['input'] = $input;
header("Location: index.php");
exit();
}
```

De forma semelhante, se um operador for clicado, ele também é **concatenado** à expressão.

---

## 🟰 Avaliação da expressão matemática

```php
if ($equalPressed) {
$rawInput = $input;
$safeInput = preg_replace('/[^0-9+\-*\/().]/', '', $rawInput);
```

* `preg_replace()` remove caracteres inválidos (ex: letras ou símbolos estranhos)
* Isso é uma **medida de segurança** mínima ao usar `eval()`

---

### ⚙️ Execução com `eval()`

```php
$result = eval("return $safeInput;");
```

A função `eval()` **executa a string como se fosse código PHP**. Exemplo:

```php
eval("return 5+3;"); // retorna 8
```

---

### 🛑 Tratamento de Erros

```php
if ($result === false || $result === null) {
$_SESSION['input'] = "Erro!";
} else {
$_SESSION['input'] = "$rawInput = $result";
}
```

* Se algo der errado: mostra `"Erro!"`
* Se funcionar: exibe a expressão completa com o resultado final

---

## 🔁 Redirecionamento com `header()`

```php
header("Location: index.php");
exit();
```

A cada ação, o código redireciona a página para o `index.php`, que **exibe a expressão ou resultado atualizado** no visor da calculadora. Isso permite que o usuário interaja sem ver diretamente os bastidores do PHP.

---

## 🧠 Explicação do fluxo completo

1. O usuário clica em um botão (número ou operador)
2. A requisição é enviada para `process.php`
3. O PHP analisa o que foi clicado:

* Se foi número ou operador, adiciona ao visor
* Se foi "C", limpa tudo
* Se foi "=", avalia a expressão
4. O PHP salva o novo estado na sessão
5. Redireciona para `index.php` com a nova expressão ou resultado

---

## ⚠️ Segurança (sobre `eval()`)

Embora usado aqui para fins didáticos, o uso de `eval()` **pode ser perigoso** se não for tratado corretamente. Para evitar riscos:

* Nunca aceite entrada direta do usuário sem validação
* Nunca use `eval()` em ambientes de produção sem sanitização completa
* Evite `eval()` se puder usar alternativas como **parser matemático próprio**

---

## 🛠 Recursos utilizados no projeto

| Recurso | Descrição |
| ---------------- | --------------------------------------------------- |
| PHP | Linguagem back-end que processa requisições |
| Sessions | Armazenamento de dados entre cliques |
| HTML + CSS | Interface visual (frontend da calculadora) |
| Botões `submit` | Enviam os dados ao `process.php` |
| `eval()` | Executa expressões matemáticas como código PHP |
| `preg_replace()` | Faz validação e limpeza de expressões |
| `header()` | Redireciona automaticamente a tela após cada clique |

## 📚 Conclusão
Este sistema de calculadora em PHP é um exemplo didático de como integrar frontend e backend, utilizando sessões para manter o estado da aplicação. Através deste projeto, os alunos podem aprender sobre manipulação de dados, segurança básica e a importância de validar entradas antes de processá-las.