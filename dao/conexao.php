<?php 

require_once ("config.php");

abstract Class DAO{

    function __construct() {
        $this::conectar();
    }

    function __destruct() {
        $GLOBALS['conexao'] = null;
    }

    static function conectar() {
        
        $host = HOST_DB;
        $port = PORT;
        $dbname = DBNAME;
        $user = USER_DB;
        $password = PASSWORD_DB;

        try {
            
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
            // criando nova conexão
            $conexaoPDO = new PDO($dsn);

            // verifica se a conexão foi estabelecida
            if ($conexaoPDO) {
                $GLOBALS['conexao'] = $conexaoPDO;
                //echo "Conexão com o banco <strong>$dbname</strong> estabelecida com sucesso!";
            } else {
                echo "Erro ao conectar";
                return null;
            }
        } catch (PDOException $e) {
                // reporta as mensagens de erro
                echo $e->getMessage();
        }
    }

	static function getResultSetArray($varQuery) {

        $stm = $GLOBALS['conexao']->prepare($varQuery);
        $stm->execute();

		if ($GLOBALS['conexao']->errorCode() && $GLOBALS['conexao']->errorCode() != 0) {
			// if an error occurred, raise it.
			$responseArray = App_Response::getResponse('500');
			$responseArray['message'] = 'Internal server error. DB error: ' . $GLOBALS['conexao']->errno . ' ' . $GLOBALS['conexao']->error;
		} else {       
            // success
			$rowCount = $stm->rowCount();
			
			if ($rowCount != 0) {
				// move result set to an associative array
                $rsArray = $stm->fetchAll(PDO::FETCH_ASSOC);
			
				// add array to return
				$responseArray = App_Response::getResponse('200');
				$responseArray['result'] = $rsArray;
			
			} else {
				// no data returned
				$responseArray = App_Response::getResponse('204');
                $responseArray['message'] = 'Query did not return any results.';
			}
			
		}

		return $responseArray;
		
	}

}
?>