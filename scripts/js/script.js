function voltarPagina(pagina) {
    var url = "../../index.php?pagina=" + encodeURIComponent(pagina);
    window.location.href = url;
}
