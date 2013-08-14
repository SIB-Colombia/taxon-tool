<?php
/* @var $this CatalogoUserController */
/* @var $model CatalogoUser */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerCoreScript('jquery.ui');
$userRole  = Yii::app()->user->getState("roles");
?>

<script type="text/javascript">
function resetForm(id) {
	$('#'+id).each(function(){
	        this.reset();
	});
}

function submitFormContactoCreate(id, modal, grid) {
	<?php echo CHtml::ajax(array(
    	'url'=>array('contactos/create'),
		'data'=> "js:$('#'+id).serialize()",
    	'type'=>'post',
    	'dataType'=>'json',
		'beforeSend' => 'function(){
			$("#"+id+"-submit").hide(500);
			$("#"+id+"-reset").hide(500);
			$("#"+modal).addClass("loading");
		}',
		'complete' => 'function(){
			$("#"+modal).removeClass("loading");
		}',
		'success'=>"function(data)
        {
        	if (data.status == 'failure')
        	{
				$('#'+id+'-submit').show(500);
				$('#'+id+'-reset').show(500);
           		$('#'+modal+' div.modal-body').html(data.respuesta);
                $('#'+modal+' div.modal-body form').submit(submitFormContactoCreate);
            }
            else
            {
                //$('#'+modal+' div.modal-body').html(data.respuesta);
				//$('#Catalogoespecies_contacto_id').val(data.idContacto);
				//$('#Catalogoespecies_personaContacto').val(data.nombreContacto);
				//$('#Catalogoespecies_organizacionContacto').val(data.organizacion);
				//$.fn.yiiGridView.update(grid, {data: $(this).serialize()});
				$('#contacto_id').html(\"<option value = \"+data.idContacto+\">\"+data.nombreContacto+\"</option>\");
                setTimeout(\"$('#contactos-form-close').click() \",3000);
            }				
        } ",
   	))?>;	
}
</script>
<div class="form">

<?php 
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'catalogo-user-form',
		'type'=>'horizontal',
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
));
?>

	<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'adicionarEditarContactoModal')); ?>
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h4>Agregar nuevo contacto</h4>
	    </div>
	 
		<div class="modal-body">
		</div>
	 
		<div class="modal-footer">    
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'type'=>'primary',
				'label'=>'Guardar',
				'url'=>array('contactos/create'),
				'buttonType'=>'submit',
				'htmlOptions'=>array('onclick'=>"{submitFormContactoCreate('contactos/create', 'contactos-form', 'adicionarEditarContactoModal', 'contactos-grid');}", 'id'=>'contactos-form-submit'),
			)); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Limpiar campos',
				'url'=>'#',
				'buttonType'=>'reset',
				'htmlOptions'=>array('onclick'=>'{resetForm(\'contactos-form\');}', 'id'=>'contactos-form-reset'),
			)); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Cerrar',
				'url'=>'#',
				'htmlOptions'=>array('data-dismiss'=>'modal', 'id'=>'contactos-form-close'),
			)); ?>
		</div>
	<?php $this->endWidget(); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	
		
		<?php 
			$action = $this->action->id;
			echo $form->textFieldRow($model, 'username', array('size'=>32,'maxlength'=>32, 'class'=>'textareaA')); 
			echo $form->passwordFieldRow($model, 'password', array('size'=>64,'maxlength'=>64, 'class'=>'textareaA'));
			if($action == "update"){
				echo $form->passwordFieldRow($model, 'newpassword', array('size'=>64,'maxlength'=>64, 'class'=>'textareaA'));
			}
			echo $form->passwordFieldRow($model, 'password2', array('size'=>64,'maxlength'=>64, 'class'=>'textareaA'));
			$disable = true;
			if($userRole == "admin"){
				$disable = false;
			}
			echo $form->dropDownListRow($model, 'role', array('admin' => 'Admin', 'editor' => 'Editor'),array('disabled'=>$disable),
				array('prompt'=>'Seleccione')
			);

			echo $form->dropDownListRow($model, 'contacto_id', $model->ListarContactos(),array('disabled'=>$disable,'prompt'=>'Seleccione')
			);

			?>
			<script type="text/javascript">
				function formularioNuevoContacto() {
					<?php echo CHtml::ajax(array(
	            		'url'=>array('contactos/create'),
	            		'data'=> array('catalogouserId' => $model->username),
	            		'type'=>'post',
	            		'dataType'=>'json',
						'beforeSend' => 'function(){
							$("#adicionarEditarContactoModal div.modal-header h4").text("Agregar nuevo contacto");
							$("#contactos-form-submit").hide(500);
							$("#contactos-form-reset").hide(500);
							$("#contactos-form-submit").attr("onClick","{submitFormContactoCreate(\'contactos-form\', \'adicionarEditarContactoModal\', \'contactos-grid\');}");
							$("#adicionarEditarContactoModal").addClass("loading");
						}',
						'complete' => 'function(){
							$("#adicionarEditarContactoModal").removeClass("loading");
							$("#contactos-form-submit").show(500);
							$("#contactos-form-reset").show(500);
						}',
	            		'success'=>"function(data)
	            		{
	                		if (data.status == 'failure')
	                		{
	                    		$('#adicionarEditarContactoModal div.modal-body').html(data.respuesta);
	                    		$('#adicionarEditarContactoModal div.modal-body form').submit(formularioNuevoContacto);
								$('#contactos-botones-internos').hide();
	                		}
	                		else
	                		{
	                    		$('#adicionarEditarContactoModal div.modal-body').html(data.respuesta);
	                		}
	 
	            		} ",
	            	))?>;		
				};

			</script>
			


				
		<div id="catalogouser-botones-internos" class="form-actions pull-right">
		<?php
			if(!$disable){
				$box = $this->beginWidget('bootstrap.widgets.TbButtonGroup', array(
					'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'buttons' => array(
							array(
								'label' => 'Contacto',
								'url' => '#',
								'icon'=>'icon-plus',
								'htmlOptions' => array(
										'onclick'=>'{formularioNuevoContacto()}',
										'data-toggle' => 'modal',
										'data-target' => '#adicionarEditarContactoModal',
								),
							),
						)
					));
				$this->endWidget();
			}
		?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'id'=>'catalogo-user-form-interno-submit', 'type'=>'primary', 'label'=>$model->isNewRecord ? 'Guardar' : 'Actualizar')); ?>
    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'id'=>'catalogo-user-form-interno-reset', 'label'=>'Limpiar campos')); ?>
    	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->