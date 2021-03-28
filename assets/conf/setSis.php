<?php
/***************************
FUNÇÃO INSERE BASE PRINCIPAL
***************************/
    function setHome(){
        define('BASE', 'http://localhost/e-commerce/');
        echo BASE;
    }
/***************************
FUNÇÃO CADASTRO DE MESA NA CONTA
***************************/
	if(isset($_POST['venda'])){
	    createVenda('venda');
	    $lastVenda = lastVenda('venda');
	    /*$lastId = mysqli_fetch_assoc($lastVenda);*/
	    header("Refresh: 0; url=index.php?compra=$lastId");
	}
/***************************
FUNÇÃO CANCELAR TODO PEDIDO
***************************/
function cancelaPedido(){
    unset($_SESSION['carrinho']);
    header("Location: index.php");
}
?>