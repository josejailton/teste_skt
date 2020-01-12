<?php
error_reporting(E_ALL);
set_time_limit(0);
ini_set('display_errors','On');
define('MYSQL_HOST','***');
define('MYSQL_USER','***');
define('MYSQL_PASSWORD','***');
define('MYSQL_DB_NAME',***');
try{
	$pdo = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB_NAME,MYSQL_USER,MYSQL_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	echo 'Erro ao conectar com o MySQL via PDO: '.$e->getMessage();
}

function nome_cliente($codigo){
	switch($codigo){
		case '1':
			return 'CONSUMIDOR FINAL';
		break;
		case '2':
			return 'STEVEM SPILBER';
		break;
		case '3':
			return 'AUDANIRAM BARBOSA';
		break;
		case '4':
			return 'FRANK SINATRA';
		break;
	}
}



$id_loja = 2;
//$consulta = $pdo->query("SELECT ponto_datas.id, ponto_datas.data FROM ponto_datas AS dt WHERE dt.id ");
$stmt = $pdo->prepare("SELECT ped.id AS id, ped.id_cliente AS id_cliente, ped.status AS status, ped.data_hora AS data_hora FROM pedidos_teste ped");
$stmt->execute();
$result = $stmt->fetchAll();
if($result){
	$model['status'] = true;
	$model['data']['result'] = array();
	foreach($result as $key){
		$model_result = array();
		$model_result['id'] = (int)$key['id'];
		$model_result['id_cliente'] = $key['id_cliente'];
		$model_result['cliente'] = nome_cliente($key['id_cliente']);
		$model_result['status'] = $key['status'];
		$model_result['data_hora'] = $key['data_hora'];
		array_push($model['data']['result'],$model_result);
	}
	
	//$model['data']['total_items'] = $stmt->rowCount();
	//$model['data']['current_page'] = 1;
	//$model['data']['num_items_per_page'] = 10;
	//$model['data']['date_time_push'] = date('d/m/Y H:i:s');
}else{
	$model['data']['message'] = 'Nenhum registro foi encontrado.';
	$model['data']['records'] = 0;
}

header('Content-Type:application/json');
echo json_encode($model,JSON_PRETTY_PRINT);
