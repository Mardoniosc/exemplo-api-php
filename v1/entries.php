<?php

require_once ("../util/app_response.php");
require_once ("../util/cors.php");
require_once ("../dao/conexao.php");
require_once ("../dao/entries_dao.php");

cors();

$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method){
    case 'GET':
        if (!empty($_GET["id"])){
            $id=intval($_GET["id"]);
            $dao = new EntryDAO();
            $result = $dao->findById($id);
            App_Response::verificarRetorno($result,"id");
        }else{
            $dao = new EntryDAO();
            $result = $dao->findAll();
            App_Response::verificarRetorno($result,"all");
        }
    break;
    case 'POST':
        $data = App_Response::getPayloadJson();
        $dao = new EntryDAO();
        $result = $dao->insert($data);
        App_Response::converterJson($result);
    break;
    case 'PUT':
        if(!empty($_REQUEST["id"])){
            $id=intval($_REQUEST["id"]);
            $data = App_Response::getPayloadJson();
            $dao = new EntryDAO();
            $result = $dao->update($id,$data);
            App_Response::converterJson($result);
        }else{
            App_Response::getResponse(400); 
        }
    break;
    case 'DELETE':
        if(!empty($_REQUEST["id"])){
            $id=intval($_REQUEST["id"]);
            $dao = new EntryDAO();
            $result = $dao->delete($id);
            App_Response::converterJson($result);
        }else{
            App_Response::getResponse(400); 
        }
    break;   

    default:
    // Invalid Request Method
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

?>