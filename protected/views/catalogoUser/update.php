<?php
/* @var $this CatalogoUserController */
/* @var $model CatalogoUser */

Yii::app()->theme = 'catalogo_interno';
$userRole  = Yii::app()->user->getState("roles");

$this->breadcrumbs=array(
	'Catalogo Users'=>array('index'),
	$model->username=>array('view','id'=>$model->username),
	'Update',
);

if($userRole == "admin"){
	$this->widget('bootstrap.widgets.TbButtonGroup', array(
			'buttons'=>array(
					array('label'=>'Listar Usuarios', 'icon'=>'icon-list', 'url'=>array('index')),
			),
	));
}

/*$this->menu=array(
	array('label'=>'List CatalogoUser', 'url'=>array('index')),
	array('label'=>'Create CatalogoUser', 'url'=>array('create')),
	array('label'=>'View CatalogoUser', 'url'=>array('view', 'id'=>$model->username)),
	array('label'=>'Manage CatalogoUser', 'url'=>array('admin')),
);*/
?>

<h1>Modificar Usuario: <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>