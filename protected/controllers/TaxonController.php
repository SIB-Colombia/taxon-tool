<?php

class TaxonController extends Controller{
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('index','search','test','view'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','update'),
						'users'=>array('@'),
				),
		);
	}
	
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		
	}
	
	public function actionBusqueda(){
		$model	= new Taxontree();
		
		if(isset($_REQUEST['Taxontree']['nombresTaxones']) && $_REQUEST['Taxontree']['archivoTaxones'] == '')
		{
			$model->setNombresTaxones($_REQUEST['Taxontree']['nombresTaxones']);
			$datosTaxones = $model->search();
			
			$this->renderPartial('_taxones_lista', array('listTaxones' => $datosTaxones));
			Yii::app()->end();
			
		}else {
			$this->render('index',array('model'=>$model));
		}
	}
	
	public function actionUpdateajaxmodifyTables(){
		
	}
	
}