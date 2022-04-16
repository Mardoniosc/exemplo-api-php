<?php

require_once "conexao.php";

class EntryDAO extends DAO{
        
    function findAll() {

        $query="SELECT * FROM entries order by name";
        $response = parent::getResultSetArray($query);
        return $response;
    
    }

    function findById($id){
        $query="SELECT * FROM entries where id = $id order by name";
        $response = parent::getResultSetArray($query);
        return $response;
    
    }

    function insert($data) {
        
        try {
            $sql = "INSERT INTO public.entries
                    (name, description, type, amount, date, paid, category_id)
                    VALUES(:name, :description, :type, :amount, :date, :paid, :category_id)";

            $stmt = $GLOBALS['conexao']->prepare($sql);
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':description', $data['description']);
            $stmt->bindValue(':type', $data['type']);
            $stmt->bindValue(':amount', $data['amount']);
            $stmt->bindValue(':date', $data['date']);
            $stmt->bindValue(':paid', $data['paid'] ? "true" : "false");
            $stmt->bindValue(':category_id', $data['category_id']);
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
            $sql = 'UPDATE entries SET  
                    name = :name,
                    description = :description, 
                    type = :type, 
                    amount = :amount, 
                    date = :date,
                    paid = :paid,
                    category_id = :category_id 
                    WHERE id = :id';

            $stmt = $GLOBALS['conexao']->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':description', $data['description']);
            $stmt->bindValue(':type', $data['type']);
            $stmt->bindValue(':amount', $data['amount']);
            $stmt->bindValue(':date', $data['date']);
            $stmt->bindValue(':paid', $data['paid'] ? "true" : "false");
            $stmt->bindValue(':category_id', $data['category_id']);
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
            $sql = 'DELETE FROM entries WHERE id = :id';

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