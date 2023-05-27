<?php
header('Content-Type: text/html; charset=utf-8');
require_once dirname(dirname(__FILE__))."/lib/functions.php";
require_once dirname(dirname(__FILE__))."/config/connect.php";

// Verifica se a variável pesquisa foi enviada
if(isset($_POST['pesquisa'])) {
    // Obtém a string de pesquisa digitada pelo usuário
    $pesquisa = strsanitize($_POST['pesquisa']);

    // Função para buscar clientes com base na string de pesquisa
    $clientes = searchClientes($pesquisa);

    // Verifica se há resultados de clientes encontrados
    if ($clientes) {
        foreach ($clientes as $cliente) {
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
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="4">Nenhum resultado encontrado.</td>
        </tr>
        <?php
    }
}
?>
