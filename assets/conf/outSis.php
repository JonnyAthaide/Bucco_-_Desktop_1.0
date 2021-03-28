<?php

/***************************
FUNÇÃO GERA RESUMOS
***************************/

	function lmWord($string, $words = '100'){
		$string = strip_tags($string);
		$count = strlen($string);
		
		if($count <= $words){
			return $string;
			}else{
				$strpos = strrpos(substr($string, 0, $words), ' ');
				return substr($string, 0, $strpos).'...';
				}
		
		}

/***************************
FUNÇÃO VALIDA CPF
***************************/

	function valCPF($cpf){
	
		//remove os caracteres -> expressao regular, substituir por, de onde)
		$cpf = preg_replace('/[^0-9]/','',$cpf);	
		$digitoA = 0;
		$digitoB = 0;	
		
		// DIGITO A
		for( $i = 0, $x = 10; $i <= 8; $i++, $x--){
			$cpf[$i]. 'x' .$x. ' = ';
			$digitoA += $cpf[$i]*$x;
			'<br/>';
			}
			
		// DIGITO B
		for( $i = 0, $x = 11; $i <= 9; $i++, $x--){			
			if(str_repeat($i, 11) == $cpf){
				return false;
				}			
			$digitoB += $cpf[$i]*$x;		
			}
		$somaA = (($digitoA%11) < 2 ? 0 : 11-($digitoA%11));
		$somaB = (($digitoB%11) < 2 ? 0 : 11-($digitoB%11));
		
		if($somaA != $cpf[9] || $somaB != $cpf[10]){
			return false;
			}else{
				return true;
				}
	}


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
FORMATA DATA EM TIMESTAMP
***************************/

	function formDate($data){
		$timestamp 	=	explode(" ", $data);
		$getData	=	$timestamp[0];
		@$getTime	=	$timestamp[1];
			$setData	=	explode('/', $getData);
			$dia 		=	$setData[0];
			$mes 		=	$setData[1];
			$ano 		=	$setData[2];

		if(!$getTime):
			$getTime = date('H:i:s');
		endif;
		$resultado	=	$ano.'-'.$mes.'-'.$dia.' '.$getTime;
		return $resultado;
	}


/***************************
ESTATITICA ONLINE
***************************/

	function viewManager($times = 600){ //$times = 60*10(SEGUNDOS * MINUTOS)
		$selMes	=	date('m');
		$selAno	=	date('Y');
		if(empty($_SESSION['startView']['sessao'])){
			$_SESSION['startView']['sessao'] 	= session_id();
			$_SESSION['startView']['ip'] 		= $_SERVER['REMOTE_ADDR'];
			$_SESSION['startView']['url'] 		= $_SERVER['PHP_SELF'];
			$_SESSION['startView']['time_end'] 	= time() + $times;
			create('views_online', $_SESSION['startView']);

			//CONTADOR DE VISITAS E VISITANTES
			$readViews 	=	read('views', "WHERE mes = '$selMes' AND ano = '$selAno'");
			if(!mysqli_num_rows($readViews)){
				$createViews = array('mes' => $selMes, 'ano' => $selAno);
				create('views', $createViews);
			}else{
				foreach ($readViews as $views);
				if(empty($_COOKIE['startView'])){
					$updateViews = array(
						'visitas' => $views['visitas']+1,
						'visitantes' => $views['visitantes']+1
						);
				update('views', $updateViews, "mes = '$selMes' AND ano = '$selAno'");
				setcookie('startView', time(), time()+60*60*24, '/');
				}else{
					$updateVisitas = array('visitas' => $views['visitas']+1);
					update('views', $updateVisitas, "mes = '$selMes' AND ano = '$selAno'");
				}
			}
		}else{
			//CONTADOR DE VIEWS PER PAGE
			$readPageViews 	= 	read('views', "WHERE mes = '$selMes' AND ano = '$selAno'");
			if($readPageViews){
				foreach ($readPageViews as $rpgv);
				$updatePageViews 	= 	array('pageviews' => $rpgv['pageviews']+1);
				update('views', $updatePageViews, "mes = '$selMes' AND ano = '$selAno'");
			}

			$id_sessao	=	$_SESSION['startView']['sessao'];
			$time_now 	=	time(date('Y-m-d H:i:s'));
			if($_SESSION['startView']['time_end'] <= time()){
				delete('views_online', "sessao = '$id_sessao' OR time_end <= $time_now");
				unset($_SESSION['startView']);
			}
			else{
				$_SESSION['startView']['time_end'] 	= time() + $times;
				$timeEnd 	=	array('time_end' => $_SESSION['startView']['time_end']);
				update('views_online', $timeEnd, "sessao = '$id_sessao'");
			}
		}
	}

/***************************
PAGINAÇÃO DE RESULTADOS
***************************/
	// $max 	= maximo de resultados por pagina
	// $link 	= url[0] e url[1], link correto
	// $pag 	= fazer a paginacao correta
	// $width 	= determinar um style
	function readPaginator($tabela, $cond, $max, $link, $pag, $width = NULL, $maxLinks = 4){
		$readPaginator 	= read("$tabela", "$cond");
		$total			= mysqli_num_rows($readPaginator);
		if($total > $max){
			$paginas = ceil($total/$max); // ceil arredonda o resultado
			if($width){
				echo '<div class="paginator" style="width:'.$width.'">';
			}else{
				echo '<div class="paginator">';
			}

			// PRIMEIRA PAGINA
			echo '<a href="'.$link.'1">Primeira Página</a>'; 

			// PAGINA ANTERIORES
			for ($i = $pag - $maxLinks; $i <= $pag - 1 ; $i++) {
				if($i >= 1) {
					echo '<a href="'.$link.$i.'" style="margin-left: 25px;">'.$i.'</a>';
				}
			}

			// PAGINA ATUAL			
			echo '<span class="atv" style="margin-left: 25px;">'.$pag.'</span>';

			// PAGINA POSTERIORES
			for ($i = $pag + 1; $i <= $pag + $maxLinks ; $i++) {
				if($i <= $paginas) {
					echo '<a href="'.$link.$i.'" style="margin-left: 25px;">'.$i.'</a>';
				}
			}

			// ULTIMA PAGINA
			echo '<a href="'.$link.$paginas.'" style="margin-left: 25px;">Última Página</a>';
			echo '</div><!-- PAGINATOR -->';
		}
	}
?>