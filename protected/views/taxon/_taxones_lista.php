<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type'=>'striped bordered condensed',
    'id'=>'taxones-grid',
    'dataProvider'=>$listTaxones,
    'ajaxUrl'=>array('taxon/busqueda'),
    'columns'=>array(
    	array( 'name'=>'id', 'header'=> 'Id'),
    	array( 'name'=>'kingdom', 'header'=> 'Kingdom'),
		array( 'name'=>'phylum', 'header'=> 'Phylum'),
    	array( 'name'=>'class', 'header'=> 'Class'),
    	array( 'name'=>'order', 'header'=> 'Order'),
		array( 'name'=>'family', 'header'=> 'Family'),
		array( 'name'=>'genus', 'header'=> 'Genus'),
    	array( 'name'=>'specie', 'header'=> 'Specie'),
    	array( 'name'=>'specieid', 'header'=> 'LSID'),
	),
)); ?>