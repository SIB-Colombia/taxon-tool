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

<?php 
if (!isset($gridDataProvider)) {
	$gridDataProvider = new CArrayDataProvider(array(
			array('id'=>'-', 'kingdom'=>'-', 'phylum'=>'-', 'class'=>'-', 'order'=>'-', 'family' => '-', 'genus' => '-', 'specie' => '-', 'specieid' => '-'),
	));
}
echo $this->renderPartial('_form', array('model'=>$model, 'gridDataProvider' => $gridDataProvider)); ?>

</div>