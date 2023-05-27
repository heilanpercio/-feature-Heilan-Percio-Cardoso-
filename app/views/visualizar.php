<?php
header('Content-Type: text/html; charset=utf-8');
require_once dirname(dirname(__FILE__))."/lib/functions.php";
require_once dirname(dirname(__FILE__))."/config/connect.php";

// Verificar se o ID do cliente foi fornecido
if (!isset($_GET['id'])) {
?>
    <script>window.location.href = '../../index.php';</script>

<?php
    exit;
}

if (isset($_GET['pagina'])) {
    // Obtém o valor atual do parâmetro "pagina"
    $current_page = strsanitize($_GET['pagina']);
} else {
    $current_page = 1;
}

$id = strsanitize($_GET['id']);
    
// Obtém os dados do cliente com o ID fornecido
$cliente = getCliente($id);

//Pegando a pasta onde o projeto está hospedado
$pproj = explode("/",$_SERVER['PHP_SELF'])[1];

// Verifica se o cliente foi encontrado
if ($cliente) {
?>
    <!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="author" content="tecnologia2u">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Tecnologia2U - Cadastro de Clientes - Adicionar</title>
            <!-- LINKS -->
            <!-- BOOTSTRAP 4.6.2 -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
            <!-- CSS da Aplicação -->
            <link rel="stylesheet" href="/<?php echo $pproj ?>/scripts/css/tec2u.css">
            <!--
            <script>
                function voltarPagina(pagina) {
                    var url = "../../index.php?pagina=" + encodeURIComponent(pagina);
                    window.location.href = url;
                }
            </script>
            -->

        </head>
    
        <body class="azul2uu">
            
            <div class="container">
                <nav class="navbar fixed-top navbar-dark azul2u">
                    <a class="navbar-brand" href="https://tecnologia2u.com.br/">
                        <img src="/<?php echo $pproj ?>/img/Logo-2u-transparente-3.png" width="100" height="80" alt="">
                    </a>
                </nav>
            </div>

            <div class="container-fluid navspace">
                <div class="container mt-4 branco containercrud">

                    <div class="titulotela">
                        <h2 style="margin-left:15px;">Cadastro de Clientes >> Visualizar Cliente</h2>
                    </div>

                    <table class="table">
                        <tr>
                            <th>ID:</th>
                            <td><?php echo strsanitize($cliente['id']); ?></td>
                        </tr>
                        <tr>
                            <th>Nome:</th>
                            <td><?php echo strsanitize($cliente['nome']); ?></td>
                        </tr>
                        <tr>
                            <th>CEP:</th>
                            <td><?php echo strsanitize($cliente['cep']); ?></td>
                        </tr>
                        <tr>
                            <th>Endereço:</th>
                            <td><?php echo strsanitize($cliente['endereco']); ?></td>
                        </tr>
                        <tr>
                            <th>Número:</th>
                            <td><?php echo strsanitize($cliente['numero']); ?></td>
                        </tr>
                        <tr>
                            <th>Complemento:</th>
                            <td><?php echo strsanitize($cliente['complemento']); ?></td>
                        </tr>
                        <tr>
                            <th>Bairro:</th>
                            <td><?php echo strsanitize($cliente['bairro']); ?></td>
                        </tr>
                        <tr>
                            <th>Cidade:</th>
                            <td><?php echo strsanitize($cliente['cidade']); ?></td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td><?php echo strsanitize($cliente['estado']); ?></td>
                        </tr>
                    </table>
                    <div class="containerbutton">
                        <div style="padding-left:15px;">
                            <?php
                            if($current_page > 1){
                            ?>

                                <a class="btn btn-secondary" onclick="voltarPagina(<?php echo $current_page; ?>)">Voltar a Tela Principal</a>

                            <?php 
                            } else {
                            ?>
                                <a href="../../index.php" class="btn btn-primary">Voltar a Tela Principal</a>
                            <?php 
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../../scripts/js/script.js"></script>
        </body>
    </html>
<?php
} else {
?>
    <script>window.location.href = '../../index.php';</script>
    <?php
    exit;
}
?>
