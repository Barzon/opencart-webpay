<?php
class ControllerPaymentWebPay extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/webpay');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('webpay', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		// other data
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		// header
		$data['mod_title'] = $this->language->get('mod_title');
		$data['text_edit'] = $this->language->get('text_edit');
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('mod_title'),
			'href' => $this->url->link('payment/webpay', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		// helps
		$data['help_cgi_url'] = $this->language->get('help_cgi_url');
		$data['help_checkmac_path'] = $this->language->get('help_checkmac_path');
		$data['help_success_url'] = $this->language->get('help_success_url');
		$data['help_failure_url'] = $this->language->get('help_failure_url');
		
		// labels
		$data['label_cgi_url'] = $this->language->get('label_cgi_url');
		$data['label_status'] = $this->language->get('label_status');
		$data['label_checkmac_path'] = $this->language->get('label_checkmac_path');
		$data['label_success_url'] = $this->language->get('label_success_url');
		$data['label_failure_url'] = $this->language->get('label_failure_url');
		$data['label_order_status_id'] = $this->language->get('label_order_status_id');
		
		// texts
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_enabled'] = $this->language->get('text_enabled');

		// form 
		$data['action'] = $this->url->link('payment/webpay', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		// buttons
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		// data
		if (isset($this->request->post['webpay_cgi_url'])) {
			$data['webpay_cgi_url'] = $this->request->post['webpay_cgi_url'];
		} else {
			$data['webpay_cgi_url'] = $this->config->get('webpay_cgi_url');
		}
		
		if (isset($this->request->post['webpay_checkmac_path'])) {
			$data['webpay_checkmac_path'] = $this->request->post['webpay_checkmac_path'];
		} else {
			$data['webpay_checkmac_path'] = $this->config->get('webpay_checkmac_path');
		}

		if (isset($this->request->post['webpay_status'])) {
			$data['webpay_status'] = $this->request->post['webpay_status'];
		} else {
			$data['webpay_status'] = $this->config->get('webpay_status');
		}
		
		if (isset($this->request->post['webpay_success_url'])) {
			$data['webpay_success_url'] = $this->request->post['webpay_success_url'];
		} else {
			$data['webpay_success_url'] = $this->config->get('webpay_success_url');
		}
		
		if (isset($this->request->post['webpay_failure_url'])) {
			$data['webpay_failure_url'] = $this->request->post['webpay_failure_url'];
		} else {
			$data['webpay_failure_url'] = $this->config->get('webpay_failure_url');
		}
		
		if (isset($this->request->post['webpay_order_status_id'])) {
			$data['webpay_order_status_id'] = $this->request->post['webpay_order_status_id'];
		} else {
			$data['webpay_order_status_id'] = $this->config->get('webpay_order_status_id');
		}
		
		// errors
		if (isset($this->error['error_cgi_url'])) {
			$data['error_cgi_url'] = $this->error['error_cgi_url'];
		} else {
			$data['error_cgi_url'] = '';
		}
		
		if (isset($this->error['error_checkmac_path'])) {
			$data['error_checkmac_path'] = $this->error['error_checkmac_path'];
		} else {
			$data['error_checkmac_path'] = '';
		}
		
		if (isset($this->error['error_success_url'])) {
			$data['error_success_url'] = $this->error['error_success_url'];
		} else {
			$data['error_success_url'] = '';
		}
		
		if (isset($this->error['error_failure_url'])) {
			$data['error_failure_url'] = $this->error['error_failure_url'];
		} else {
			$data['error_failure_url'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$this->response->setOutput($this->load->view('payment/webpay.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/webpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['webpay_cgi_url']) {
			$this->error['error_cgi_url'] = $this->language->get('error_empty_field');
		}
		
		if (!$this->request->post['webpay_checkmac_path']) {
			$this->error['error_checkmac_path'] = $this->language->get('error_empty_field');
		}
		
		if ($this->request->post['webpay_checkmac_path'] && !file_exists($this->request->post['webpay_checkmac_path'])) {
			$this->error['error_checkmac_path'] = $this->language->get('error_checkmac_path_file');	
		}
		
		if (!$this->request->post['webpay_success_url']) {
			$this->error['error_success_url'] = $this->language->get('error_empty_field');
		}
		
		if (!$this->request->post['webpay_failure_url']) {
			$this->error['error_failure_url'] = $this->language->get('error_empty_field');
		}
		
		if ($this->request->post['webpay_cgi_url'] && filter_var($this->request->post['webpay_cgi_url'], FILTER_VALIDATE_URL) === false) {
			$this->error['error_cgi_url'] = $this->language->get('error_invalid_url');
		}
		
		if ($this->request->post['webpay_success_url'] && filter_var($this->request->post['webpay_success_url'], FILTER_VALIDATE_URL) === false) {
			$this->error['error_success_url'] = $this->language->get('error_invalid_url');
		}
		
		if ($this->request->post['webpay_failure_url'] && filter_var($this->request->post['webpay_failure_url'], FILTER_VALIDATE_URL) === false) {
			$this->error['error_failure_url'] = $this->language->get('error_invalid_url');
		}
		
		return !$this->error;
	}
	
	public function install() {
		 $this->load->model('payment/webpay');
		 $this->model_payment_webpay->createTable();
	}
	
	public function uninstall() {
        $this->load->model('payment/webpay');
        $this->model_payment_webpay->deleteTable();
    }
}