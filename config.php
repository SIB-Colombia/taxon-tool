<div class="box span12">

<div class="box-header well" data-original-title>
	<h2><i class="icon-edit"></i> Configuracion de Base de Datos</h2>
	<div class="box-icon">
		<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
		<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
	</div>
</div>

<div class="box-content">
	<form class="form-horizontal" id="config-form">
		<fieldset>
			<legend>Ingrese la informacion para el acceso y creacion de la Base de Datos</legend>
			
			<div class="control-group">
			  <label class="control-label" for="direccionInput">Direccion IP: </label>
			  <div class="controls">
				<input name = "direccion" class="input-xlarge focused" id="direccionInput" type="text" value="localhost">
			  </div>
			</div>
			
			<div class="control-group">
			  <label class="control-label" for="usuarioInput">Usuario BD: </label>
			  <div class="controls">
				<input name="usuario" class="input-xlarge focused" id="usuarioInput" type="text" value="">
				<p class="help-block">Ingrese el Usuario de la Base de Datos</p>
			  </div>
			</div>
			
			<div class="control-group">
			  <label class="control-label" for="passwordInput">Contrase&ntilde;a BD: </label>
			  <div class="controls">
				<input name="password" class="input-xlarge focused" id="passwordInput" type="password" value="">
				<p class="help-block">Ingrese la contrase&ntilde;a de la Base de Datos</p>
			  </div>
			</div>
			
			<div class="control-group">
			  <label class="control-label" for="bdnameInput">Nombre de la BD: </label>
			  <div class="controls">
				<input name="bdnombre" class="input-xlarge focused" id="bdnameInput" type="text" value="">
				<p class="help-block">Ingrese el nombre de la Base de Datos.</p>
			  </div>
			</div>
			
			<div class="form-actions">
			  <button type="submit" class="btn btn-primary" id="enviarbtn" >Enviar</button>
			  <button type="reset" class="btn">Cancelar</button>
			</div>
			
							
		</fieldset>
	</form>
</div>

</div><!--/span-->