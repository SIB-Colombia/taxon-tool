<?php
/* @var $this TaxonController */
/* @var $model Taxontree */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.uploadify.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/uploadify.css');
?>
<script type="text/javascript">
	var $tabs = $('.tabbable li');
	var dataSearch = "";
	var dataExport;
	var datos 		= "";
	var datosFile	= "";

	$('#prevtab').on('click', function() {
    	$tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
	});

	$(function() {
	    $('#Taxontree_archivoTaxones').uploadify({
	    	'buttonText'	: '<?php echo Yii::t('app', 'Seleccionar Archivo');?>',
	    	'width'         : 140,
	    	'fileTypeExts'  : '*.xlsx;*.xls;*.txt;*.csv',
	    	'multi'			: false,
	    	'swf'      		: '<?=Yii::app()->theme->baseUrl;?>/scripts/uploadify.swf',
	        'uploader' 		: '<?=Yii::app()->theme->baseUrl;?>/scripts/uploadify.php',
			'onUploadComplete' : function(file){
				$.post("readFile", {archivo: file.name, tipo: file.type},function(data){
					
					$("#Taxontree_datosExportar").val(data);
					$.fn.yiiGridView.update('taxones-grid', {data: {Taxontree: {archivoData : data}}});
					/*$.post("createData", {dataTaxon: data},function(data){
						$.fn.yiiGridView.update('taxones-grid', {data: {Taxontree: {archivoData : data}}});
					});*/
					//$.fn.yiiGridView.update('taxones-grid', {data: {Taxontree: {nombresTaxones : data}}});
				});
			}
	    });
	});

	function buscarTaxones(id,modal,grid){
		datos 		= $.trim($("#Taxontree_nombresTaxones").val());
		datosFile 	= $.trim($("#Taxontree_archivoTaxones").val());

		if(datosFile != ""){
			if(window.FormData){
				return false;
			}
		}else if(datos != ""){
			$("#Taxontree_datosExportar").val(datos);
			$.fn.yiiGridView.update(grid, {data: {Taxontree: {archivoData : datos}}});
			/*$.post("createData", {dataTaxon: datos},function(data){
				$.fn.yiiGridView.update(grid, {data: {Taxontree: {archivoData : data}}});
			});*/
		}else{
			return false;
		}
	}

	function exportarTabla(){
		$('#taxon-form-data').submit();
	}
</script>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'taxon-form-data',
    'action' => 'exportData',
	'htmlOptions'=>array('name' => 'datos'),
    'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model, 'datosExportar'); ?>
<?php $this->endWidget();?>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'taxon-form',
    'type'=>'horizontal',
	'htmlOptions'=>array('enctype'=>'multipart/form-data','name' => 'prueba'),
    'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
)); ?>
<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
    	<li class="active"><a href="#tab1" data-toggle="tab"><?php echo Yii::t('app', 'Ingresar Lista');?></a></li>
    	<li><a href="#tab2" data-toggle="tab"><?php echo Yii::t('app', 'Subir Lista');?></a></li>
    	<li><a href="#tab3" data-toggle="tab"><?php echo Yii::t('app', 'Instrucciones');?></a></li>
    	<li><a href="#tab4" data-toggle="tab"><?php echo Yii::t('app', 'Acerca de');?></a></li>
  	</ul>
  	<div class="tab-content">
  		<div class="tab-pane fade in active" id="tab1">
	  		<fieldset>
	  			<legend><?php echo Yii::t('app', 'Ingrese el archivo con los nombres.');?></legend>
	  			<?php echo $form->textAreaRow($model, 'nombresTaxones', array('class'=>'span6', 'rows'=>5)); ?>
	  		</fieldset>
  		</div><!-- End tab1 -->
  		
  		<div class="tab-pane fade" id="tab2">
  			<fieldset>
	  			<legend><?php echo Yii::t('app', 'Ingrese el archivo con los nombres.');?></legend>
	  			<?php echo $form->fileFieldRow($model, 'archivoTaxones'); ?>
	  		</fieldset>
  		</div><!-- End tab2 -->
  		
  		<div class="tab-pane fade" id="tab3">
  		<fieldset>
	  			<legend><?php echo Yii::t('app', 'Instrucciones');?></legend>
	  			<ul class="genericList">
	  				<li><?php echo Yii::t('app', 'Ingrese los nombres pegandolos en el cuadro de texto, un nombre por línea. Recuerde que la lista solo debe contener una columna con el nombre sin calificadores de identificación (ej. sp. o spp.) preferiblemente sin autoría y sin caracteres o espacios adicionales, también puede cargar la lista de nombres en formato Excel (.xlsx) o Texto (.txt) en la pestaña Subir Lista');?></li>
	  				<li><?php echo Yii::t('app', 'Haga clic en BUSCAR.');?></li>
	  				<li><?php echo Yii::t('app', 'Si lo desea puede descargar su resultado en formato Excel (.xlsx) haciendo clic en el botón Exportar datos.');?></li>
	  				<li><?php echo Yii::t('app', 'Recuerde que el límite de la herramienta es de 5000 nombres, si desea hacer la consulta para una cantidad mayor por favor contáctenos.');?></li>
	  			</ul>
	  		</fieldset>
  		</div><!-- End tab3 -->
  		
  		<div class="tab-pane fade" id="tab4">
  		<fieldset>
	  			<legend><?php echo Yii::t('app', 'Acerca de la herramienta');?></legend>
	  			
	  			<h3><?php echo Yii::t('app', '¿Qué es?');?></h3>
	  			<br/>
	  			<p><?php echo Yii::t('app', 'Es una herramienta asistida para la obtención de las categorías taxonómicas con su respectivo nombre, autoría y LSIDs.');?></p>
	  			
	  			<h3><?php echo Yii::t('app', '¿Qué es un LSID?');?></h3>
	  			<br/>
	  			<p><?php echo Yii::t('app', 'El LSID (Life Science Identifier) es un identificador alfanumérico  global, único y persistente que es usado en la comunidad científica para referirse a un objeto.');?></p>
	  			<p><?php echo Yii::t('app', 'Por ejemplo: los siguientes nombres científicos poseen un identificador en Catalogue of Life');?> (<a href="http://www.catalogueoflife.org">http://www.catalogueoflife.org</a>)</p>
	  			<h6 style="text-align: center;">urn:lsid:&lt;autoridad&gt;:&lt;EspacioParaNombre&gt;:&lt;IdDelObjeto&gt;:[version]urn:lsid:ncbi.nlm.nig.gov:GenBank:T48601:2]</h6>
	  			
	  			<h3><?php echo Yii::t('app', '¿De dónde se obtiene la información?');?></h3>
	  			<br/>
	  			<p><?php echo Yii::t('app', 'La información se obtiene del recurso <a href="http://www.catalogueoflife.org">"Catalogue of Life"</a> publicado en GBIF, versión 2015-02-14');?> </p>
	  			
	  			<h3><?php echo Yii::t('app', '¿Para qué sirve esta herramienta?');?></h3>
	  			<br/>
	  			<p><?php echo Yii::t('app', 'La herramienta automatiza las siguientes tareas');?>:</p>
	  			<ul class="genericList">
	  				<li><?php echo Yii::t('app', 'Obtención de los LSID, estos son usados bajo el esquema de publicación usado por el SiB Colombia como un identificador único, global y persistente del nombre a publicar');?>.</li>
	  				<li><?php echo Yii::t('app', 'Obtención de las categorías taxonómicas con su respectivo nombre y la autoría');?>.</li>
	  			</ul>
	  			
	  			<h3><?php echo Yii::t('app', 'Limitaciones y alcances');?></h3>
	  			<br>
	  			<p><?php echo Yii::t('app', 'El límite de nombres que pueden someterse por búsqueda es de 5000. Si para un nombre determinado no se encuentra una coincidencia en Catalogue of Life (2012) el LSID y la taxonomía superior serán generados');?>.</p>

	  			<h3><?php echo Yii::t('app', 'Código fuente');?></h3>
	  			<br/>
	  			<p><?php echo Yii::t('app', 'El código fuente se encuentra disponible de libre acceso y uso  a través del repositorio de GitHub del');?> <a href="https://github.com/SIB-Colombia/taxon-tool">SiB Colombia</a></p>
	  			<p><?php echo Yii::t('app', 'La base de datos de esta  herramienta fue creada usando el convertidor Darwin Core to SQL desarrollador por <a href="https://github.com/Canadensys/dwca2sql">Canadensys</a>');?></p>
	  			<h3><?php echo Yii::t('app', 'Contacto');?></h3>
	  			<br/>
	  			<p><?php echo Yii::t('app', 'Agradecemos cualquier comentario o sugerencia al correo electrónico');?>: sib@humboldt.org.co</p>
	  		</fieldset>
  		</div><!-- End tab4 -->
  		
  		<div class="pull-right">
		    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'type'=>'primary', 'label'=> Yii::t('app', 'Buscar'), 'loadingText' => 'Cargando...', 'htmlOptions' => array('id' => 'enviarData','onclick'=>'{buscarTaxones(\'taxon-form\',\'enviarData\',\'taxones-grid\')}'))); ?>
		    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>Yii::t('app', 'Limpiar'))) ?>
		    <?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Cancelar', 'submit'=>array('catalogo/index'))); ?>
		</div>
  	</div> <!-- End tab-content -->
</div><!-- End tabbable -->
<?php $this->endWidget();?>

<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
			'title' => Yii::t('app', 'Resultados'),
    		'headerIcon' => 'icon-th-list',
    		// when displaying a table, if we include bootstra-widget-table class
    		// the table will be 0-padding to the box
    		'htmlOptions' => array('class'=>'bootstrap-widget-table', 'style'=>'min-width:1115px'),
    		'headerButtons' => array(
				array(
					'class' => 'bootstrap.widgets.TbButtonGroup',
					'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'buttons' => array(
						array(
							'label' => Yii::t('app', 'Exportar Datos'),
							'url' => '#',
							'icon'=>'icon-plus',
							'htmlOptions' => array(
								'onclick'=>'{exportarTabla()}',
								'data-toggle' => 'modal',
								'data-target' => '#exportarTaxonesModal',
							),
						),
					)
    			),
    		)
    	));?>


<?php 
echo $this->renderPartial('_taxones_lista', array('listTaxones' => $gridDataProvider)); 
?>
<?php $this->endWidget();?>