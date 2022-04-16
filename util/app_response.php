<?php 

//----------------------------------------------------------------------------------------------------------------------
class App_Response  {

    //--------------------------------------------------------------------------------------------------------------------
    public static function getResponse($varRespCode) {
      
      switch ($varRespCode) {
          
          case '200':
              $success = TRUE;
              $response = '200';
              $responseDescription = 'The request has succeeded';
              break;
          
          case '201':
              $success = TRUE;
              $response = '201';
              $responseDescription = 'Limited success. One or more batch requests failed for the command executed.';
              break;
  
          case '204':
              $success = TRUE;
              $response = '204';
              $responseDescription = 'The request was successful, but the result is empty.';
              break;
  
          case '400':
              $success = FALSE;
              $response = '400';
              $responseDescription = 'Bad Request. One or more required parameters were missing or invalid';
              break;
  
          case '401':
              $success = FALSE;
              $response = '401';
              $responseDescription = 'Forbidden. User does not exist.';
              break;
  
          case '402':
              $success = FALSE;
              $response = '402';
              $responseDescription = 'Forbidden. Authorization token does not exist.';
              break;
          
          case '403':
              $success = FALSE;
              $response = '403';
              $responseDescription = 'Forbidden. Request is missing valid credentials.';
              break;
          
              case '405':
              $success = FALSE;
              $response = '405';
              $responseDescription = 'Method not allowed. The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.';
              break;
          
          case '500':
              $success = FALSE;
              $response = '500';
              $responseDescription = 'Internal Server Error. The server encountered an unexpected condition which prevented it from fulfilling the request.';
              break;
          
          default:
              $success = TRUE;
              $response = '000';
              $responseDescription = 'Unknown application response request.';
          
          } // end switch
          
          // return array for when the API needs to return the passed params
          $returnArray = array('success' => $success, 'response' => $response, 'responseDescription' => $responseDescription);
          if ($response != '200') {
            header("HTTP/1.0 $response $responseDescription");
            self::converterJson($returnArray);
          }
          //return $returnArray;
          
      }

      public static function getPayloadJson() {
        return json_decode(file_get_contents('php://input'), true);
      }

      public static function getMessage($status) {

        switch ($status) {
            case '1':
                $response=array(
                    'status' => $status,
                    'status_message' =>'Registro incluído com sucesso.'
                );
            break;
            case '2':
                $response=array(
                    'status' => $status,
                    'status_message' =>'Erro ao incluír registro.'
                );
            break;
            case '3':
                $response=array(
                    'status' => $status,
                    'status_message' =>'Registro atualizado com sucesso.'
                );
            break;
            case '4':
                $response=array(
                    'status' => $status,
                    'status_message' =>'Erro ao atualizar registro.'
                );
            break;
            case '5':
                $response=array(
                    'status' => $status,
                    'status_message' =>'Registro excluído com sucesso.'
                );
            break;
            case '6':
                $response=array(
                    'status' => $status,
                    'status_message' =>'Erro ao excluir registro.'
                );
            break;
            case '7':
                $response=array(
                    'status' => $status,
                    'status_message' =>'Erro ao atualizar registro, não foi enviado algum campo obrigatório.'
                );
            break;
        }

        return $response;
      }

    static function converterJson($response){
        header('Content-Type: application/json');
		echo json_encode($response);
    }
    
    static function verificarRetorno($result,$tipo) {
        if ($tipo == 'all') {
            App_Response::converterJson($result['result']);
        } elseif ($tipo == 'id') {
            App_Response::converterJson($result['result'][0]);
        }else{    
            header("HTTP/1.0 204 Not Content");
        }
    }

  } // end class


?>