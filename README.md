# opencart-webpay
Módulo WebPay (Transbank) para OpenCart

# Características
- Idioma inglés - español
- Guarda transacciones en BD (tabla webpay_transaction)
- Compatible con OpenCart >= 2.0.1.1
- Compatible con KCC >= 6.0

# Instalación

(Se asume que ya tienes instalado el kit KCC)

En el directorio raiz de tu OpenCart descomprimir los archivos. Luego ir al administrador -> Extensions -> Payments -> instalar "Transbank Webpay" y editar los parámetros del módulo según instalación de KCC.

El módulo trae por defecto las páginas de éxito/fracaso, estas son:

```
http://dominio/index.php?route=payment/webpay/callback&action=success
http://dominio/index.php?route=payment/webpay/callback&action=failure
```

Para el archivo tbk_config.dat de KCC cambiar el parámetro HTML_TR_NORMAL

```
HTML_TR_NORMAL = http://dominio/index.php?route=payment/webpay/callback&action=check
```

# Por hacer
- Listado de transacciones en panel de administración (tabla webpay_transaction)
