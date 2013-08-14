<?php
/* @var $this CatalogoUserController */
/* @var $model CatalogoUser */

Yii::app()->theme = 'catalogo_interno';

$this->breadcrumbs=array(
	'Catalogo Users'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List CatalogoUser', 'url'=>array('index')),
	array('label'=>'Manage CatalogoUser', 'url'=>array('admin')),
);*/
?>

<h1>Crear Nuevo Usuario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>