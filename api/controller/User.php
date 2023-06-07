<?php 
namespace view;


require_once("api/model/DAO.php");
require_once("api/controller/Ctrl.php");

use model\Sql;
use controller\Ctrl;

class User
{

    public function __construct(string $opt, string $db){

            switch ($opt) {

                case 'cadastro':

                    return $this->create($db);

                break;
                        
                default:

                    http_response_code(403);
                    echo json_encode([
                        'Sucesso' => 0,
                        'Mensagem' => 'Operação inválida!'
                        ]);
                    exit;

                            
                break;

            }
        
    }


    public function create(string $db)
    {

        $data = json_decode(file_get_contents("php://input"));


        if (empty(trim($data->user))):
          http_response_code(400);
          echo json_encode(['sucesso' => 0, 'mensagem' => 'Adicione o usuário!']);
          
            exit;
        endif;
    
        if (empty(trim($data->senha))):
            http_response_code(400);
            echo json_encode(['sucesso' => 0, 'mensagem' => 'Adicione a senha!']);
            exit;
        endif;

        if (!isset($data->rSenha) || empty(trim($data->rSenha))) : // validação da senha

            echo json_encode([
                'sucesso' => 0,
                'mensagem' => 'Por favor, confirme sua senha.',
            ]);
            exit;
        endif;

        if (empty(trim($data->perms))):
            http_response_code(400);
            echo json_encode(['sucesso' => 0, 'mensagem' => 'Adicione as permissões do usuário!']);
            exit;
        endif;


        $user = htmlspecialchars(strip_tags($data->user));
        $senha = htmlspecialchars(strip_tags($data->senha));
        $rSenha = htmlspecialchars(strip_tags($data->rSenha));
        $perms =  htmlspecialchars(strip_tags($data->perms));

    
        if($senha == $rSenha){

            $sql = Sql::select("SELECT user FROM `user` WHERE user = :user", $db, array(':user' => 
            $user));

            if (count($sql) > 0) {

                http_response_code(403);
                echo json_encode([
                    'sucesso' => 1,
                    'mensagem' => ' Usuário já cadastrado, Por favor utilize outro!'
                ]);
                exit;
                
            }

            $log = Ctrl::Token_call($user);


            Sql::query("INSERT INTO `user` (user, password, id_log) VALUES(:user, :password, :id_log)", $db, 
            array(':user' => $user, ':password' => password_hash($senha, PASSWORD_DEFAULT), ':id_log' => $log));
                  
                Perm::User_Perm($user, $db, $perms);
                
                http_response_code(200);
                echo json_encode([ 
                    'sucesso' => 1,
                    'mensagem' => 'Usuário .: ' . $user. ' Cadastrado com sucesso!'
                ]);
                exit;
            

        }else{

            http_response_code(400);
            //mensagem de erro
            echo json_encode([ 
                'sucesso' => 0,
                'mensagem' => 'Senhas não Correspondem! Por favor tente novamente.'
            ]);
            exit;
        }
        
    }

    public function update(string $db)
    {
        $data = json_decode(file_get_contents("php://input"));
    }


}









?>