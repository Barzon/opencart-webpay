<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
   <div class="page-header">
      <div class="container-fluid">
         <div class="pull-right">
            <button type="submit" form="form-webpay" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $mod_title; ?></h1>
            <ul class="breadcrumb">
               <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                  <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
               <?php } ?>
            </ul>
         </div>
      </div>
      <div class="container-fluid">
         <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
               <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
         <?php } ?>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            
            <div class="panel-body">
               <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-webpay" class="form-horizontal">
                  <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-merchant"><span data-toggle="tooltip" title="<?php echo $help_cgi_url; ?>"><?php echo $label_cgi_url; ?></span></label>
                     <div class="col-sm-10">
                        <input placeholder="http://www.example.com/cgi-bin/tbk_bp_pago.cgi" type="text" name="webpay_cgi_url" value="<?php echo $webpay_cgi_url; ?>" class="form-control" />
                        <?php if ($error_cgi_url) { ?>
                           <div class="text-danger"><?php echo $error_cgi_url; ?></div>
                        <?php } ?>
                     </div>
                  </div>
                  
                  <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-merchant"><span data-toggle="tooltip" title="<?php echo $help_checkmac_path; ?>"><?php echo $label_checkmac_path; ?></span></label>
                     <div class="col-sm-10">
                        <input placeholder="/var/www/example.com/cgi-bin/tbk_bp_pago.cgi" type="text" name="webpay_checkmac_path" value="<?php echo $webpay_checkmac_path; ?>" class="form-control" />
                        <?php if ($error_checkmac_path) { ?>
                           <div class="text-danger"><?php echo $error_checkmac_path; ?></div>
                        <?php } ?>
                     </div>
                  </div>
                  
                  <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-merchant"><span data-toggle="tooltip" title="<?php echo $help_success_url; ?>"><?php echo $label_success_url; ?></span></label>
                     <div class="col-sm-10">
                        <input placeholder="http://www.example.com/index.php?route=payment/webpay/callback&action=success" type="text" name="webpay_success_url" value="<?php echo $webpay_success_url; ?>" class="form-control" />
                        <?php if ($error_success_url) { ?>
                           <div class="text-danger"><?php echo $error_success_url; ?></div>
                        <?php } ?>
                     </div>
                  </div>
                  
                   <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-merchant"><span data-toggle="tooltip" title="<?php echo $help_failure_url; ?>"><?php echo $help_failure_url; ?></span></label>
                     <div class="col-sm-10">
                        <input placeholder="http://www.example.com/index.php?route=payment/webpay/callback&action=failure" type="text" name="webpay_failure_url" value="<?php echo $webpay_failure_url; ?>" class="form-control" />
                        <?php if ($error_failure_url) { ?>
                           <div class="text-danger"><?php echo $error_failure_url; ?></div>
                        <?php } ?>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label class="col-sm-2 control-label"><?php echo $label_order_status_id; ?></label>
                     <div class="col-sm-10">
                        <select class="form-control" name="webpay_order_status_id">
                        	<?php foreach ($order_statuses as $os): ?>
                        		<?php if ($webpay_order_status_id == $os['order_status_id']): ?>
                        			<option selected value="<?php echo $os['order_status_id']; ?>"><?php echo $os['name']; ?></option>
                        		<?php else: ?>
                        			<option value="<?php echo $os['order_status_id']; ?>"><?php echo $os['name']; ?></option>
                        		<?php endif; ?>
                        	<?php endforeach; ?>
                        </select>
                     </div>
                  </div>
                  
                  <div class="form-group">
                     <label class="col-sm-2 control-label"><?php echo $label_status; ?></label>
                     <div class="col-sm-10">
                        <select class="form-control" name="webpay_status">
                           <option value="0" <?php if ($webpay_status == 0) echo 'selected'; ?>><?php echo $text_disabled; ?></option>
                           <option value="1" <?php if ($webpay_status == 1) echo 'selected'; ?>><?php echo $text_enabled; ?></option>
                        </select>
                     </div>
                  </div>

               </form>
            </div>
         </div>
      </div>
   </div>
<?php echo $footer; ?> 