<form action="<?php echo $action; ?>" method="post">
  <input type="hidden" name="TBK_TIPO_TRANSACCION" value="<?php echo $TBK_TIPO_TRANSACCION; ?>" />
  <input type="hidden" name="TBK_MONTO" value="<?php echo $TBK_MONTO; ?>" />
  <input type="hidden" name="TBK_ORDEN_COMPRA" value="<?php echo $TBK_ORDEN_COMPRA; ?>" />
  <input type="hidden" name="TBK_ID_SESION" value="<?php echo $TBK_ID_SESION; ?>" />
  <input type="hidden" name="TBK_URL_EXITO" value="<?php echo $TBK_URL_EXITO; ?>" />
  <input type="hidden" name="TBK_URL_FRACASO" value="<?php echo $TBK_URL_FRACASO; ?>" />
  <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
    </div>
  </div>
</form>
