<?php
class ModelPaymentWebPay extends Model {
	
	public function createTable() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "webpay_transaction` (
			  `webpay_transaction_id` INT(11) NOT NULL AUTO_INCREMENT,
			  `tbk_orden_compra` INT(11) NOT NULL,
			  `tbk_tipo_transaccion` VARCHAR(255),
			  `tbk_respuesta` INT(11) NOT NULL,
			  `tbk_monto` INT(11) NOT NULL,
			  `tbk_codigo_autorizacion` INT(11) NOT NULL,
			  `tbk_final_numero_tarjeta` INT(11) NOT NULL,
			  `tbk_fecha_contable` INT(11) NOT NULL,
			  `tbk_fecha_transaccion` INT(11) NOT NULL,
			  `tbk_hora_transaccion` INT(11) NOT NULL,
			  `tbk_id_sesion` VARCHAR(255) NOT NULL,
			  `tbk_id_transaccion` INT(11) NOT NULL,
			  `tbk_tipo_pago` VARCHAR(255) NOT NULL,
			  `tbk_numero_cuotas` INT(11) NOT NULL,
			  `tbk_vci` VARCHAR(255) NOT NULL,
			  `tbk_mac` TEXT NOT NULL,
			  `tbk_status` VARCHAR(255) NOT NULL,
			  PRIMARY KEY (`webpay_transaction_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
	}
	
	public function deleteTable() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "webpay_transaction`;");
	}
}