<?php
	require 'dbaSis.php';
	
	$mailing = array(
		'email' => 'teste@teste.com.br',
		'ativo' => 1	
	);
	
	$reserva = array(
		'nome_cliente' => 'Testando de Teste',
		'email' => 'teste@teste.com.br',
		'telefone' => '11987654321',
		'data_solicitacao' => '2016-03-22 12:36:00',
		'data_reserva' => '2016-03-25 20:00:00',
		'ativo' => 1
	
	);
	/* executar quando o inserir email no mailing */
	//create("kbs_mailing", $mailing);
//	create("bbs_reverva", $reserva);
        echo mysqli_num_rows(read("kbs_mailing", "WHERE email = 'teste@teste.com.br'"));
?>