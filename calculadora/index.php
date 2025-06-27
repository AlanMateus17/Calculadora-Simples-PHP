<?php
session_start();
$input = $_SESSION['input'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: rgb(163, 159, 159);
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            color: whitesmoke;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            text-shadow: 2px 2px 4px black;
            background-image: url("https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fGNhbGN1bGF0b3J8ZW58MHx8fHwxNjg5NTYyNzQ5&ixlib=rb-4.0.3&q=80&w=1080");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            backdrop-filter: blur(5px);
        }

        .calc {
            margin: auto;
            background-color: black;
            border: 2px solid whitesmoke;
            width: 23%;
            height: 650px;
            border-radius: 20px;
            box-shadow: 10px 10px 40px;
        }

        .maininput {
            width: 100%;
            height: 100px;
            font-size: 40px;
            background: black;
            border: 1px solid grey;
            color: white;
            padding: 10px;
            box-sizing: border-box;
            overflow-x: auto;
            white-space: nowrap;
        }

        .numbtn,
        .calbtn,
        .equal,
        .c {
            padding: 35px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: large;
            cursor: pointer;
        }

        .numbtn {
            background-color: gray;
        }

        .numbtn:hover {
            background-color: rgb(136, 133, 133);
            color: black;
        }

        .calbtn {
            background-color: orange;
        }

        .calbtn:hover {
            background-color: rgb(211, 140, 7);
            color: whitesmoke;
        }

        .equal {
            background-color: green;
        }

        .equal:hover {
            background-color: rgb(8, 181, 8);
            color: whitesmoke;
        }

        .c {
            background-color: red;
        }

        .c:hover {
            background-color: rgb(188, 16, 16);
            color: whitesmoke;
        }

        .container {
            margin-bottom: 40%;
            padding: 40px;
            display: inline-block;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .time {
            font-size: 32px;
            color: #fff;
        }

        .label {
            font-size: 20px;
            color: #ccc;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="calc">
        <form method="post" action="process.php">
            <br>
            <input type="text" class="maininput" name="input" value="<?= htmlspecialchars($input) ?>" readonly>
            <br><br>
            <input type="submit" class="numbtn" name="num" value="7">
            <input type="submit" class="numbtn" name="num" value="8">
            <input type="submit" class="numbtn" name="num" value="9">
            <input type="submit" class="calbtn" name="op" value="+"><br><br>
            <input type="submit" class="numbtn" name="num" value="4">
            <input type="submit" class="numbtn" name="num" value="5">
            <input type="submit" class="numbtn" name="num" value="6">
            <input type="submit" class="calbtn" name="op" value="-"><br><br>
            <input type="submit" class="numbtn" name="num" value="1">
            <input type="submit" class="numbtn" name="num" value="2">
            <input type="submit" class="numbtn" name="num" value="3">
            <input type="submit" class="calbtn" name="op" value="*"><br><br>
            <input type="submit" class="c" name="num" value="c">
            <input type="submit" class="numbtn" name="num" value="0">
            <input type="submit" class="equal" name="equal" value="=">
            <input type="submit" class="calbtn" name="op" value="/">
        </form>
    </div>

    <div class="container">
        <div class="label">DATA E HORA ATUAL (São Paulo):</div>
        <div class="time" id="clock"></div>
    </div>

    <script>
        function updateClock() {
            const clock = document.getElementById('clock');
            const now = new Date();
            const saoPauloOffset = -3;
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const saoPauloTime = new Date(utc + (3600000 * saoPauloOffset));

            const day = String(saoPauloTime.getDate()).padStart(2, '0');
            const month = String(saoPauloTime.getMonth() + 1).padStart(2, '0');
            const year = saoPauloTime.getFullYear();
            const hours = String(saoPauloTime.getHours()).padStart(2, '0');
            const minutes = String(saoPauloTime.getMinutes()).padStart(2, '0');
            const seconds = String(saoPauloTime.getSeconds()).padStart(2, '0');

            clock.innerText = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>
</body>

</html>