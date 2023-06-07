<?php 
namespace controller;

use view\User_View;

use model\Sql;

require_once("model/DAO.php");

class User_Controller
{

    public function __construct(string $menuop = null)
    {


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            
            return $this->create();

        }elseif($_SERVER['REQUEST_METHOD'] == "PUT"){

            return $this->update();

        }elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            
            return $this->delete();

        }elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            
            return $this->read($menuop);
        }
        
    }

   

    public function create()
    {

        $data = json_decode(file_get_contents("php://input"));


        
        if (empty(trim($data->titulo))):

            User_View::view(400, "Adicione o titulo");

        endif;


        if (empty(trim($data->descricao))):

            User_View::view(400, "Adicione a descrição");

        endif;

        $titulo = htmlspecialchars(strip_tags($data->titulo));

        $descricao = htmlspecialchars(strip_tags($data->descricao));

        
        if (count(Sql::select("SELECT titulo FROM tasks WHERE titulo = :titulo", 
        array(':titulo' => $titulo))) > 0 ) {
           
            User_View::view(400, "Tarefa similar em progresso!");

        }

        
        Sql::query("INSERT INTO tasks (titulo, descricao, status) VALUES(:titulo, :descricao, :status)", 
        array(':titulo' => $titulo, ':descricao' => $descricao, ':status' => "Aberto"));
            
        User_View::view(200, "Tarefa adicionada : " . $titulo);

    }



    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));


        
        if (empty(trim($data->titulo))):

            User_View::view(400, "Adicione o titulo");

        endif;


        if (empty(trim($data->descricao))):

            User_View::view(400, "Adicione a descrição");

        endif;

        if (empty(trim($data->status))):

            User_View::view(400, "Adicione o status");

        endif;


        $titulo = htmlspecialchars(strip_tags($data->titulo));

        $descricao = htmlspecialchars(strip_tags($data->descricao));

        $status = htmlspecialchars(strip_tags($data->status));


        
        if (count(Sql::select("SELECT titulo FROM tasks WHERE titulo = :titulo", 
        array(':titulo' => $titulo))) == 0 ) {
           
            User_View::view(400, "Adicione uma tarefa válida!");

        }

        
        Sql::query("UPDATE tasks SET titulo = :titulo, descricao = :descricao, status = :status 
        WHERE titulo = :titulo_query", 
        array(':titulo' => $titulo, ':descricao' => $descricao, ':status' => $status, 
        ':titulo_query' => $titulo));
            
        User_View::view(200, "Tarefa atualizada : " . $titulo);

    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));

        
        if (empty(trim($data->titulo))):

            User_View::view(400, "Adicione o titulo");

        endif;


        $titulo = htmlspecialchars(strip_tags($data->titulo));


        if (count(Sql::select("SELECT titulo FROM tasks WHERE titulo = :titulo", 
        array(':titulo' => $titulo))) == 0 ) {
           
            User_View::view(400, "Adicione uma tarefa válida!");

        }

        
        Sql::query("DELETE FROM tasks WHERE titulo = :titulo_query", array(':titulo_query' => $titulo));
            
        User_View::view(200, "Tarefa deletada : " . $titulo);

    }

    public function read($menuop)
    {

        $sql = !is_null($menuop) ? Sql::select("SELECT * FROM tasks WHERE titulo = :titulo", 
        array(':titulo' => $menuop)) : Sql::select("SELECT * FROM tasks");

        if (count($sql) > 0 ) {
           
            User_View::view(200, $sql);

        }else{

        User_View::view(400, "Nenhuma tarefa encontrada!");

        }
       
    }


}









?>