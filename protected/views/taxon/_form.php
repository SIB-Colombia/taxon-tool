<?php
/* @var $this TaxonController */
/* @var $model Taxontree */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>
<script type="text/javascript">
	var $tabs = $('.tabbable li');

	$('#prevtab').on('click', function() {
    	$tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
	});

	function buscarTaxones(id,modal,grid){
		var datos = $.trim($("#Taxontree_nombresTaxones").val());
		if(datos != ""){
			$.fn.yiiGridView.update(grid, {data: $('#'+id).serialize()});
		}else{
			return false;
			}
	}
</script>


<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'taxon-form',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
)); ?>
<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
    	<li class="active"><a href="#tab1" data-toggle="tab">Ingresar Lista</a></li>
    	<li><a href="#tab2" data-toggle="tab">Subir Archivo</a></li>
  	</ul>
  	<div class="tab-content">
  		<div class="tab-pane fade in active" id="tab1">
	  		<fieldset>
	  			<legend>Ingrese los nombres científicos.</legend>
	  			<?php echo $form->textAreaRow($model, 'nombresTaxones', array('class'=>'span6', 'rows'=>5)); ?>
	  		</fieldset>
  		</div><!-- End tab1 -->
  		
  		<div class="tab-pane fade" id="tab2">
  			<fieldset>
	  			<legend>Ingrese el archivo con los nombres.</legend>
	  			<?php echo $form->fileFieldRow($model, 'archivoTaxones'); ?>
	  		</fieldset>
  		</div><!-- End tab2 -->
  		<div class="pull-right">
		    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'type'=>'primary', 'label'=>'Buscar Taxones', 'loadingText' => 'Cargando...', 'htmlOptions' => array('id' => 'enviarData','onclick'=>'{buscarTaxones(\'taxon-form\',\'enviarData\',\'taxones-grid\')}'))); ?>
		    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Limpiar')); ?>
		    <?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Cancelar', 'submit'=>array('catalogo/index'))); ?>
		</div>
  	</div> <!-- End tab-content -->
</div><!-- End tabbable -->
<?php $this->endWidget();?>

<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
			'title' => 'Lista Taxones',
    		'headerIcon' => 'icon-th-list',
    		// when displaying a table, if we include bootstra-widget-table class
    		// the table will be 0-padding to the box
    		'htmlOptions' => array('class'=>'bootstrap-widget-table'),
    		'headerButtons' => array(
				array(
					'class' => 'bootstrap.widgets.TbButtonGroup',
					'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'buttons' => array(
						array(
							'label' => 'Exportar Datos',
							'url' => '#',
							'icon'=>'icon-plus',
							'htmlOptions' => array(
								'onclick'=>'{formularioNuevoContacto()}',
								'data-toggle' => 'modal',
								'data-target' => '#exportarTaxonesModal',
							),
						),
					)
    			),
    		)
    	));?>


<?php 
$gridDataProvider = new CArrayDataProvider(array(
		array('id'=>'-', 'kingdom'=>'-', 'phylum'=>'-', 'class'=>'-', 'order'=>'-', 'family' => '-', 'genus' => '-', 'specie' => '-', 'specieid' => '-'),
));
echo $this->renderPartial('_taxones_lista', array('listTaxones' => $gridDataProvider)); 
?>
<?php $this->endWidget();?>