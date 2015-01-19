<?php

class ModelPaymentWebPay extends Model {
	
	public function getMethod($address, $total) {
		$this->load->language('payment/webpay');
		
		$method_data = array(
			'code'       => 'webpay',
			'title'      => $this->language->get('text_title'),
			'terms'      => '',
			'sort_order' => ''
		);

		return $method_data;
	}
	
	public function insertTransaction($data, $status) {
		$sql = "INSERT
				INTO ".  DB_PREFIX. "webpay_transaction
					(tbk_orden_compra, tbk_tipo_transaccion, tbk_respuesta, tbk_monto, tbk_codigo_autorizacion, tbk_final_numero_tarjeta,
					tbk_fecha_contable, tbk_fecha_transaccion, tbk_hora_transaccion, tbk_id_sesion, tbk_id_transaccion, tbk_tipo_pago,
					tbk_numero_cuotas, tbk_vci, tbk_mac, tbk_status)
				VALUES
					(".$data['TBK_ORDEN_COMPRA'].", '".$data['TBK_TIPO_TRANSACCION']."', ".$data['TBK_RESPUESTA'].", ".$data['TBK_MONTO'].",
					".$data['TBK_CODIGO_AUTORIZACION'].", ".$data['TBK_FINAL_NUMERO_TARJETA'].", ".$data['TBK_FECHA_CONTABLE'].",
					".$data['TBK_FECHA_TRANSACCION'].", ".$data['TBK_HORA_TRANSACCION'].", '".$data['TBK_ID_SESION']."', ".$data['TBK_ID_TRANSACCION'].",
					'".$data['TBK_TIPO_PAGO']."', ".$data['TBK_NUMERO_CUOTAS'].", '".$data['TBK_VCI']."', '".$data['TBK_MAC']."', '".$status."');";
		$this->db->query($sql);
	}
}