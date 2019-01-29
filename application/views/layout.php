<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?php echo $title ?></title>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Font awesome -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- Bootstrap -->
		<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- JQuery UI -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<!-- Plugins -->
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/plugins.css?v=1" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/slick.css?v=1" />
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/slick-theme.css?v=1" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cssgestion/libs/pnotify/pnotify.custom.css" />

		<!-- Main styles -->
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/tienda.css?v=17" />

					<!-- Theme CSS -->
		
			<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cssgestion/css/stylesheets/theme-custom.css">
		<?php
			if (function_exists('custom_css')){
				custom_css();
			} 
		?>
		<!-- recaptcha  -->
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body>
		<div class="topbar col-md-12">
			<div class="row">
				<div class="col-sm-4 datoscontacto">
					<span style = "display: block"><?php echo $datoscontacto ?></span>
					<?php if ($telefonowhatsapp) { ?>
						<div class="telefonowhatsapp">
							<span>
								<img src="<?php echo base_url() ?>assets/img/telefonia/whatsapp.png">
								<?php echo $telefonowhatsapp ?>
							</span>
						</div>
					<?php } ?>
				</div>

				<div class="col-sm-5 search-product">
					<form id="form-search" class="form-inline" method="GET" action="<?php echo base_url() ?>Productos/search">
						<div class="input-content">
							<input type="text" id="search" name="buscar" class="form-control" placeholder="Buscar en nuestro catálogo" />
							<input type="hidden" id="id_producto" name="id_producto" class="form-control" />
							<input type="hidden" id="id_familia" name="id_familia" class="form-control" />
							<input type="hidden" id="id_categoria" name="id_categoria" class="form-control" />
							<button type="submit">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</form>
				</div>
				<?php if (!(empty($usuario))) {?>
				<div class="col-sm-3" style="color:#fff"><p style="margin: 0;text-align: right;margin-bottom: -10px;">Hola <i class="fa fa-user"></i> <strong><?php echo $usuario; ?></strong>  </p></div>

				<?php }   ?>
				<div class="col-sm-3">
					<?php if ($redessociales) { ?>
						<div class="redes">
							<?php foreach ($redessociales as $red) { ?>
								<a class="red <?php echo $red->red ?>" href="<?php echo $red->url ?>" target="_blank">
									<img alt="<?php echo $red->red ?>" title="<?php echo $red->red ?>" src="<?php echo base_url() ?>assets/img/redes/<?php echo $red->red ?>.png">
								</a>
							<?php } ?>
						</div>
					<?php } ?>


					<div class="carro">

						<?php if (empty($usuario)) {?>
							<a data-target="#form-register" data-toggle="modal" >
								<i class="fa fa-user"></i>
							</a>

						<?php }else{ ?>

						<a href="<?php echo base_url(); ?>login/logout" >
							<i class="fa fa-sign-out"></i>
						</a>

						<?php }   ?>



						<a href="<?php echo base_url('carro'); ?>">
							<span class="fa fa-shopping-cart"></span>
						</a>
						<span class="badge totalproductos"><?php echo $productosencarro ?></span>
					</div>
					

				</div>
			</div>
		</div>

		<div class="navbar col-md-12">
			<div class="logo col-md-4"><a href="<?php echo base_url() ?>"><img src="<?php echo base_url() . $logo ?>"/></a></div>
			<div class="menu col-md-8">
				<?php if ($nav) { ?>
					<ul class="nav nav-pills">
						<?php foreach ($nav as $i => $menu) {
							$class = $i == $menuactivo ? 'class="active"' : ''; ?>
							<li role="presentation" <?php echo $class ?>><a href="<?php echo $menu->href ?>"><?php echo $menu->titulo ?></a></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
		</div>

		<?php if ($banner_header) { ?>
			<div class="header col-md-12">
				<?php $this->load->view('banner', ['banner' => $banner_header]); ?>
			</div>
		<?php } ?>

		<div class="columnaa sidebar col-md-3">
			<div class="logo"><a href="<?php echo base_url() ?>"><img src="<?php echo base_url() . $logo ?>"/></a></div>
			<?php $this->load->view('banner', ['banner' => $banner_sidebar]);

			if ($categorias) { ?>
				<div class="categorias">
					<h3 class="titulo">Categorías</h3>

					<ul>
						<?php foreach ($categorias as $categoria) { ?>
							<li><a href="<?php echo base_url("categoria/$categoria->ruta") ?>"><?php echo $categoria->categoria ?></a></li>
						<?php } ?>
					</ul>
				</div>
			<?php }

			if (!empty($marcas)) { ?>
				<div class="marcas">
					<h3 class="titulo">Marcas</h3>
					<input type="hidden" name="cat_ruta" id="cat_ruta" value="<?php echo $lacategoria->ruta; ?>">
					<ul>
						<?php foreach ($marcas as $marca) { ?>
							<li><a href="<?php echo base_url('categoria/'.$lacategoria->ruta.'/'.$marca->ruta) ?>"><?php echo $marca->marca ?></a></li>
						<?php } ?>
					</ul>
				</div>
			<?php }

			if (!empty($atributos)) {
				foreach ($atributos as $key => $atributo) { ?>
				<div class="atributos">
					<h3 class="titulo"><?php echo $atributo->atributo; ?></h3>
					<form class="frm-atributos" id="frm-atributos-<?php echo $atributo->id; ?>">
						<input type="hidden" name="idatributo" value="<?php echo $atributo->id; ?>">
						<ul>
						<?php
							foreach ($tipos_atributos[$atributo->id] as $k => $tipo) {
								if (!empty($arr_atributos_valores[$key]['valores'][$k])) $valor = $arr_atributos_valores[$key]['valores'][$k];
						?>
							<li>
								<div class="checkbox">
									<label>
										<input type="checkbox" class="check_atributo" name="atributo[$atributo->id][]" value="<?php echo $tipo->id ?>" <?php echo (!empty($valor) && $valor->id == $tipo->id)? "checked" : ""; ?> > <?php echo $tipo->valor; ?>
									</label>
								</div>
							</li>
						<?php } ?>
						</ul>
					</form>
				</div>
		<?php   }
			}

			if ($masvistos) { ?>
				<div class="masvistos">
					<h1 class="titulo">Los más Vistos</h1>
					<div class="producto">
						<div class="valorados" style="float:left;"><img src="<?php echo base_url() ?>assets/uploads/1-1.jpg" width="150px"></div><div style="height:80px;"><span class="titulovalorado">Producto 1</span><br/><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella2.png" width="15px"></div>
					</div>
					<br/>
					<div class="producto">
						<div class="valorados" style="float:left;"><img src="<?php echo base_url() ?>assets/uploads/1-2.jpg" width="150px"></div><div style="height:80px;"><span class="titulovalorado">Producto 2</span><br/><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella2.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella2.png" width="15px"></div>
					</div>
					<br/>
					<div class="producto">
						<div class="valorados" style="float:left;"><img src="<?php echo base_url() ?>assets/uploads/1-3.jpg" width="150px"></div><div style="height:80px;"><span class="titulovalorado">Producto 3</span><br/><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella1.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella2.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella2.png" width="15px"><img src="<?php echo base_url() ?>assets/img/estrella2.png" width="15px"></div>
					</div>
				</div>
			<?php } ?>
		</div>

		<div class="columnab general col-md-9">
			<?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
			<?php if ($warning) echo '<div class="alert alert-warning">' . $warning . '</div>'; ?>
			<?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
			<?php $this->load->view($view) ?>
		</div>

		<div class="footer col-md-12">
			<div class="container">
				<div class="row">
					<div class="col-xs-9 col-sm-8">
						<h3>¿Quieres saber más sobre nuestros productos y servicios? No dudes en escribirnos</h3>
					</div>
					<div class="col-xs-3 col-sm-4 ">
						<h3>
							<button class="btn btn-success center-block btn-block" type="button" data-toggle="modal" data-target="#contact-form-modal">Contáctanos</button>
						</h3>
					</div>
				</div>
			</div>
			<div class="copyright"><?php echo $footer ?></div>
		</div>

		<div class="modal fade" id="contact-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="myModalLabel">Formulario de contacto</h4>
				    </div>
				    <div class="modal-body">
			        	<form id="contact-form" method="POST" action="<?php echo base_url() ?>contacto/sendContactMail">
							<div class="row">
								<div class="col-sm-12 feedback"></div>
								<div class="col-sm-6">
									<div class="form-group required">
										<label class="control-label">Nombre:</label>
										<input type="text" id="contact_name" class="form-control" name="contact_name">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group required">
										<label class="control-label">Email:</label>
										<input type="email" id="contact_email" class="form-control" name="contact_email">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group required">
										<label class="control-label">Teléfono:</label>
										<input type="text" id="contact_phone" class="form-control" name="contact_phone">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Asunto:</label>
										<input type="text" id="contact_subject" class="form-control" name="contact_subject">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group required">
										<label class="control-label">Mensaje:</label>
										<textarea class="form-control" id="contact_message" name="contact_message"></textarea>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha['key'] ?>"></div>
										<input type="hidden" name="contact_captcha">
									</div>
								</div>
							</div>
						</form>
				    </div>
				    <div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        	<button type="submit" class="btn btn-primary" form="contact-form">Enviar</button>
			      	</div>
			    </div>
		  	</div>
		</div>


		<!-- Begin Login/Register -->
		<div class="modal fade form-wrapper" id="form-register" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body mx-3">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
						<ul role="tablist" class="nav nav-tabs grid-tabs text-center">
							<li class="active" style="width: 48%;"><a data-toggle="tab" role="tab" href="#login">Iniciar Sesi&oacute;n</a></li>
							<li style="width: 48%;"><a data-toggle="tab" role="tab" href="#register" >Registrar</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div id="login" class="tab-pane active">
							<form action="" accept-charset="UTF-8" class="form-block" role="form" id="login-form" name="login-form">
								<div class="modal-body mx-3">
									<div class="text-center">
										<h2>Inicio de Sesión</h2>
										
									</div>
									<div class="form-group">
										
										<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario/Correo electrónico">

									</div>
									<div class="form-group">
										<label for="password" class="control-label sr-only">Contraseña</label>
										<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">

																</div>
									<div class="form-group text-center">
										<div class="checkbox">
	
											<a href="<?php echo base_url(); ?>login/passwordreset" class="ml-20">
												<i class="fa fa-unlock-alt"></i> Perdí mi contraseña
											</a>
										</div>
									</div>
									<div class="form-group text-center">
										<button type="submit" class="btn btn-success center-block btn-block" id="btnlogin" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Procesando">Iniciar Sesión</button>
									</div>

								</div>
							</form>
						</div>
						<div id="register" class="tab-pane">
							<form  action="" accept-charset="UTF-8" class="form-block" role="form" id="register-form" name="register-form">
								<div class="modal-body mx-3">
									<div class="text-center">
										<h2>Nuevo Usuario</h2>
										
									</div>
									<div class="form-group">
										<label for="nombre" class="control-label sr-only">Nombre</label>
										<input class="form-control" id="nombre" placeholder="Nombre" name="nombre" type="text">

									</div>
									<!--Last Name-->
									<div class="form-group">
										<label for="apellido" class="control-label sr-only">Apellido</label>
										<input class="form-control" id="apellido" placeholder="Apellido" name="apellido" type="text">
									</div>
										<!--Dni-->
									<div class="form-group">
										<label for="dni" class="control-label sr-only">CUIT o DNI</label>
										<input class="form-control" id="cuit" placeholder="CUIT o DNI" name="cuit" type="text">
																</div>
									<div class="form-group">
										<label for="email" class="control-label sr-only">Correo Electrónico</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" value="">

									</div>

									<div class="form-group">
										<label for="telefono" class="control-label sr-only">Telefono</label>
										<input type="number" class="form-control" id="telephone" name="telephone" placeholder="Número de Telefono" value="">

									</div>
									<div class="form-group">
										<label for="usuario" class="control-label sr-only">Usuario</label>
										<input type="text" class="form-control" id="usuario_registro" name="usuario_registro" placeholder="Usuario" value="">
									</div>
									
									
									<div class="form-group">
										<label for="password" class="control-label sr-only">Contraseña</label>
										<input type="password" class="form-control" id="password_registro" name="password_registro" placeholder="Contraseña">

									</div>
									<div class="form-group">
										<input type="password" class="form-control" id="password_confirmation_registro" name="password_confirmation_registro" placeholder="Confirmación de contraseña">

									</div>
									<div class="form-group text-center">
										<button type="submit" class="btn btn-success center-block btn-block" id="btnregistrar" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Registrando">Registrar</button>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Login/Register -->


		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!-- Jquery UI -->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<!-- Bootstrap's JavaScript plugins -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<!-- Plugins -->
		<script src="<?php echo base_url(); ?>assets/js/plugins.js?v=1"></script>
		<script src="<?php echo base_url(); ?>assets/js/slick.min.js?v=1"></script>
		<script src="<?php echo base_url(); ?>assets/cssgestion/libs/pnotify/pnotify.custom.js"></script>
		<!-- Main script -->
		<script>var baseurl = '<?php echo base_url() ?>';</script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tienda.js?v=19"></script>
		
		<?php $this->load->view('tracking') ?>




	</body>
</html>
