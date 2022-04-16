<?php

require_once "conexao.php";

class ClienteDAO extends DAO{
        
    function findAll() {

        $query="SELECT * FROM clientes order by nome";
        $response = parent::getResultSetArray($query);
        return $response;
    
    }

    function findById($id){
        $query="SELECT * FROM clientes where id = $id order by nome";
        $response = parent::getResultSetArray($query);
        return $response;
    
    }

    function insert($data) {
        
        try {
            $sql = 'INSERT INTO clientes(nome, descricao) 
                    VALUES (:nome,:descricao)';

            $stmt = $GLOBALS['conexao']->prepare($sql);
            $stmt->bindValue(':nome', $data['nome']);
            $stmt->bindValue(':descricao', $data['descricao']);
            $stmt->execute();

            App_Response::getResponse(200);
            $response = App_Response::getMessage(1);
            return $response;
        
        } catch (PDOException $e) {
            echo $e->getMessage();
            App_Response::getResponse(500);
            $response = App_Response::getMessage(2);
            return $response;
        }
        
    }

    function update($id, $data) {
        try {
            $sql = 'UPDATE clientes SET  
                    nome = :nome,
                    descricao = :descricao 
                    WHERE id = :id';

            $stmt = $GLOBALS['conexao']->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':nome', $data['nome']);
            $stmt->bindValue(':descricao', $data['descricao']);
            $stmt->execute();

            App_Response::getResponse(200);
            $response = App_Response::getMessage(3);
            return $response;
        
        } catch (PDOException $e) {
            echo $e->getMessage();
            App_Response::getResponse(500);
            $response = App_Response::getMessage(4);
            return $response;
        }
    }

    function delete($id) {
        try {
            $sql = 'DELETE FROM clientes WHERE id = :id';

            $stmt = $GLOBALS['conexao']->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            App_Response::getResponse(200);
            $response = App_Response::getMessage(5);
            return $response;
        
        } catch (PDOException $e) {
            echo $e->getMessage();
            App_Response::getResponse(500);
            $response = App_Response::getMessage(6);
            return $response;
        }
    }

}


?>