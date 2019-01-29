<div class="personal">

	<?php if (isset($usuario)) { ?>
	<form id="login-form2" action="<?php echo base_url('checkout/guest') ?>" method="post">
		<p>Conectado como <strong> <?php echo $usuario ?></strong></p>
		<p>¿No es usted? <a class="logout" href="<?php echo base_url('login/logout') ?>">Cerrar sesión</a></p>
		<input type="submit" class="btn btn-primary" value="Continuar">
	</form>
	<?php } else { ?>
		<div class="options">
			<a class="guest-btn">Comprar como invitado</a>
			<a data-target="#form-register" data-toggle="modal">Iniciar sesión</a> 
		</div>

		<!-- Guest form -->
		<form id="checkout-guest-form" action="<?php echo base_url('checkout/guest') ?>" method="post">
			<div class="form-group">
				<label>
					Nombre
					<?php echo form_field('guest/nombre', 'text', $checkout) ?>
				</label>
			</div>
			<div class="form-group">
				<label>
					Apellido
					<?php echo form_field('guest/apellido', 'text', $checkout) ?>
				</label>
			</div>
			<div class="form-group">
				<label>
					Teléfono de contacto
					<?php echo form_field('guest/telefonocontacto', 'text', $checkout) ?>
				</label>
			</div>
			<div class="form-group">
				<label>
					Email
					<?php echo form_field('guest/email', 'email', $checkout) ?>
				</label>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Continuar">
			</div>
		</form>

		<?php ?>
		<!-- Login form 
		<form id="checkout-login-form" action="" method="post">
			<div class="form-group">
				<label>
					Nombre de usuario
					<input class="form-control" type="text" name="user">
				</label>
			</div>
			<div class="form-group">
				<label>
					Contraseña
					<input class="form-control" type="password" name="pass">
				</label>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Iniciar sesión">
			</div>
		</form>-->
		 
	<?php } ?>
</div>
