<?php
class ControllerShippingJadlog extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/jadlog');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('jadlog', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['text_expresso'] = $this->language->get('text_expresso');
		$this->data['text_package'] = $this->language->get('text_package');
		$this->data['text_rodoviario'] = $this->language->get('text_rodoviario');
		$this->data['text_economico'] = $this->language->get('text_economico');
		$this->data['text_doc'] = $this->language->get('text_doc');
        $this->data['text_corporate'] = $this->language->get('text_corporate');
        $this->data['text_com'] = $this->language->get('text_com');
        $this->data['text_internacional'] = $this->language->get('text_internacional');
        $this->data['text_cargo'] = $this->language->get('text_cargo');
        $this->data['text_emergencial'] = $this->language->get('text_emergencial');
        $this->data['text_retirada'] = $this->language->get('text_retirada');
        $this->data['text_domicilio'] = $this->language->get('text_domicilio');
        $this->data['text_normal'] = $this->language->get('text_normal');
        $this->data['text_apolice'] = $this->language->get('text_apolice');

        $this->data['entry_cnpj']= $this->language->get('entry_cnpj');
        $this->data['entry_password']= $this->language->get('entry_password');          
		$this->data['entry_cep_origem']= $this->language->get('entry_cep_origem');    
		$this->data['entry_servicos'] = $this->language->get('entry_servicos');
		$this->data['entry_tipo_seguro'] = $this->language->get('entry_tipo_seguro');
		$this->data['entry_valor_coleta'] =$this->language->get('entry_valor_coleta');
        $this->data['entry_valor_adicional'] = $this->language->get('entry_valor_adicional');
		$this->data['entry_tipo_entrega'] = $this->language->get('entry_tipo_entrega');
		$this->data['entry_frete_pagar'] = $this->language->get('entry_frete_pagar');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');		

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

        if (isset($this->error['cnpj'])) {
			$this->data['error_cnpj'] = $this->error['cnpj'];
		} else {
			$this->data['error_cnpj'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['servico'])) {
			$this->data['error_servico'] = $this->error['servico'];
		} else {
			$this->data['error_servico'] = '';
		}		

		if (isset($this->error['cep_origem'])) {
			$this->data['error_cep_origem'] = $this->error['cep_origem'];
		} else {
			$this->data['error_cep_origem'] = '';
		}

		$this->data['breadcrumbs'] = array();
   		
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_shipping'),
      		'separator' => ' :: '
   		);
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('shipping/jadlog', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
   		$this->data['action'] = $this->url->link('shipping/jadlog', 'token=' . $this->session->data['token'], 'SSL');
		
   		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['jadlog_cnpj'])) {                    
			$this->data['jadlog_cnpj'] = $this->request->post['jadlog_cnpj'];
		} else {
			$this->data['jadlog_cnpj'] = $this->config->get('jadlog_cnpj');
		}

        if (isset($this->request->post['jadlog_password'])) {
			$this->data['jadlog_password'] = $this->request->post['jadlog_password'];
		} else {
			$this->data['jadlog_password'] = $this->config->get('jadlog_password');
		}

		if (isset($this->request->post['jadlog_cep_origem'])) {
			$this->data['jadlog_cep_origem'] =$this->request->post['jadlog_cep_origem'];
		} else {
			$this->data['jadlog_cep_origem'] = $this->config->get('jadlog_cep_origem');
		}

		if (isset($this->request->post['jadlog_0'])) {
			$this->data['jadlog_0'] = $this->request->post['jadlog_0'];
		} else {
			$this->data['jadlog_0'] = $this->config->get('jadlog_0');
		}
		
		if (isset($this->request->post['jadlog_3'])) {
			$this->data['jadlog_3'] = $this->request->post['jadlog_3'];
		} else {
			$this->data['jadlog_3'] = $this->config->get('jadlog_3');
		}
		
		if (isset($this->request->post['jadlog_4'])) {
			$this->data['jadlog_4'] = $this->request->post['jadlog_4'];
		} else {
			$this->data['jadlog_4'] = $this->config->get('jadlog_4');
		}
		
		if (isset($this->request->post['jadlog_5'])) {
			$this->data['jadlog_5'] = $this->request->post['jadlog_5'];
		} else {
			$this->data['jadlog_5'] = $this->config->get('jadlog_5');
		}

		if (isset($this->request->post['jadlog_6'])) {
			$this->data['jadlog_6'] = $this->request->post['jadlog_6'];
		} else {
			$this->data['jadlog_6'] = $this->config->get('jadlog_6');
		}

		if (isset($this->request->post['jadlog_7'])) {
			$this->data['jadlog_7'] = $this->request->post['jadlog_7'];
		} else {
			$this->data['jadlog_7'] = $this->config->get('jadlog_7');
		}

		if (isset($this->request->post['jadlog_9'])) {
			$this->data['jadlog_9'] = $this->request->post['jadlog_9'];
		} else {
			$this->data['jadlog_9'] = $this->config->get('jadlog_9');
		}

		if (isset($this->request->post['jadlog_10'])) {
			$this->data['jadlog_10'] = $this->request->post['jadlog_10'];
		} else {
			$this->data['jadlog_10'] = $this->config->get('jadlog_10');
		}

		if (isset($this->request->post['jadlog_12'])) {
			$this->data['jadlog_12'] = $this->request->post['jadlog_12'];
		} else {
			$this->data['jadlog_12'] = $this->config->get('jadlog_12');
		}

		if (isset($this->request->post['jadlog_14'])) {
			$this->data['jadlog_14'] = $this->request->post['jadlog_14'];
		} else {
			$this->data['jadlog_14'] = $this->config->get('jadlog_14');
		}

		if (isset($this->request->post['jadlog_tipo_seguro'])) {
			$this->data['jadlog_tipo_seguro'] = $this->request->post['jadlog_tipo_seguro'];
		} else {
			$this->data['jadlog_tipo_seguro'] = $this->config->get('jadlog_tipo_seguro');
		}

		if (isset($this->request->post['jadlog_valor_coleta'])) {
			$this->data['jadlog_valor_coleta'] = $this->request->post['jadlog_valor_coleta'];
		} else {
			$this->data['jadlog_valor_coleta'] = $this->config->get('jadlog_valor_coleta');
		}

		if (isset($this->request->post['jadlog_valor_adicional'])) {
			$this->data['jadlog_valor_adicional'] = $this->request->post['jadlog_valor_adicional'];
		} else {
			$this->data['jadlog_valor_adicional'] = $this->config->get('jadlog_valor_adicional');
		}

        if (isset($this->request->post['jadlog_tipo_entrega'])) {
			$this->data['jadlog_tipo_entrega'] = $this->request->post['jadlog_tipo_entrega'];
		} else {
			$this->data['jadlog_tipo_entrega'] = $this->config->get('jadlog_tipo_entrega');
		}

		if (isset($this->request->post['jadlog_frete_pagar'])) {
			$this->data['jadlog_frete_pagar'] = $this->request->post['jadlog_frete_pagar'];
		} else {
			$this->data['jadlog_frete_pagar'] = $this->config->get('jadlog_frete_pagar');
		}

		if (isset($this->request->post['jadlog_tax_class_id'])) {
			$this->data['jadlog_tax_class_id'] = $this->request->post['jadlog_tax_class_id'];
		} else {
			$this->data['jadlog_tax_class_id'] = $this->config->get('jadlog_tax_class_id');
		}

		if (isset($this->request->post['jadlog_geo_zone_id'])) {
			$this->data['jadlog_geo_zone_id'] = $this->request->post['jadlog_geo_zone_id'];
		} else {
			$this->data['jadlog_geo_zone_id'] = $this->config->get('jadlog_geo_zone_id');
		}

		if (isset($this->request->post['jadlog_status'])) {
			$this->data['jadlog_status'] = $this->request->post['jadlog_status'];
		} else {
			$this->data['jadlog_status'] = $this->config->get('jadlog_status');
		}

		if (isset($this->request->post['jadlog_sort_order'])) {
			$this->data['jadlog_sort_order'] = $this->request->post['jadlog_sort_order'];
		} else {
			$this->data['jadlog_sort_order'] = $this->config->get('jadlog_sort_order');
		}

		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->template = 'shipping/jadlog.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/jadlog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        if (!$this->request->post['jadlog_cnpj']<>'') {
			$this->error['cnpj'] = $this->language->get('error_cnpj');
		}

		if (!$this->request->post['jadlog_password']<>'') {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!preg_match ("/^([0-9]{2})\.?([0-9]{3})-?([0-9]{3})$/", $this->request->post['jadlog_cep_origem'])) {
			$this->error['cep_origem'] = $this->language->get('error_cep_origem');
		}

		if (!isset($this->request->post['jadlog_0']) && !isset($this->request->post['jadlog_3']) && !isset($this->request->post['jadlog_4']) && !isset($this->request->post['jadlog_5']) && !isset($this->request->post['jadlog_6'])&& !isset($this->request->post['jadlog_7'])&&!isset($this->request->post['jadlog_9'])&&!isset($this->request->post['jadlog_10'])&&!isset($this->request->post['jadlog_12'])&&!isset($this->request->post['jadlog_14'])) {
			$this->error['servico'] = $this->language->get('error_servico');
		}		

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
