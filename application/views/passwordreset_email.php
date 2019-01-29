<!DOCTYPE html>
<html lang="es">
<meta charset="utf-8">
<head>
</head>
<body>
	<table width="100%" style="background-color: rgb(235,235,235);">
		<tr>
			<td align="center" style="padding-top: 20px; padding-bottom: 20px;">
				<table width="600" style="width: 600px; background-color: rgb(255,255,255);">
					<thead>
						<tr>
							<td>
								<h1 style="padding-left: 32px; padding-right: 32px;">Hola <?php echo $usuario->nombre; ?></h1>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<h4 style="padding-left: 32px; padding-right: 32px;">
									Hemos recibido una solicitud de cambio de clave, si no ha sido Ud. por favor ignore este mensaje.
								</h4>
								<p style="padding-left: 32px; padding-right: 32px;">
									Para completar el cambio de clave, por favor haga click en el enlace a continuacion <a href="<?php
									echo base_url().'index.php/login/passwordreset/'.$hash;
									?>"><?php
									echo base_url().'index.php/login/passwordreset/'.$hash;
									?></a>
								</p>
								<p style="padding-left: 32px; padding-right: 32px; padding-bottom: 32px;">
									Por razones de seguridad, este enlace caducara en aproximadamente 6 horas.
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>