<?php
header('Content-Type: text/html; charset=utf-8');
require_once dirname(dirname(__FILE__))."/lib/functions.php";
require_once dirname(dirname(__FILE__))."/config/connect.php";

// Verificar se o ID do cliente foi fornecido
/*
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
*/

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

//Pegando a pasta onde o projeto está hospedado
$pproj = explode("/",$_SERVER['PHP_SELF'])[1];

// Verificar se o formulário foi enviado
if (strsanitize(strtoupper($_SERVER['REQUEST_METHOD'])) === 'POST') {
    // Obter os dados do formulário
    $nome           = strsanitize($_POST['nome']);
    $cep            = strsanitize($_POST['cep']);
    $endereco       = strsanitize($_POST['endereco']);
    $numero         = strsanitize($_POST['numero']);
    $complemento    = strsanitize($_POST['complemento']);
    $bairro         = strsanitize($_POST['bairro']);
    $cidade         = strsanitize($_POST['cidade']);
    $estado         = strsanitize($_POST['estado']);

    // Atualizar o cliente
    if (updateCliente($id, $nome, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado)) {
?>
        <script>alert("Cliente <?php echo $nome ?> editado Com Sucesso !");</script>
<?php
    } else {
?>
        <script>alert("Cliente <?php echo $nome ?> NÃO foi modificado! Reporte o problema para a Tecnologia2U");</script>
<?php
    }
}

// Obter os detalhes do cliente
$cliente = getCliente($id);

if (!$cliente) {
    ?>
        <script>window.location.href = '../../index.php';</script>
    
    <?php
        exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="author" content="tecnologia2u">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Tecnologia2U - Cadastro de Clientes - Editar</title>
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
					<h2 style="margin-left:15px;">Cadastro de Clientes >> Editar Cliente</h2>
				</div>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id); ?>">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($cliente['nome']); ?>" onblur="capitalizeWords('nome', this.value);" required>
                    </div>
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <div class="input-group">
                            <input type="text" id="cep" name="cep" class="form-control" value="<?php echo htmlspecialchars($cliente['cep']); ?>" size="10" maxlength="9" required>
                            <div class="input-group-append">
                                <a href="javascript:pesquisacep(cep.value)" id="btnPesquisarCep" name="btnPesquisarCep" class="btn btn-primary" >Pesquisar</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" class="form-control" value="<?php echo htmlspecialchars($cliente['endereco']); ?>" onblur="capitalizeWords('endereco', this.value);" required>
                    </div>
                    <div class="form-group">
                        <label for="endereco">Numero</label>
                        <input type="text" id="numero" name="numero" class="form-control" value="<?php echo htmlspecialchars($cliente['numero']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento" class="form-control" value="<?php echo htmlspecialchars($cliente['complemento']); ?>" onblur="capitalizeWords('complemento', this.value);">
                    </div>
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" value="<?php echo htmlspecialchars($cliente['bairro']); ?>" onblur="capitalizeWords('bairro', this.value);" required>
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" class="form-control" value="<?php echo htmlspecialchars($cliente['cidade']); ?>" onblur="capitalizeWords('cidade', this.value);" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="">Selecione o estado</option>
                            <option value="AC" <?php if ($cliente['estado'] === 'AC') echo 'selected'; ?>>AC</option>
                            <option value="AL" <?php if ($cliente['estado'] === 'AL') echo 'selected'; ?>>AL</option>
                            <option value="AP" <?php if ($cliente['estado'] === 'AP') echo 'selected'; ?>>AP</option>
                            <option value="AM" <?php if ($cliente['estado'] === 'AM') echo 'selected'; ?>>AM</option>
                            <option value="BA" <?php if ($cliente['estado'] === 'BA') echo 'selected'; ?>>BA</option>
                            <option value="CE" <?php if ($cliente['estado'] === 'CE') echo 'selected'; ?>>CE</option>
                            <option value="DF" <?php if ($cliente['estado'] === 'DF') echo 'selected'; ?>>DF</option>
                            <option value="ES" <?php if ($cliente['estado'] === 'ES') echo 'selected'; ?>>ES</option>
                            <option value="GO" <?php if ($cliente['estado'] === 'GO') echo 'selected'; ?>>GO</option>
                            <option value="MA" <?php if ($cliente['estado'] === 'MA') echo 'selected'; ?>>MA</option>
                            <option value="MT" <?php if ($cliente['estado'] === 'MT') echo 'selected'; ?>>MT</option>
                            <option value="MS" <?php if ($cliente['estado'] === 'MS') echo 'selected'; ?>>MS</option>
                            <option value="MG" <?php if ($cliente['estado'] === 'MG') echo 'selected'; ?>>MG</option>
                            <option value="PA" <?php if ($cliente['estado'] === 'PA') echo 'selected'; ?>>PA</option>
                            <option value="PB" <?php if ($cliente['estado'] === 'PB') echo 'selected'; ?>>PB</option>
                            <option value="PR" <?php if ($cliente['estado'] === 'PR') echo 'selected'; ?>>PR</option>
                            <option value="PE" <?php if ($cliente['estado'] === 'PE') echo 'selected'; ?>>PE</option>
                            <option value="PI" <?php if ($cliente['estado'] === 'PI') echo 'selected'; ?>>PI</option>
                            <option value="RJ" <?php if ($cliente['estado'] === 'RJ') echo 'selected'; ?>>RJ</option>
                            <option value="RN" <?php if ($cliente['estado'] === 'RN') echo 'selected'; ?>>RN</option>
                            <option value="RS" <?php if ($cliente['estado'] === 'RS') echo 'selected'; ?>>RS</option>
                            <option value="RO" <?php if ($cliente['estado'] === 'RO') echo 'selected'; ?>>RO</option>
                            <option value="RR" <?php if ($cliente['estado'] === 'RR') echo 'selected'; ?>>RR</option>
                            <option value="SC" <?php if ($cliente['estado'] === 'SC') echo 'selected'; ?>>SC</option>
                            <option value="SP" <?php if ($cliente['estado'] === 'SP') echo 'selected'; ?>>SP</option>
                            <option value="SE" <?php if ($cliente['estado'] === 'SE') echo 'selected'; ?>>SE</option>
                            <option value="TO" <?php if ($cliente['estado'] === 'TO') echo 'selected'; ?>>TO</option>
                        </select>
                    </div>

                    <div class="containerbutton">
                        <div style="padding-left:15px;">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                            <?php
                            if($current_page > 1){
                            ?>
                                <a class="btn btn-secondary" onclick="voltarPagina(<?php echo $current_page; ?>)">Voltar a Tela Principal</a>

                            <?php 
                            } else {
                            ?>
                                <a href="../../index.php" class="btn btn-secondary">Voltar a Tela Principal</a>
                            <?php 
                            }
                            ?>
                        </div>
                    </div>

<!--
                    <div class="containerbutton">
                        <div style="padding-left:15px;">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <a href="../../index.php" class="btn btn-secondary">Voltar a Tela Principal</a>
                        </div>
                    </div>
                        -->                    
                </form>
            </div>
        </div>

        <!-- JS BOOTSTRAP 4.6.2 -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script src="../../scripts/js/cep.js"></script>
        <script src="../../scripts/js/script.js"></script>


    </body>
</html>
