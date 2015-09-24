<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
  	<div class="content">
	  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	    <table class="form">
          <tr>
	        <td><span class="required">*</span> <?php echo $entry_cnpj; ?></td>
	        <td><input name="jadlog_cnpj" type="text" id="jadlog_cnpj" value="<?php echo $jadlog_cnpj; ?>" />
	         <?php if ($error_cnpj) { ?>
	         <span class="error"><?php echo $error_cnpj; ?></span>
	         <?php  } ?>
	        </td>
	      </tr>
		  <tr>
	        <td><span class="required">*</span> <?php echo $entry_password; ?></td>
	        <td><input name="jadlog_password" type="text" id="jadlog_password" value="<?php echo $jadlog_password; ?>" />
	         <?php if ($error_password) { ?>
	         <span class="error"><?php echo $error_password; ?></span>
	         <?php  } ?>
	        </td>
	      </tr>
	      <tr>
	        <td><span class="required">*</span> <?php echo $entry_cep_origem; ?></td>
	        <td><input name="jadlog_cep_origem" type="text" id="jadlog_cep_origem" value="<?php echo $jadlog_cep_origem; ?>" />
	         <?php if ($error_cep_origem) { ?>
	         <span class="error"><?php echo $error_cep_origem; ?></span>
	         <?php  } ?>
	        </td>
	      </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_servicos; ?></td>
            <td>
	        <?php if ($error_servico) { ?>
	        <span class="error"><?php echo $error_servico; ?></span>
	        <?php  } ?>              
            <div class="scrollbox">
                <?php $class = 'odd'; ?>
                <div class="even">
                  <?php if ($jadlog_0) { ?>
                  <input type="checkbox" name="jadlog_0" value="1" checked="checked" />
                  <?php echo $text_expresso; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_0" value="1" />
                  <?php echo $text_expresso; ?>
                  <?php } ?>
                </div>
                <div class="odd">
                  <?php if ($jadlog_3) { ?>
                  <input type="checkbox" name="jadlog_3" value="1" checked="checked" />
                  <?php echo $text_package; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_3" value="1" />
                  <?php echo $text_package; ?>
                  <?php } ?>
                </div>
                <div class="even">
                  <?php if ($jadlog_4) { ?>
                  <input type="checkbox" name="jadlog_4" value="1" checked="checked" />
                  <?php echo $text_rodoviario; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_4" value="1" />
                  <?php echo $text_rodoviario; ?>
                  <?php } ?>
                </div>
                <div class="odd">
                  <?php if ($jadlog_5) { ?>
                  <input type="checkbox" name="jadlog_5" value="1" checked="checked" />
                  <?php echo $text_economico; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_5" value="1" />
                  <?php echo $text_economico; ?>
                  <?php } ?>
                </div>
                <div class="even">
                  <?php if ($jadlog_6) { ?>
                  <input type="checkbox" name="jadlog_6" value="1" checked="checked" />
                  <?php echo $text_doc; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_6" value="1" />
                  <?php echo $text_doc; ?>
                  <?php } ?>
                </div> 
                <div class="odd">
                  <?php if ($jadlog_7) { ?>
                  <input type="checkbox" name="jadlog_7" value="1" checked="checked" />
                  <?php echo $text_corporate; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_7" value="1" />
                  <?php echo $text_corporate; ?>
                  <?php } ?>
                </div>                 
                <div class="even">
                  <?php if ($jadlog_9) { ?>
                  <input type="checkbox" name="jadlog_9" value="1" checked="checked" />
                  <?php echo $text_com; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_9" value="1" />
                  <?php echo $text_com; ?>
                  <?php } ?>
                </div> 
                <div class="odd">
                  <?php if ($jadlog_10) { ?>
                  <input type="checkbox" name="jadlog_10" value="1" checked="checked" />
                  <?php echo $text_internacional; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_10" value="1" />
                  <?php echo $text_internacional; ?>
                  <?php } ?>
                </div> 
                <div class="odd">
                  <?php if ($jadlog_12) { ?>
                  <input type="checkbox" name="jadlog_12" value="1" checked="checked" />
                  <?php echo $text_cargo; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_12" value="1" />
                  <?php echo $text_cargo; ?>
                  <?php } ?>
                </div> 
                <div class="even">
                  <?php if ($jadlog_14) { ?>
                  <input type="checkbox" name="jadlog_14" value="1" checked="checked" />
                  <?php echo $text_emergencial; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="jadlog_14" value="1" />
                  <?php echo $text_emergencial; ?>
                  <?php } ?>
                </div> 
          	</div>
         	</td>
          </tr>	      
          <tr>
	        <td><?php echo $entry_tipo_seguro; ?></td>
            <td><select name="jadlog_tipo_seguro">
                <?php if ($jadlog_tipo_seguro == "N") { ?>
                <option value="N" selected="selected"><?php echo $text_normal; ?></option>
                <option value="A"><?php echo $text_apolice; ?></option>
                <?php } else if ($jadlog_tipo_seguro == "A") { ?>
                <option value="N"><?php echo $text_normal; ?></option>
                <option value="A" selected="selected"><?php echo $text_apolice; ?></option>
                <?php } else { ?>
                <option value="N" selected="selected"><?php echo $text_normal; ?></option>
                <option value="A"><?php echo $text_apolice; ?></option>
                <?php } ?>
                </select>
			</td>
	      </tr>
          <tr>
	        <td><?php echo $entry_valor_coleta; ?></td>
	        <td><input name="jadlog_valor_coleta" type="text" id="jadlog_valor_coleta" value="<?php echo $jadlog_valor_coleta; ?>" size="6" />
	        </td>
	      </tr>
          <tr>
	        <td><?php echo $entry_valor_adicional; ?></td>
	        <td><input name="jadlog_valor_adicional" type="text" id="jadlog_valor_adicional" value="<?php echo $jadlog_valor_adicional; ?>" size="6" />
	        </td>
	      </tr> 
          <tr>
	        <td><?php echo $entry_tipo_entrega; ?></td>
            <td><select name="jadlog_tipo_entrega">
                <?php if ($jadlog_tipo_entrega == "R") { ?>
                <option value="R" selected="selected"><?php echo $text_retirada; ?></option>
                <option value="D"><?php echo $text_domicilio; ?></option>
                <?php } else if ($jadlog_tipo_entrega == "D") { ?>
                <option value="R"><?php echo $text_retirada; ?></option>
                <option value="D" selected="selected"><?php echo $text_domicilio; ?></option>
                <?php } else { ?>
                <option value="R"><?php echo $text_retirada; ?></option>
                <option value="D" selected="selected"><?php echo $text_domicilio; ?></option>
                <?php } ?>
                </select>
			</td>
	      </tr>
          <tr>
	        <td><?php echo $entry_frete_pagar; ?></td>
            <td><select name="jadlog_frete_pagar">
                <?php if ($jadlog_frete_pagar == "S") { ?>
                <option value="S" selected="selected"><?php echo $text_yes; ?></option>
                <option value="N"><?php echo $text_no; ?></option>
                <?php } else if ($jadlog_frete_pagar == "N") { ?>
                <option value="S"><?php echo $text_yes; ?></option>
                <option value="N" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="S"><?php echo $text_yes; ?></option>
                <option value="N" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
                </select>
			</td>
	      </tr>
	      <tr>
	        <td><?php echo $entry_tax; ?></td>
	        <td><select name="jadlog_tax_class_id">
	          <option value="0"><?php echo $text_none; ?></option>
	          <?php foreach ($tax_classes as $tax_class) { ?>
	          <?php if ($tax_class['tax_class_id'] == $jadlog_tax_class_id) { ?>
	          <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
	          <?php } else { ?>
	          <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
	          <?php } ?>
	          <?php } ?>
	        </select></td>
	      </tr>
	      <tr>
	        <td><?php echo $entry_geo_zone; ?></td>
	        <td><select name="jadlog_geo_zone_id">
	            <option value="0"><?php echo $text_all_zones; ?></option>
	            <?php foreach ($geo_zones as $geo_zone) { ?>
	            <?php if ($geo_zone['geo_zone_id'] == $jadlog_geo_zone_id) { ?>
	            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
	            <?php } else { ?>
	            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
	            <?php } ?>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <td width="25%"><?php echo $entry_status; ?></td>
	        <td><select name="jadlog_status">
	            <?php if ($jadlog_status) { ?>
	            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	            <option value="0"><?php echo $text_disabled; ?></option>
	            <?php } else { ?>
	            <option value="1"><?php echo $text_enabled; ?></option>
	            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <td><?php echo $entry_sort_order; ?></td>
	        <td><input type="text" name="jadlog_sort_order" value="<?php echo $jadlog_sort_order; ?>" size="1" /></td>
	      </tr>
	    </table>
	  </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/jquery/jquery.meio.mask.js"></script> 
<script type="text/javascript"><!--
$(function(){
    $('input[name="jadlog_cnpj"]').setMask({
		mask :'99999999999999'                
	});
    $('input[name="jadlog_cep_origem"]').setMask({
		mask :'99999-999'
	});
	$('input[name="jadlog_valor_coleta"]').setMask({
		mask :'99,99',
        type : 'reverse', 
        defaultValue : '0'		
	}); 
    $('input[name="jadlog_valor_adicional"]').setMask({
		mask :'99,99',
        type : 'reverse', 
        defaultValue : '0'		
	}); 
});
//--></script> 
<?php echo $footer; ?>