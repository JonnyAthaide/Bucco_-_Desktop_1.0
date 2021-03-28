<?php
    require 'iniSis.php';
    
/***************************
FUNÇÃO DE HOMOLOGAÇÃO VAR_DUMP
***************************/
    function varDevHomo($query){
//       $var_dump = true;
       $var_dump = false;
       if($var_dump == true){
           var_dump($query);
       }
    }
    
/***************************
FUNÇÃO DE CONEXÃO COM DB
***************************/
    function conect(){
        try {
            $mysqli = mysqli_connect(HOST, USER, PASS, DBSA);
            return $mysqli;
        } catch (Exception $exc) {
            die('Erro ao conectar '.mysqli_connect_error());
            echo 'NÃO FOI POSSÍVEL CONECTAR AO BANCO DE DADOS!!';
            echo $exc->getTraceAsString();
        }
    }

/***************************
FUNÇÃO DE CADASTRO NO BANCO
***************************/
    function create($tabela, array $datas){            
        try {
            $fields 	= implode(", ", array_keys($datas));
            $values 	= "'".implode("', '", array_values($datas))."'";
            $qrCreate 	= "INSERT INTO {$tabela} ($fields) VALUES($values)";
            $exeCreate	= mysqli_query(conect(), $qrCreate) 
                    or die('Erro ao cadastrar dados em '.$tabela);
            varDevHomo($qrCreate);
            if($exeCreate){ return true;}
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

/***************************
FUNÇÃO DE LEITURA NO BANCO
***************************/
    function read($tabela, $cond = NULL){
        try {
            $qrRead 	= "SELECT * FROM {$tabela} {$cond}";
            $exeRead	= mysqli_query(conect(), $qrRead) 
                    or die('Erro ao ler os dados em '.$tabela);
            varDevHomo($qrRead);
            return $exeRead;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

/***************************
FUNÇÃO DE EDIÇÃO NO BANCO
***************************/
    function update($tabela, array $datas, $where){            
        try {
            foreach ($datas as $field => $value) {
                        $campos[] = "$field = '$value'";
                }
            $campos = implode(", ", $campos);
            $qrUpdate = "UPDATE {$tabela} SET $campos WHERE {$where}";
            varDevHomo($qrUpdate);
            $exeUpdate	= mysqli_query(conect(), $qrUpdate) 
                    or die('Erro ao atualizar dados em '.$tabela);
            if($exeUpdate){ return true;}                
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

/***************************
FUNÇÃO DE EXCLUSÃO NO BANCO
***************************/
    function delete( $tabela, $where){
        try {
            $qrDelete   = "DELETE FROM {$tabela} WHERE {$where}";
            $exeDelete  = mysqli_query(conect(), $qrDelete) 
                    or die('Erro ao excluir dados em '.$tabela);
            varDevHomo($qrDelete);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
    
    
    
    
    
    
    
/***************************
LER ULTIMO REGISTRO
***************************/
    function lastRegistro($tabela, $field){
        try {
            $qrLV   = "SELECT max($field) FROM {$tabela}";
            $exeLV  = mysqli_query(conect(), $qrLV) or 
                    die('Erro ao ler os dados em '.$tabela);
            varDevHomo($exeLV);
            return $exeLV;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
/***************************
FUNÇÃO DE CADASTRO COMPRAS
***************************/
    function createCompras( $id_conta, $id_produto, $qntd){
        try {
            $qrCreate 	= "INSERT INTO tb_compra VALUES( default, '$id_conta', '$id_produto', '$qntd', default)";
            $exeCreate	= mysqli_query(conect(), $qrCreate) or die('Erro ao cadastrar dados em tb_compra');
            varDevHomo($qrCreate);
            if($exeCreate){ return true;}
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
/***************************
FUNÇÃO LER COZINHA
***************************/
    function readCozinha(){
        try {
            $qrCozinha 	= "SELECT cp.id, cp.id_conta, id_produto, mn.descricao, 
                        qnt, dt_abre, dt_entrega
                        FROM tb_compra cp
                        LEFT JOIN tb_conta ct ON ct.id = cp.id_conta 
                        LEFT JOIN tb_menu mn ON mn.id = cp.id_produto
                        WHERE dt_abre > CURDATE()
                        AND dt_entrega LIKE '0000-00-00 00:00:00'";
            $exeCozinha	= mysqli_query(conect(), $qrCozinha) or 
                    die('Erro ao ler tabela tb_compra');
            varDevHomo($qrCozinha);
            return $exeCozinha;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
}

/***************************
	RELATORIO DIA PGTO
***************************/

    function relTipoPgto( $dt_ini, $dt_fim){
        try {
            $qrRelTipoPgto = "
                SELECT
                IFNULL(pg.descricao, 'TOTAL') descricao,
                count( DISTINCT ct.id) qtd,
                sum(cp.qnt*me.valor) valor
                FROM tb_conta ct
                LEFT JOIN tb_pgto pg ON pg.id = ct.pgto
                LEFT JOIN tb_compra cp ON cp.id_conta = ct.id
                LEFT JOIN tb_menu me ON me.id = cp.id_produto
                WHERE DATE(dt_abre) BETWEEN '$dt_ini 00:00:00' AND '$dt_fim 23:59:59'
                GROUP BY pg.descricao WITH ROLLUP";
            $exeRelTipoPgto	= mysqli_query(conect(), $qrRelTipoPgto) or 
                    die('Erro ao ler relatório!');
            varDevHomo($exeRelTipoPgto);
            return $exeRelTipoPgto;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


/***************************
    RELATORIO DIA ITEM
***************************/

    function relTipoItem( $dt_ini, $dt_fim){
        try {
            $qrRelTipoItem  = "	
                SELECT
                IFNULL(menu.descricao, 'TOTAL') descricao,
                SUM(compra.qnt) qtd
                FROM tb_compra compra
                LEFT JOIN tb_menu menu ON menu.id = compra.id_produto
                WHERE DATE(dt_entrega) BETWEEN '$dt_ini 00:00:00' AND '$dt_fim 23:59:59'
                GROUP BY menu.descricao WITH ROLLUP";
            $exeRelTipoItem	= mysqli_query(conect(), $qrRelTipoItem) or 
                    die('Erro ao ler relatório!');
            varDevHomo($exeRelTipoItem);
            return $exeRelTipoItem;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
?>