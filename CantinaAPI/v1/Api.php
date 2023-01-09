<?php 


	require_once '../includes/DbOperation.php';

	function isTheseParametersAvailable($params){
	
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
		
			echo json_encode($response);
			
		
			die();
		}
	}
	
	
	$response = array();
	

	if(isset($_GET['apicall'])){
		$db = new DbOperation();
		
		switch($_GET['apicall']){
	
			case 'createProdutos':
				
				isTheseParametersAvailable(array('NomeProduto','PrecoProduto','QtdeEstoque','Descricao'));
				
				$result = $db->createProdutos(
					$_POST['NomeProduto'],
					$_POST['PrecoProduto'],
					$_POST['QtdeEstoque'],
					$_POST['Descricao']
				);
				

			
				if($result){
					
					$response['error'] = false; 

					
					$response['message'] = 'Produto adicionado com sucesso';

					
					$response['produtos'] = $db->getProdutos();

				}else{

					
					$response['error'] = true; 

				
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
				header('location: http://localhost/siteTCC/Gerenciamento.php');
			break; 
			
		
			case 'getProdutos':

					$response['error'] = false; 
					$response['message'] = 'Pedido concluído com sucesso';
					$response['produtos'] = $db->getProdutos();
				
			break;

			case 'selectProdutos':

				$id = $_POST['IDProduto'];
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['produtos'] = $db->selectProdutos($id);

			break;

			case 'getClientePedidos':

				$id = $_POST['IDCliente'];
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['PedidosCliente'] = $db->getClientePedidos($id);

			break; 	



			case 'createPedido':
				
				isTheseParametersAvailable(array('IDCliente','DataPedido','ValorPedido'));
				
				$result = $db->createPedido(
					$_POST['IDCliente'],
					$_POST['DataPedido'],
					$_POST['ValorPedido']
				);
			break;	

				case 'confirmarPedido':

					isTheseParametersAvailable(array('Confirmado', 'IDPedido'));

					$result = $db->confirmarPedido(
						$_POST['Confirmado'],
						$_POST['IDPedido']
					);
					
					if($result){
						$response['error'] = false; 
						$response['message'] = 'Produto atualizado com sucesso';
					}else{
						$response['error'] = true; 
						$response['message'] = 'Algum erro ocorreu por favor tente novamente';
					}
					header('location: http://localhost/siteTCC/Pedidos.php');
				break; 	
				
				if($result){
					$response['error'] = false;
					$response['message'] = 'Pedido realizado com sucesso';
					$response['pedidos'] = $db->getPedidos();

				}
				else
				{

					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu, por favor tente novamente';
				}
			break;

			case 'statusLogin':
				isTheseParametersAvailable(array('IDCliente'));
				
				$result = $db->statusLogin(
					$_POST['IDCliente']
				);

				if($result)
				{
					
					$response['error'] = false; 
					$response['message'] = 'Status recebido';
					$response['statusLogin'] = $result;

				}
				else
				{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu, por favor tente novamente';
				}


			break;

			case 'pegarDadosUsuario':

				isTheseParametersAvailable(array('IDCliente'));
				
				$result = $db->pegarDadosUsuario(
					$_POST['IDCliente']
				);

				if($result)
				{
					
					$response['error'] = false; 
					$response['message'] = 'dados recebidos!';
					$response['dados'] = $result;

				}
				else
				{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu, por favor tente novamente';
				}

			break;	

			case 'cadastraItens':

				isTheseParametersAvailable(array('IDProduto','QuantidadeVendida'));
				
				$result = $db->cadastraItens(
					$_POST['IDProduto'],
					$_POST['QuantidadeVendida']
				);

				if($result)
				{
					
					$response['error'] = false; 
					$response['message'] = 'Pedido realizado com sucesso';

				}
				else
				{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu, por favor tente novamente';
				}

			break;

			case 'retornaIDPedido':

				$result = $db->retornaIDPedido();
				if (!empty($result)) 
				{
					$response['error'] = false;
					$response['message'] = 'IDPedido resgatado.';
					$response['IDspedido'] = $result;
				} 
				else 
				{
										
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu, por favor tente novamente';
				}
			break;

			case 'logar':

				isTheseParametersAvailable(array('email', 'senha'));

				$result = $db->logar(
					$_POST['email'],
					$_POST['senha']
				);
				if($result)
				{
					$response['error'] = false; 
					
					//var_dump($result);
					if ($result[0] !=	 false)
					{
						$response['message'] = 'logado com sucesso';
						$response['Dados'] = $result;
						
					}else 
					{
						$response['message'] = 'deslogado com sucesso';
					}
				}else {
					$response['error'] = true; 
					$response['message'] = 'email ou senha incorretos!';
				}

			break;

			case 'registrarCliente':

				isTheseParametersAvailable(array('Nome','Telefone','Email', 'Senha'));
				
				$result = $db->createPedido(
					$_POST['Nome'],
					$_POST['Telefone'],
					$_POST['Email'],
					$_POST['Senha']
				);
			
				if($result){
					
					$response['error'] = false; 

					
					$response['message'] = 'Cliente registrado com sucesso';

				}else{

					
					$response['error'] = true; 

				
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
				
				
			break;


			case 'updateProdutos':
				isTheseParametersAvailable(array('IDProduto','NomeProduto','PrecoProduto','QtdeEstoque','Descricao'));

				$result = $db->updateProdutos(
					$_POST['IDProduto'],
					$_POST['NomeProduto'],
					$_POST['PrecoProduto'],
					$_POST['QtdeEstoque'],
					$_POST['Descricao']
				);
				
				if($result){
					$response['error'] = false; 
					$response['message'] = 'Produto atualizado com sucesso';
					$response['produtos'] = $db->getProdutos();
				}else{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
				header('location: http://localhost/siteTCC/Gerenciamento.php');
			break; 
			
			
			case 'deleteProdutos':

				
				if(isset($_POST['IDProduto'])){

					if($db->deleteProdutos($_POST['IDProduto'])){
						$response['error'] = false; 
						$response['message'] = 'Produto excluído com sucesso';
						$response['produtos'] = $db->getProdutos();
						header('location: http://localhost/siteTCC/Gerenciamento.php');
					}else{
						$response['error'] = true; 
						$response['message'] = 'Algum erro ocorreu por favor tente novamente';
					}
				}else{
					$response['error'] = true; 
					$response['message'] = 'Não foi possível deletar, forneça um id por favor';
				}
				
			break; 


			case 'getItensPedidos':

				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['pedidos'] = $db->getItensPedidos();
			break;
			case 'getPedidos':

				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['pedidos'] = $db->getPedidos();
			break;

			case 'cadastraItensPedidos':
  
                isTheseParametersAvailable(array('IDPedido','IDProduto','QuantidadeVendida'));

                $result = $db->cadastraItensPedidos(
                    $_POST['IDPedido'],
                    $_POST['IDProduto'],
                    $_POST['QuantidadeVendida']
                );


                if($result){

                    $response['error'] = false; 


                    $response['message'] = 'Pedido realizado com sucesso';


                }else{


                    $response['error'] = true; 


                    $response['message'] = 'Algum erro ocorreu, por favor tente novamente';
                }


            break;
		}
		
	}else{
		 
		$response['error'] = true; 
		$response['message'] = 'Chamada de API inválida';
	}
	

	echo json_encode($response);