<!-- Begin Login/Register -->
<div class="modal fade form-wrapper" id="form-register" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body mx-3">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
						<ul role="tablist" class="nav nav-tabs grid-tabs text-center">
							<li class="active"><a data-toggle="tab" role="tab" href="#login">Iniciar Sesi&oacute;n</a></li>
							<li><a data-toggle="tab" role="tab" href="#register">Registrar</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div id="login" class="tab-pane active">
							<form method="POST" action="http://localhost:8081/auth/login" accept-charset="UTF-8" class="form-block" role="form" id="login-form"><input name="_token" type="hidden" value="v1bxU2nglRdHgYwCFww9tViQ0ST1WWGx1ROF6oRH">
								<div class="modal-body mx-3">
									<div class="text-center">
										<h2>Inicio de Sesión</h2>
										
									</div>
									<div class="form-group">
										
										<input type="text" class="form-control" id="login_name" name="login_name" placeholder="Usuario/Correo electr&oacute;nico">

									</div>
									<div class="form-group">
										<label for="lpassword" class="control-label sr-only">Contraseña</label>
										<input type="password" class="form-control" id="lpassword" name="password" placeholder="Contraseña">

																</div>
									<div class="form-group text-center">
										<div class="checkbox">
											<label><input type="checkbox" name="remember"> Recordar sesión</label>
											<a href="http://localhost:8081/password/email" class="ml-20">
												<i class="fa fa-unlock-alt"></i> Perdí mi contraseña
											</a>
										</div>
									</div>
									<div class="form-group text-center">
										<button type="submit" class="btn btn-success center-block btn-block">Iniciar Sesión</button>
									</div>

								</div>
							</form>
						</div>
						<div id="register" class="tab-pane">
							<form method="POST" action="http://localhost:8081/auth/register" accept-charset="UTF-8" class="form-block" role="form" id="register-form"><input name="_token" type="hidden" value="v1bxU2nglRdHgYwCFww9tViQ0ST1WWGx1ROF6oRH">
								<div class="modal-body mx-3">
									<div class="text-center">
										<h2>Nuevo Usuario</h2>
										
									</div>
									<div class="form-group">
										<label for="name" class="control-label sr-only">Nombre</label>
										<input class="form-control" id="name" placeholder="Nombre" name="name" type="text">

									</div>
									<!--Last Name-->
									<div class="form-group">
										<label for="last_name" class="control-label sr-only">Apellido</label>
										<input class="form-control" id="last_name" placeholder="Apellido" name="last_name" type="text">
									</div>
										<!--Dni-->
									<div class="form-group">
										<label for="dni" class="control-label sr-only">CUIT o DNI</label>
										<input class="form-control" id="cuit" placeholder="CUIT o DNI" name="dni" type="text">
																</div>
									<div class="form-group">
										<label for="email" class="control-label sr-only">Correo Electrónico</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" value="">

									</div>
									<div class="form-group">
										<label for="username" class="control-label sr-only">Usuario</label>
										<input type="text" class="form-control" id="username" name="username" placeholder="Usuario" value="">
									</div>
									
									
									<div class="form-group">
										<label for="password" class="control-label sr-only">Contraseña</label>
										<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">

									</div>
									<div class="form-group">
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmación de contraseña">

									</div>
									<div class="form-group text-center">
										<button type="submit" class="btn btn-success center-block btn-block">Registrar</button>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<!-- End Login/Register -->