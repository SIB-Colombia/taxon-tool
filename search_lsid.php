<div class="box span12">
	<div class="box-header well" data-original-title>
		<h2><i class="icon-list-alt"></i> Consultar LSID</h2>
		<div class="box-icon">
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
		</div>
	</div>
	
	<div class="box-content">
		<div class="page-header">
		  <h1>Consultar LSID</h1>
	 	</div>
	 	
	 	<div class="row-fluid ">
	 		<div class="span4">
				<p>Ingrese los nombres de los taxones en cuadro de texto de la izquierda, luego de click en Obtener LSID.</p>
				<p>A continuaci&oacute;n aparecer&aacute; una tabla con el LSID de la especie.</p>
			</div> 
	 	</div>
	 	
	 	<div class="box span3" style="border: none; box-shadow: none">
	 	<h3 style="float: left;">Taxones</h3>
	 	<a id="enviaLSID" class="btn btn-success" href="" style="float: right; margin-bottom: 20px"><i class="icon-download-alt icon-white"></i> Obtener LSIDs</a>
	 	<textarea class="autogrow" rows="15" style="" id="entradaLSID" name="entradaLSID"></textarea>
	 	</div>
	 	
	 	<div class="box span8">
	 		<div class="box-header well" data-original-title>
				<h2><i class="icon-tags"></i> Resultado</h2>
				<div class="box-icon">
					<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
					<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
				</div>
			</div>
			
			<div class="box-content" >
				<table class="table" id="contentTable">
					<thead>
						<tr>
						  <th>Especie</th>
						  <th>LSID</th>
						</tr>
					</thead>
				</table>
			</div>
			
	 	</div>
	 	 
	</div>
</div><!--/span-->