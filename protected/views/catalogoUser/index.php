<?php
/* @var $this CatalogoUserController */
/* @var $dataProvider CActiveDataProvider */

Yii::app()->theme = 'catalogo_interno';

$this->breadcrumbs=array(
	'CatalogoUser',
);

$this->widget('bootstrap.widgets.TbButtonGroup', array(
		'buttons'=>array(
				array('label'=>'Nuevo Usuario', 'icon'=>'icon-plus', 'url'=>array('create')),
				array('label'=>'Listar Usuarios', 'icon'=>'icon-list', 'url'=>'#'),
		),
));

$this->menu=array(
	array('label'=>'Create CatalogoUser', 'url'=>array('create')),
	array('label'=>'Manage CatalogoUser', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#catalogoespecies-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Usuarios del Catalogo</h1>

<div class="tabbable"> <!-- Only required for left/right tabs -->
  
  <div class="tab-content">
       <?php echo $this->renderPartial('_catalogo_users_table', array('model'=>$model)); ?>
  </div>
</div>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
