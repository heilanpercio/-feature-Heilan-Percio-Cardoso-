<?php
header('Content-Type: text/html; charset=utf-8');
require_once dirname(dirname(__FILE__))."/lib/functions.php";
require_once dirname(dirname(__FILE__))."/config/connect.php";

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
    
    // Verificar se o cliente já existe
    if (checkClienteExists($nome)) {
        ?>
        <script>alert("Cliente <?php echo $nome ?> já está cadastrado!");</script>
        <?php
    } else {
        // Adicionar o cliente
        if (addCliente($nome, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado)) {
            ?>
            <script>alert("Cliente <?php echo $nome ?> criado com sucesso!");</script>
            <?php
        } else {
            ?>
            <script>alert("Não foi possível criar o cliente <?php echo $nome ?>. Por favor, contate a Tecnologia2U.");</script>
            <?php
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
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
					<h2 style="margin-left:15px;">Cadastro de Clientes >> Adicionar Cliente</h2>
				</div>
                <form id="form-create" method="POST" action="<?php echo strsanitize($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" size="255" class="form-control" onblur="capitalizeWords('nome', this.value);" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <div class="input-group">
                            <input type="text" id="cep" name="cep" class="form-control" value="" size="10" maxlength="9" required>
                            <div class="input-group-append">
                                <a href="javascript:pesquisacep(cep.value)" id="btnPesquisarCep" name="btnPesquisarCep" class="btn btn-primary" >Pesquisar</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" size="255" class="form-control" onblur="capitalizeWords('endereco', this.value);" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="numero">Numero</label>
                        <input type="text" id="numero" name="numero" size="8" class="form-control" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento" size="255" class="form-control" onblur="capitalizeWords('complemento', this.value);" disabled>
                    </div>
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" size="60" class="form-control" onblur="capitalizeWords('bairro', this.value);" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" size="60" class="form-control" onblur="capitalizeWords('cidade', this.value);" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" disabled required>
                            <option value="">Selecione o estado</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                            <option value="AM">AM</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PR">PR</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="SC">SC</option>
                            <option value="SP">SP</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>

                    <div class="containerbutton">
                        <div style="padding-left:15px;">
                            <button id="btnCriar" name="btnCriar" type="submit" class="btn btn-primary" disabled>Adicionar</button>
                            <a href="../../index.php" class="btn btn-secondary">Voltar a Tela Principal</a>
                        </div>
                    </div>                        
                </form>
            </div>
        </div>

        <!-- JS BOOTSTRAP 4.6.2 -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script src="../../scripts/js/cep.js"></script>
		
    </body>
</html>
