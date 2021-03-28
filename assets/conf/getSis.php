<?php

require 'dbaSis.php';

?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Kobu Sushi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/ico.png" type="image/x-icon">
    </head>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            width: 100%;
            padding: 2% 0;
        }
        p{
            width: 1024px;
            text-align: center; 
        }
        .true{
            background: #00FF11;
            margin: auto;
            margin: 2%;
            padding: 2% 10%;
                       
        }
        .yep{
            background: #ff0;
            margin: auto;
            margin: 2%;
            padding: 2% 10%;   
        }
        .false{
            background: #f00;
            margin: auto;
            margin: 2%;
            padding: 2% 10%;           
        }
    </style>
    <body>
        <p>
            <?php        
                /***************************
                VALIDA O EMAIL
                ***************************/

                    function valMail($email){
                        if(preg_match('/[a-z0-9_\.\-]+@[a-z09_\.\-]*[a-z09_\.\-]+\.[a-z]{2,4}$/', $email)){
                                return true;
                        }else{
                                return false;
                        }
                    }

                /***************************
                MENSAGEM
                ***************************/

                if(isset($_GET['status'])){    
                    header("Refresh: 0; url=../index.html");    
                }

                /***************************
                MAILING KOBU
                ***************************/

                if(isset($_POST['mail'])){

                    $email = $_POST['email'];
                    if(valMail($email) == true){
                        $row = mysqli_num_rows(read("kbs_mailing", "WHERE email = '$email'"));
                        if($row > 0){
                            echo "<span class='yep'>E-MAIL JÁ CADASTRADO!!</span>";
                        }else{
                            $datas = array( 'email' => $email );
                            create("kbs_mailing", $datas);
                            echo "<span class='true'>E-MAIL CADASTRADO COM SUCESSO!!</span>";
                        }        
                        header("Refresh: 5; url=getSis.php?status=true");
                    }else{
                        echo "<span class='false'>E-MAIL INVÁLIDO!!</span>";
                        header("Refresh: 5; url=getSis.php?status=false");
                    }
                }
            ?>            
        </p>
    </body>
</html>