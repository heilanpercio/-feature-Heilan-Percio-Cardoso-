<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__."/app/config/config.php";
require_once __DIR__."/app/lib/functions.php";
require_once __DIR__."/app/config/connect.php";

// Parâmetros para a paginação
$limit = 10; // Quantidade de registros por página
$page = isset($_GET['pagina']) ? $_GET['pagina'] : 1; // Página atual (parâmetro na URL)

// Sanitizar a variável página
$page = strsanitize($page);

// Função para obter a quantidade total de clientes
$totalClientes = getTotalClientes();

// Cálculo do total de páginas
$totalPages = ceil($totalClientes / $limit);

// Verificação se a página atual é válida
if ($page < 1 || $page > $totalPages) {
    $page = 1;
}

// Cálculo do offset (registro inicial da página)
$offset = ($page - 1) * $limit;

// Variáveis de pesquisa
$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

// Sanitizar a variável de pesquisa
$pesquisa = strsanitize($pesquisa);

// Função para obter os clientes com paginação e pesquisa
$clientes = getClientesWithPaginationAndSearch($offset, $limit, $pesquisa);

//Pegando a pasta onde o projeto está hospedado
$pproj = explode("/",$_SERVER['PHP_SELF'])[1];

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="author" content="tecnologia2u">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Tecnologia2U - Cadastro de Clientes</title>
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
					<h2 style="margin-left:15px;">Cadastro de Clientes</h2>
				</div>
                <div class="divbotaocriar">
				    <a href="app/views/criar.php" class="btn btn-primary mb-3">Novo Cliente</a>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="pesquisa" name="pesquisa" placeholder="Pesquisar" value="<?php echo $pesquisa; ?>" onkeyup="searchClientes(this.value)">
                </div>    
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>CEP</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody id="tabela-clientes">
						<?php 
							
							foreach ($clientes as $cliente){
						?>
							<tr>
								<td><?php echo strsanitize($cliente['id']); ?></td>
								<td><?php echo strsanitize($cliente['nome']); ?></td>
								<td><?php echo strsanitize($cliente['cep']); ?></td>
								<td>
									<a href="app/views/visualizar.php?id=<?php echo strsanitize($cliente['id']); ?>&pagina=<?php echo strsanitize($page); ?>" class="btn btn-info btn-sm">Visualizar</a>
									<a href="app/views/editar.php?id=<?php echo strsanitize($cliente['id']); ?>&pagina=<?php echo strsanitize($page); ?>" class="btn btn-warning btn-sm">Editar</a>
									<a href="app/views/deletar.php?id=<?php echo strsanitize($cliente['id']); ?>&pagina=<?php echo strsanitize($page); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esse cliente?')">Excluir</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
            <!-- Paginação -->
            <div class="containerpag">
                <nav class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=1&pesquisa=<?php echo $pesquisa; ?>">Primeira</a>
                        </li>
                        <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $page - 1; ?>&pesquisa=<?php echo $pesquisa; ?>">Anterior</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>&pesquisa=<?php echo $pesquisa; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php echo ($page == $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $page + 1; ?>&pesquisa=<?php echo $pesquisa; ?>">Próxima</a>
                        </li>
                        <li class="page-item <?php echo ($page == $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $totalPages; ?>&pesquisa=<?php echo $pesquisa; ?>">Última</a>
                        </li>
                    </ul>
                </nav>
            </div>
		</div>
   		<!-- JS BOOTSTRAP 4.6.2 -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            // Função para realizar a busca de clientes sem recarregar a página
            function searchClientes(pesquisa) {
                jQuery.ajax({
                    url: 'app/views/buscar.php',
                    method: 'POST',
                    data: { pesquisa: pesquisa },
                    success: function(data) {
                        $('#tabela-clientes').html(data);
                    }
                });
            }
        </script>
    </body>
</html>
