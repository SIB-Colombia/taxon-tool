<?php
Yii::app()->theme = 'taxon_sib';
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/speciesSpecial.css');
?>
<div id="twopartheader">
<?php 
	$this->breadcrumbs=array(
			'Taxon'=>array('index'),
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>