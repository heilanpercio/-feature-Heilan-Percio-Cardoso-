<?php
header('Content-Type: text/html; charset=utf-8');
require_once dirname(dirname(__FILE__))."/lib/functions.php";
require_once dirname(dirname(__FILE__))."/config/connect.php";
?>
<?php
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

// Excluir o cliente
if (deleteCliente($id)) {
?>
    <script>alert("Cliente <?php echo $id ?> apagado Com Sucesso !");</script>
    
    <?php
    if($current_page > 1){
    ?>
        <script>window.location.href = '../../index.php?pagina=<?php echo $current_page; ?>';</script>

    <?php 
    } else {
    ?>
        <script>window.location.href = '../../index.php';</script>
    <?php 
    }
    ?>

<?php
    exit;
} else {
?>
    <script>alert("Cliente <?php echo $id ?> NÃO foi apagado! Reporte o problema para a Tecnologia2U");</script>
<?php
}
?>