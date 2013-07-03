$("#enviarbtn").click(function(){
	var direccion = $.trim($("#direccionInput").val());
	
	if(direccion.length < 9){
		mostrarError("direccionInput", "Error en la Direccion");
		return false;
	}else if(direccion != "localhost"){
		var arrg = direccion.split(".");
		if(arrg.length == 4){
			for ( var i = 0; i < arrg.length; i++) {
				if(isNaN(arrg[i])){
					mostrarError("direccionInput", "IP debe ser numerica");
					return false;
				}
			}
			//alert("hola");
		}else{
			mostrarError("direccionInput", "Error en la Direccion");
			return false;
		}
	}
	
	var usuario = $.trim($("#usuarioInput").val());
	
	if(usuario.length <= 0){
		mostrarError("usuarioInput", "Usuario Invalido");
		return false;
	}
	
	var password = $.trim($("#passwordInput").val());
	
	var bdnombre = $.trim($("#bdnameInput").val());
	if(bdnombre.length <= 0){
		mostrarError("bdnameInput", "Nombre Invalido");
		return false;
	}	
});

$("#direccionInput").change(function (){
	quitarError("direccionInput");
});
$("#usuarioInput").change(function (){
	quitarError("usuarioInput");
});
$("#bdnameInput").change(function (){
	quitarError("bdnameInput");
});

function quitarError(nombreId){
	var div_padre = $("#"+nombreId).parent("div");
	if(div_padre.parent("div").hasClass('error')){
		div_padre.parent("div").removeClass('error')
		div_padre.children(".help-inline").remove();
	}
}

function mostrarError(nombreId, msj){
	var div_padre = $("#"+nombreId).parent("div");
	div_padre.parent("div").addClass("error");
	div_padre.append("<span class=\"help-inline\">"+ msj +"</span>");
	$("#"+nombreId).val("");
	$("#"+nombreId).focus();
	
}


$("#config-form").submit(function(){ 
	
	$.post("config_ini.php", $("#config-form").serialize(),function (data){
		if(data.success == 1){
			location.reload();
		}else if(data.error == 1){
			var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>';
				html += '<strong>Error!</strong>	'+ data.msj_error +'</div>';
				$("#config-form").append(html); 
		}
		
	}, "json");
	
	return false;
});

$("#enviaLSID").click(function (){
	var lsids = $.trim($("#entradaLSID").val());
	if(lsids.length <= 0){
		var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>';
		html += '<strong>Error!</strong>	El campo de Taxones se encuentra vacio</div>';
		$("#contentTable").append(html); 
	}else{
		$.post("search.php", {var_lsids: lsids}, function (data){
			if(data.success == 1){
				var datos = data.datos;
				if(datos.length > 0){
					var cadena = "<tbody>";
					for ( var i = 0; i < datos.length; i++) {
						cadena = cadena + "<tr>";
						cadena = cadena + "<td>"+ datos[i].name + "</td>";
						cadena = cadena + "<td>"+ datos[i].lsid + "</td>";
						cadena = cadena + "</tr>";
						
					}
					cadena = cadena + "</tbody>";
					$("#contentTable tbody").remove();
					$("#contentTable").append(cadena);
					
					
				}
				
			}else if(data.error == 1){
				var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>';
				html += '<strong>Error!</strong>	'+data.msj_error+ '</div>';
				$("#contentTable").append(html);
				
			}
			
		},"json");
	}
	
	return false;
});
