<form action="<?php echo base_url('checkout/direcciones') ?>" method="post">
	<fieldset>
		<legend>Dirección de facturación</legend>
    	<div class="form-group">
    		<label>
    			Dirección
    			<?php echo form_field('direcciones/f_direccion', 'text', $checkout) ?>
    		</label>
    	</div>
    	<div class="form-group">
    		<label>
    			País
    			<?php echo form_field('direcciones/f_pais', 'select', $checkout, $paises) ?>
    		</label>
    	</div>
    	<div class="form-group">		
    		<label>
    			Provincia
    			<?php echo form_field('direcciones/f_provincia', 'select', $checkout, $provincias) ?>
    		</label>
    	</div>
    	<div class="form-group">
    		<label>
    			Ciudad
    			<?php echo form_field('direcciones/f_ciudad', 'text', $checkout) ?>
    		</label>
    	</div>
    	<div class="form-group">
    		<input class="btn btn-primary" type="submit" value="<?php echo count($steps) == 2 ? 'Finalizar pedido' : 'Continuar' ?>">
    	</div>
	</fieldset>
</form>