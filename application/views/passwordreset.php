<?php
$hash = (isset($hash) && preg_match('/^[a-zA-Z0-9]{32}$/i',$hash) ) ? $hash : null;
?>

	<!-- start: page -->
	<div class="col-sm-8">
			<div class="panel panel-sign">
				<div class="panel-title-sign mt-xl text-right">
					<h2 class="title text-uppercase text-bold m-none" ><i class="fa fa-key mr-xs"></i> Password reset</h2>
				</div>
				<div class="panel-body">
					<form id="passwordreset" action="<?php echo base_url(); ?>login/forgotpass" method="POST">	
						
						<?php
							if( !$hash ){
							
						?>
						<div class="form-group">
							<label class="form-label">Por favor ingrese su usuario o correo electr&oacute;nico</label>
							<div class="input-group login-input">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="usuario_reset" id="usuario_reset" class="form-control" placeholder="Usuario/Email"> 
							</div>
						</div>

						<button type="submit" class="btn btn-lg btn-success btn-block" name='btnforgotpass' id='btnforgotpass' data-loading-text="<i class='fa fa-spinner fa-spin '></i> Procesando">Recuperar clave</button>
						<p class="text-center"><br><a href="<?php echo base_url(); ?>">Volver al Inicio</a></p>
						<?php

						}
						else {
						?>
						<h3>Establezca su nueva contrase&ntilde;a</h3>
						<div class="form-group">
							<div class="input-group login-input">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" name="nueva_clave" id="nueva_clave" class="form-control" placeholder="Nueva clave"> 
							</div>
						</div>

						<div class="form-group">
							<div class="input-group login-input">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" name="nueva_clave_confirm" id="nueva_clave_confirm" class="form-control" placeholder="Confirmar clave"> 
							</div>
						</div>
						<button type="submit" class="btn btn-lg btn-success btn-block" name='forgotpass' id='forgotpass' data-loading-text="<i class='fa fa-spinner fa-spin '></i> Registrando">Cambiar clave</button>
						<?php
						}
						?>
						<div class="clearfix"></div>
						
					
					</form>
				</div>
			</div>
			<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All Rights Reserved.</p>
		
	</div>
	<!-- end: page -->

