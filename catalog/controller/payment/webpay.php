<?php
class ControllerPaymentWebPay extends Controller {

	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$data['action'] = $this->config->get('webpay_cgi_url');
		
		$data['TBK_TIPO_TRANSACCION'] = 'TR_NORMAL';
		$data['TBK_MONTO'] = number_format($order_info['total'], 2, '', '');
		$data['TBK_ORDEN_COMPRA'] = $order_info['order_id'];
		$data['TBK_ID_SESION'] = md5(uniqid().time());
		$data['TBK_URL_EXITO'] = $this->config->get('webpay_success_url');
		$data['TBK_URL_FRACASO'] = $this->config->get('webpay_failure_url');

		//$data['TBK_MONTO_CUOTA'] = null;
		//$data['TBK_NUMERO_CUOTAS'] = null;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/webpay.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/webpay.tpl', $data);
		}
	}

	public function callback() {
		$this->load->language('payment/webpay');
		$data = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$action = htmlentities($this->request->get['action']);
			
			if ($action != 'check') {
				if (!$this->request->server['HTTPS']) {
					$data['base'] = $this->config->get('config_url');
				} else {
					$data['base'] = $this->config->get('config_ssl');
				}
				
				$data['title'] = $this->language->get('title');
				$data['language'] = $this->language->get('code');
				$data['direction'] = $this->language->get('direction');
				$data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success'));
				$data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
				$data['text_response'] = $this->language->get('text_response');
				$data['text_success'] = $this->language->get('text_success');
				$data['text_failure'] = $this->language->get('text_failure');
				$data['text_failure_wait'] = $this->language->get('text_failure_wait');
			}
			
			if ($action == 'check') {
				
				$this->load->model('checkout/order');
				$order_info = $this->model_checkout_order->getOrder($this->request->post['TBK_ORDEN_COMPRA']);
				
				$fp = tmpfile();
				while(list($key, $val) = each($this->request->post)) {
					fwrite($fp, $key .'='. $val .'&');
				}
				$meta_data = stream_get_meta_data($fp);
				$filename = $meta_data['uri'];
				
				if ($this->request->post['TBK_RESPUESTA'] == "0") {
					$ok = true;
				} else {
					$ok = false;
				}
				
				// validacion de monto y orden de compra
				// debe ser multiplicado por 100 para coincidir lo informado por transbank
				$total = $order_info['total']*100;
				if ($this->request->post['TBK_MONTO'] == $total && $this->request->post['TBK_ORDEN_COMPRA'] == $order_info['order_id'] && $ok == true) {
					$ok = true;
				} else {
					$ok = false;
				}
				
				// validacion MAC
				$tbk_check_mac = $this->config->get('webpay_checkmac_path');
				$cmdline = sprintf('%s %s', $tbk_check_mac, $filename);
				if ($ok == true){
					exec($cmdline, $result, $retint);
					
					if ($result[0] == 'CORRECTO') {
						$ok = true;
					} else {
						$ok = false;
					}
				}
				
				$this->load->model('checkout/order');
				if ($ok == true) {
					$status = 'ACEPTADO';
					// pago exitoso
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('webpay_order_status_id'), $status, false);
				} else {
					$status = 'RECHAZADO';
					// pago no realizado
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('config_order_status_id'), $status, false);
				}
				
				$this->load->model('payment/webpay');
				$this->model_payment_webpay->insertTransaction($this->request->post, $status);
				$data['status'] = $status;
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay_check.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/webpay_check.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/payment/webpay_check.tpl', $data));
				}
			}
			
			if ($action == 'success') {
				$data['continue'] = $this->url->link('checkout/success');
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay_success.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/webpay_success.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/payment/webpay_success.tpl', $data));
				}
			} 
			
			if ($action == 'failure') {
				$data['continue'] = $this->url->link('checkout/cart');
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay_failure.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/webpay_failure.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/payment/webpay_failure.tpl', $data));
				}	
			}	
		}
	}
}