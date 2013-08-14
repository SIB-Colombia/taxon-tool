<?php
/* @var $this CatalogoUserController */
/* @var $model CatalogoUser */
Yii::app()->theme = 'catalogo_interno';

$this->breadcrumbs=array(
	'Catalogo Users'=>array('index'),
	$model->username,
);

$this->widget('bootstrap.widgets.TbButtonGroup', array(
		'buttons'=>array(
				array('label'=>'Listar Usuarios', 'icon'=>'icon-list', 'url'=>array('index')),
		),
));

/*$this->menu=array(
	array('label'=>'List CatalogoUser', 'url'=>array('index')),
	array('label'=>'Create CatalogoUser', 'url'=>array('create')),
	array('label'=>'Update CatalogoUser', 'url'=>array('update', 'id'=>$model->username)),
	array('label'=>'Delete CatalogoUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->username),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogoUser', 'url'=>array('admin')),
);*/
?>

<h1>Detalle de Usuario: <?php echo $model->username; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'contacto_id',
		'role',
	),
)); ?>
