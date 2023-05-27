<?php
require_once dirname(dirname(__FILE__))."/config/config.php";
require_once dirname(dirname(__FILE__))."/lib/functions.php";


// Configurações de conexão com o banco de dados
$servername = DB_HOST;
$username   = DB_USERNAME;
$password   = DB_PASSWORD;
$dbname     = DB_NAME;

try {

    // Criação da conexão PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configuração do modo de erro do PDO para exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configuração do modo de suporte a prepareStatement do PDO
    //$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // Configuração do modo de suporte a UTF-8 do PDO
    //$conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8mb4');
    
    // Função para obter todos os clientes
    function getAllClientes() {
        global $conn;
        $sql = "SELECT * FROM clientes";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Função para obter um cliente pelo ID
    function getCliente($id) {
        global $conn;
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Função para adicionar um cliente
    function addCliente($nome, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado) {
        global $conn;
        $sql = "INSERT INTO clientes (nome, cep, endereco, numero, complemento, bairro, cidade, estado) VALUES (:nome, :cep, :endereco, :numero, :complemento, :bairro, :cidade, :estado)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':complemento', $complemento);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }
    
    // Função para atualizar um cliente
    function updateCliente($id, $nome, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado) {
        global $conn;
        $sql = "UPDATE clientes SET nome = :nome, cep = :cep, endereco = :endereco, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':complemento', $complemento);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Função para excluir um cliente
    function deleteCliente($id) {
        global $conn;
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Função para obter a quantidade total de clientes
    function getTotalClientes() {
        global $conn;
        $sql = "SELECT COUNT(*) as total FROM clientes";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Função para obter os clientes com paginação
    function getClientesWithPagination($offset, $limit) {
        global $conn;
        $sql = "SELECT * FROM clientes LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	/**
	 * Busca clientes com base na string de pesquisa.
	 *
	 * @param string $pesquisa String de pesquisa.
	 * @return array|false Array contendo os clientes encontrados ou false se não houver resultados.
	 */
	function searchClientes($pesquisa)
	{
		global $conn;

		try {
			$stmt = $conn->prepare("SELECT * FROM clientes WHERE id LIKE :pesquisa OR nome LIKE :pesquisa OR cep LIKE :pesquisa OR cidade LIKE :pesquisa OR estado LIKE :pesquisa");
			$stmt->bindValue(':pesquisa', '%' . $pesquisa . '%');
			$stmt->execute();

			$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $clientes;
		} catch (PDOException $e) {
			echo "Erro na busca de clientes: " . $e->getMessage();
			return false;
		}
	}
	
	/**
	 * Obtém os clientes com paginação e busca.
	 *
	 * @param int $offset Registro inicial da página.
	 * @param int $limit Quantidade de registros por página.
	 * @param string $pesquisa String de pesquisa.
	 * @return array Array contendo os clientes encontrados.
	 */
	function getClientesWithPaginationAndSearch($offset, $limit, $pesquisa)
	{
		global $conn;

		try {
			$stmt = $conn->prepare("SELECT * FROM clientes WHERE id LIKE :pesquisa OR nome LIKE :pesquisa OR cep LIKE :pesquisa OR cidade LIKE :pesquisa OR estado LIKE :pesquisa LIMIT :offset, :limit");
			$stmt->bindValue(':pesquisa', '%' . $pesquisa . '%');
			$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
			$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
			$stmt->execute();

			$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $clientes;
		} catch (PDOException $e) {
			echo "Erro ao obter clientes: " . $e->getMessage();
			return [];
		}
	}
	
	/**
	 * Verifica se o cliente já existe no banco de dados.
	 *
	 * @param string $nome Nome do cliente.
	 * @return bool Retorna true se o cliente já existe, caso contrário, retorna false.
	 */
	function checkClienteExists($nome)
	{
		global $conn;

		try {
			$stmt = $conn->prepare("SELECT COUNT(*) FROM clientes WHERE nome = :nome");
			$stmt->bindValue(':nome', $nome);
			$stmt->execute();

			$count = $stmt->fetchColumn();

			return $count > 0;
		} catch (PDOException $e) {
			echo "Erro ao verificar cliente: " . $e->getMessage();
			return false;
		}
	}
	
	


} catch(PDOException $e) {
    // Tratamento de erros na conexão com o banco de dados

    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit();
}
?>
