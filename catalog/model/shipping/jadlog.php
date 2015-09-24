<?php
class ModelShippingJadlog extends Model {
	
	private $nModalidade = array();
	private $url = '';
	private $quote_data = array();	
	private $cep_destino;
	private $cep_origem;

	private $jadlog = array(
		'Expresso'		=>'0',
		'0'				=>'Expresso',
		'Package'	    =>'3',
		'3'				=>'Package',
		'Rodoviário'	=>'4',
		'4'				=>'Rodoviário',
		'Econômico'		=>'5',
		'5'				=>'Econômico',
		'Doc'			=>'6',
		'6'				=>'Doc',
		'Corporate'     =>'7',
		'7'             =>'Corporate',
		'Com'           =>'9',
		'9'             =>'Com',
		'Internacional' =>'10',
		'10'            =>'Internacional',
		'Cargo'         =>'12',
		'12'            =>'Cargo',
		'Emergêncial'   =>'14',
		'14'            =>'Emergêncial'            
	);
	
	/* RODO = 3333 e AEREO = 6000 */
	private $vCubagem = array(
		'0'	 =>'6000',
		'3'	 =>'3333',
		'4'	 =>'3333',
		'5'	 =>'3333',
		'6'	 =>'3333',
		'7'  =>'6000',
		'9'  =>'6000',
		'10' =>'6000',
		'12' =>'6000',
		'14' =>'3333'
	);
	
	/* Função responsável pelo retorno à loja dos valores finais dos fretes */
	public function getQuote($address) {
		
		$this->load->language('shipping/jadlog');
		
		if ($this->config->get('jadlog_status')) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('jadlog_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
			if (!$this->config->get('jadlog_geo_zone_id')) {
				$status = TRUE;
			} elseif ($query->num_rows) {
				$status = TRUE;
			} else {
				$status = FALSE;
			}
		} else {
			$status = FALSE;
		}		
		
		$method_data = array();

		if ($status) {
			/* Limpa os CEPs para obter apenas os números */
			$this->cep_origem = preg_replace ('/[^\d\s]/', '', $this->config->get('jadlog_cep_origem'));
			$this->cep_destino = preg_replace ('/[^\d\s]/', '', $address['postcode']);			
			/* Ajusta os códigos dos serviços */
			if($this->config->get('jadlog_' . $this->jadlog['Expresso'])){
				$this->nModalidade[] = $this->jadlog['Expresso'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Package'])){
				$this->nModalidade[] = $this->jadlog['Package'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Rodoviário'])){
				$this->nModalidade[] = $this->jadlog['Rodoviário'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Econômico'])){
				$this->nModalidade[] = $this->jadlog['Econômico'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Doc'])){
				$this->nModalidade[] = $this->jadlog['Doc'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Corporate'])){
				$this->nModalidade[] = $this->jadlog['Corporate'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Com'])){
				$this->nModalidade[] = $this->jadlog['Com'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Internacional'])){
				$this->nModalidade[] = $this->jadlog['Internacional'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Cargo'])){
				$this->nModalidade[] = $this->jadlog['Cargo'];
			}
			if($this->config->get('jadlog_' . $this->jadlog['Emergêncial'])){
				$this->nModalidade[] = $this->jadlog['Emergêncial'];
			}
			/* Obtém o frete */
			$this->setQuoteData();
			/* Ajustes finais */
			if ($this->quote_data) {
				/* Obtêm o valor adicional que será somado com o valor retornado pela jadLog */
				$valor_adicional = $this->config->get('jadlog_valor_adicional');
				foreach ($this->quote_data as $codigo=>$data) {
					/* Soma o valor adicional ao valor final do frete */
					$novo_custo = $this->quote_data[$codigo]['cost'] + $valor_adicional;
					/* Novo custo */
					$this->quote_data[$codigo]['cost'] = $novo_custo;
					/* Novo texto */
					$this->quote_data[$codigo]['text'] = $this->currency->format($this->tax->calculate($novo_custo, $this->config->get('jadlog_tax_class_id'), $this->config->get('config_tax')));
				}				
				$method_data = array(
					'code'       => 'jadlog',
					'title'      => $this->language->get('text_title'),
					'quote'      => $this->quote_data,
					'sort_order' => $this->config->get('jadlog_sort_order'),
					'error'      => false
				);
			}			
		}
		return $method_data;
	}

	/* Obtém os dados dos fretes */
	private function setQuoteData(){
		/* Faz a chamada ao WebService da jadLog para obter os dados do frete */
		$valor = $this->cart->getSubTotal();
		$servicos = $this->getServicos($valor);
		foreach ($servicos as $servico) {
			if(isset($servico['Retorno']) && $servico['Retorno'] > 0) {
				/* */
				$custo = $servico['Retorno'];
				/* Troca o separador decimal de vírgula para ponto no valor */
				$custo = str_replace(',', '.', $custo);
				$custo = number_format((float)$custo, 2, '.' , '');
				$text  = $this->currency->format($this->tax->calculate($custo, $this->config->get('jadlog_tax_class_id'), $this->config->get('config_tax')));
				$this->quote_data[$servico['Codigo']] = array(
					'code'         => 'jadlog.' . $servico['Codigo'],
					'title'        => $this->language->get('text_'.$servico['Codigo']),
					'cost'         => $custo,
					'tax_class_id' => $this->config->get('jadlog_tax_class_id'),
					'text'         => $text
				);
			} else {
				/* Grava no log de erros do OpenCart a mensagem de erro retornada pela jadLog */
				$this->log->write('jadLog Erro: '.$servico['Retorno'].' Mensagem: '.$servico['Mensagem']);
			}
		}
	}
	
	/* Inicia o processo e lê os dados no arquivo XML retornado pela jadLog */ 
	public function getServicos($valor){
		$dados = array();
		/* Troca o separador decimal de ponto para vírgula no valor */
		$valor = str_replace('.', ',', $valor);
		$valor = number_format((float)$valor, 2, ',' , '.');
		/* Carrega as informações dos produtos */
		$produtos = $this->cart->getProducts();
		/* Pré calcula o peso real dos produtos para as modalidades AEREO E RODO */
		$pRodo  = $this->calcularCubagem($produtos, '3333');
		$pAereo = $this->calcularCubagem($produtos, '6000');
		/* Armazena os arrays para melhorar o codigo */
		$pModalidade = $this->nModalidade;
		$pCubagem    = $this->vCubagem;
		/* Faz o loop nas modalidades habilitadas */
		for ($i=0;$i<count($pModalidade);$i++) {
			/* Verifica qual cubagem vai ser utilizada para carregar o peso correto */
			if ($pCubagem[$pModalidade[$i]] == '3333') {
				$peso = $pRodo;
			} else if ($pCubagem[$pModalidade[$i]] == '6000') {
				$peso = $pAereo;
			}
			/* Troca o separador decimal de ponto para vírgula no peso */
			$peso = str_replace('.', ',', $peso);
			/* Ajusta a url de chamada */
			$this->setUrl($peso, $valor, $pModalidade[$i]);
			/* Faz a chamada e retorna o xml com os dados */
			$xml = $this->getXML($this->url);
			/* Lê o xml */
			if ($xml) {
				$dom = new DOMDocument('1.0', 'UTF-8');
				$dom->loadXml($xml);
				$servicos = $dom->getElementsByTagName('Jadlog_Valor_Frete');
				if ($servicos) {
					foreach ($servicos as $servico) {
						/* Monta o array com o resultado da consulta */
						$dados[$pModalidade[$i]] = array(
							'Codigo'   => $pModalidade[$i],
							'Retorno'  => $servico->getElementsByTagName('Retorno')->item(0)->nodeValue,
							'Mensagem' => $servico->getElementsByTagName('Mensagem')->item(0)->nodeValue
						);
					}
				}
			}
		}
		return $dados;
	}

    /* Faz o cálculo da cubagem para obter o peso real */
  	private function calcularCubagem($produtos, $modal) {
  		$peso_real = 0;
  		foreach ($produtos as $produto) {
  			$produto_copia = $produto;
  			/* Converte todas as dimensões dos produtos para centímetro */
  			$produto_copia['width']	= $this->converterCm($produto_copia['length_class_id'], $produto_copia['width']);
  			$produto_copia['height']= $this->converterCm($produto_copia['length_class_id'], $produto_copia['height']);
  			$produto_copia['length']= $this->converterCm($produto_copia['length_class_id'], $produto_copia['length']);

  			$produto_copia['length_class_id'] = $this->config->get('config_length_class_id');
  			$produto_copia['weight_class_id'] = $this->config->get('config_weight_class_id');

  			for ($i = 1; $i <= $produto['quantity']; $i++) {
  				if ($this->validarDimensoes($produto_copia)){
					/* Cálculo da cubagem */
					$dimensoes = $produto_copia['height']*$produto_copia['length']*$produto_copia['width'];
					$peso_real = $peso_real+($dimensoes/$modal);
				} else {
					$peso_real = 0;
  					break 2;
				}
  			}
  		}
  		return $peso_real;
  	}
	
  	/* Verifica se as dimensões do produto estão cadastradas e são números */
	private function validarDimensoes($produto){
		if(!is_numeric($produto['height']) || !is_numeric($produto['width']) || !is_numeric($produto['length'])){
			$this->log->write(sprintf($this->language->get('error_dados'), $produto['name']));
			return false;
		}  			
  		return true;
  	}
	
	/* Converte a dimensão do produto para centímetro */
	private function converterCm($unidade, $dimensao){
		$dimensao = $this->length->convert($dimensao, $unidade, $this->config->get('config_length_class_id'));
		return $dimensao;
	}

	/* Prepara a url de chamada para o WebService da jadLog */
	private function setUrl($peso, $valor, $modalidade){
		$url = "http://jadlog.com.br/JadlogEdiWs/services/ValorFreteBean?method=valorar";
		$url .=	"&vModalidade=%s";
		$url .=	"&Password=".$this->config->get('jadlog_password');
		$url .=	"&vSeguro=".$this->config->get('jadlog_tipo_seguro');
		$url .=	"&vVlDec=%s";
		$url .=	"&vVlColeta=".$this->config->get('jadlog_valor_coleta');
		$url .=	"&vCepOrig=".$this->cep_origem;
		$url .=	"&vCepDest=".$this->cep_destino;
		$url .=	"&vPeso=%s";
		$url .=	"&vFrap=".$this->config->get('jadlog_frete_pagar');
		$url .=	"&vEntrega=".$this->config->get('jadlog_tipo_entrega');
		$url .=	"&vCnpj=".$this->config->get('jadlog_cnpj');
		
		$this->url = sprintf($url, $modalidade, $valor, $peso);
	}
	
	/* Conecta ao WebService da jadLog e obtém o arquivo XML com os dados do frete */
	private function getXML($url){
		ob_start();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml = curl_exec($ch);
		curl_close($ch);
		ob_end_clean();
		
		$xml = str_replace('<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><soapenv:Body><valorarResponse xmlns=""><ns1:valorarReturn xmlns:ns1="http://jadlogEdiws">', '', $xml);
		$xml = str_replace('</ns1:valorarReturn></valorarResponse></soapenv:Body></soapenv:Envelope>', '', $xml);
		$xml = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $xml);
		$xml = str_replace('&gt;', '>', $xml);
		$xml = str_replace('&lt;', '<', $xml);
		$xml = str_replace('&quot;', '"', $xml);
		$xml = str_replace('<string xmlns="http://www.jadlog.com.br/JadlogWebService/services">', '', $xml);
		$xml = str_replace('</string>', '', $xml);		
		
		return $xml;
	}
}
?>