<?php 

namespace view;


class User_View
{



    public static function view(int $error,  $message)
    {
        
        http_response_code($error);
        echo json_encode([ 

            'sucesso' => 1,
            'mensagem' => $message
            
        ]);
        exit;


    }


    public static function fail(int $error, string $message)
    {
        
        http_response_code($error);
        echo json_encode(

            [
        
                'mensagem' => $message
            
            ]

        );
        exit;

    }
    

}









?>