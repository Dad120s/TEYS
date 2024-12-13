<?php
if (isset($_POST["submit"])) {
    $dbHost= "Localhost";
$dbUsername= "root";
$dbPassword= "";
$dbName="cadastro_db";

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//if($conexao->connect_error){
//    echo"Erro";
//} else {
//    echo "COnectado";
//}


    // Supondo que você tenha uma conexão válida em $conexao
    // Obtém o próximo ID da tabela textos_talk
    $result = $conexao->query("SELECT MAX(id) as max_id FROM textos_talk");
    $row = $result->fetch_assoc();
    
    // Verifica se max_id foi retornado e define o ID
    $id = isset($row['max_id']) ? $row['max_id'] + 1 : 1; // Se não houver registros, começa com 1
    $texto = $_POST["texto"];

    // Agora, você pode executar a inserção
    $query = "INSERT INTO textos_talk(id, texto) VALUES('$id', '$texto')";
    if ($conexao->query($query) === TRUE) {
    } else {
        echo "Erro: " . $query . "<br>" . $conexao->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="shortcut icon" href="/teys/img/tays2.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEYS</title>
    <style>
        /* Reset básico */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container-top {
            background-color: black;
            color: white;
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
            position: relative;
        }

        .container-logo {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .container-logo>a {
            font-size: 30px;
            text-decoration: none;
            color: #fff;
        }

        .botao-sanduiche {
            border: none;
            background-color: #444;
            color: white;
            font-size: 20px;
            cursor: pointer;
            border-radius: 5px;
            padding: 5px 10px;
            margin-top: 10px;
            display: block;
            align-self: flex-start;
        }

        .botao-sanduiche:hover {
            background-color: #666;
        }

        .menu-mobile {
            display: none;
            flex-direction: column;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 10px;
            position: absolute;
            top: 60px;
            left: 10px;
            margin-left: 40px;
            z-index: 1000;
        }

        .menu-mobile.active {
            display: flex;
        }

        .menu-mobile a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
        }

        .menu-mobile a:hover {
            background-color: #f0f0f0;
        }

        .menu-desktop {
            display: none;
            flex-direction: row;
            gap: 20px;
            margin-top: 10px;
        }

        .menu-desktop a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
        }

        .menu-desktop a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .container-login-cadastrar {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }

        .container-login-cadastrar button {
            background-color: #444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .container-login-cadastrar button:hover {
            background-color: #666;
        }

        .container-search-bar {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .container-search-bar .search {
            border-radius: 10px;
            padding: 5px;
            border: 1px solid #ccc;
        }

        /* Responsividade */
        @media (min-width: 768px) {
            .botao-sanduiche {
                display: none;
            }

            .menu-mobile {
                display: none;
            }

            .menu-desktop {
                display: flex;
            }
        }

        .conatainer-total-talks {
            margin-top: 10px;
            width: 100%;
            height: 1000px;
            background-color: black;
            padding-top: 10px;
        }

        .container-faca-um-talk {
            width: 90%;
            margin-top: 6px;
            margin-left: 20px;
            padding-bottom: 25px;
            vertical-align: bottom;
            height: 220px;
            text-align: center;
            color: white;
            display: flex;
            border-radius: 20px;
            justify-content: center;
            align-items: center;
            background-color: #444;
        }

        .digite-seu-talk textarea.escreva-seu-talk {
            border-radius: 10px;
            margin-top: 38px;
            background-color: #333;
            margin-left: 0px;
            text-align: left;
            vertical-align: top;
            height: 175px;
            width: 285px;
            color: white;
            padding: 10px;
            border: none;
            resize: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
            overflow-wrap: break-word;
            word-break: break-word;
            outline: none;
        }

        .digite-seu-talk textarea.escreva-seu-talk::placeholder {
            color: #aaa;
            text-align: left;
        }

        .publicar {
            border-radius: 10px;
            width: 100px;
            margin-top: 8px;
            margin-bottom: 5px;
            margin-left: 200px;
        }
        .container-talks-publicados{
            margin-top: -700px;
        }
    </style>
</head>

<body>
    <div class="container-top">
        <!-- Logo -->
        <div class="container-logo">
            <a href="/teys/index.php">TEYS</a>
            <!-- Menu sanduíche (mobile) -->
            <button type="button" class="botao-sanduiche" id="botao-sanduiche">
                &#9776;
            </button>
            <div class="menu-mobile" id="menu-mobile">
                <a href="/teys/menus/talks.php">Talks</a>
                <a href="/teys/menus/noticias.php">Notícias</a>
                <a href="/teys/menus/videos.php">Vídeos</a>
                <a href="/teys/menus/influenciadores.php">Influenciadores</a>
            </div>

            <!-- Menu horizontal (desktop) -->
            <div class="menu-desktop">
                <a href="/teys/menus/talks.php">Talks</a>
                <a href="/teys/menus/noticias.php">Notícias</a>
                <a href="/teys/menus/videos.php">Vídeos</a>
                <a href="/teys/menus/influenciadores.php">Influenciadores</a>
            </div>
        </div>

        <!-- Botões de login e cadastro -->
        <div class="container-login-cadastrar">
            <button type="button" id="login">Login</button>
            <button type="button" id="cadastrar">Cadastre-se</button>
        </div>

        <!-- Área de pesquisa -->
        <div class="container-search-bar">
            <input type="text" class="search" id="search" placeholder="Pesquise aqui...">
        </div>
    </div>

    <div class="content"></div>

    <section>
        <div class="conatainer-total-talks">
            <div class="container-faca-um-talk">
                <form method="POST" action="">
                    <div class="digite-seu-talk">
                        <textarea id="escreva-seu-talk" class="escreva-seu-talk" placeholder="Escreva seu talk aqui..." name="texto"></textarea>
                        <button type="submit" name="submit" class="publicar">Publicar</button>
                </form>
            </div>
            </form>
        </div>
        </div>
    </section>
    <section>
        <div class="container-content-talks-publicados">
            <div class="container-talks-publicados">
                <?php 
                    include_once('C:/xampp/htdocs/TEYS/aplis/apli-talk-publicado.php');
                ?>
            </div>
        </div>
    </section>

    <script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
        const botaoSanduiche = document.getElementById('botao-sanduiche');
        const menuMobile = document.getElementById('menu-mobile');

        // Adiciona evento de clique para o menu sanduíche
        botaoSanduiche.addEventListener('click', () => {
            menuMobile.classList.toggle('active');
        });
    </script>
</body>

</html>