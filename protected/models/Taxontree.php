<?php
/**
 * This is the model class for table "_taxon_tree".
 *
 * The followings are the available columns in table '_taxon_tree':
 * @property integer $taxon_id
 * @property string $name
 * @property string $rank
 * @property integer $parent_id
 * @property string $lsid
 * @property integer $number_of_children
 * @property integer $total_species_estimation
 * @property integer $total_species
 * @property string estimate_source
 *
 */

class Taxontree extends CActiveRecord{
	
	private $genus;
	private $genus_id;
	private $family;
	private $family_id;
	private $order;
	private $order_id;
	private $class;
	private $class_id;
	private $phylum;
	private $phylum_id;
	private $kingdom;
	private $kingdom_id;
	private $nombresTaxones;
	private $archivoTaxones;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Catalogoespecies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '_taxon_tree';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('name, rank, lsid', 'required'),
				array('taxon_id, parent_id, number_of_children, total_species_estimation, total_species', 'numerical', 'integerOnly'=>true),
				array('name, rank, lsid', 'length', 'max'=>255),
				array('archivoTaxones','file','maxSize' => 2000,'types' => 'txt'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('taxon_id, name, rank, parent_id, lsid', 'safe', 'on'=>'search')
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'taxon_id' => 'ID del Taxón',
				'name'	=> 'Specie',
				'lsid'	=> 'Specie ID',
				'genus'	=> 'Genus',
				'genus_id'	=> 'Genus ID',
				'family'	=> 'Family',
				'family_id'	=> 'Family ID',
				'order'	=> 'Order',
				'order_id'	=> 'Order ID',
				'class'	=> 'Class',
				'class_id'	=> 'Class ID',
				'phylum'	=> 'Phylum',
				'phylum_id'	=> 'Phylum ID',
				'kingdom'	=> 'Kingdom',
				'Kingdom_id'	=> 'Kingdom ID',
				'nombresTaxones' => 'Nombres Científicos',
				'archivoTaxones' => 'Archivo de Nombres'
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		if ($this->nombresTaxones != '') {
			$this->nombresTaxones=str_replace("\r","<br>",$this->nombresTaxones);
			$lsid_ar = explode("<br>", $this->nombresTaxones);
			
			if(count($lsid_ar) > 0){
				$criteria = new CDbCriteria;
				
				for ($i = 0; $i < count($lsid_ar); $i++) {
					if($i == 0){
						$condicion = "name LIKE '".trim($lsid_ar[$i])."'";
					}else{
						$condicion .= " OR name LIKE '".trim($lsid_ar[$i])."'";
					}
				}
				
				$criteria->addCondition($condicion);
				$criteria->order = "name ASC";
				
				$lsids_result = $this->findAll($criteria);
				if(isset($lsids_result)){
					$datos_ar = Array();
					for ($i = 0; $i < count($lsids_result); $i++) {
						$datos = $this->init_datos();
						$datos_ar[] = $this->getLSIDS($datos, $lsids_result[$i]->name, $lsids_result[$i]->lsid, $lsids_result[$i]->rank, $lsids_result[$i]->parent_id);
					}
					
					$dataProvider = array();
						
					for ($i = 0; $i < count($datos_ar); $i++) {
						$dataProvider[$i]['id'] = $i + 1;
						$dataProvider[$i]['kingdom'] = $datos_ar[$i][6]['name'];
						$dataProvider[$i]['phylum'] = $datos_ar[$i][5]['name'];
						$dataProvider[$i]['class'] = $datos_ar[$i][4]['name'];
						$dataProvider[$i]['order'] = $datos_ar[$i][3]['name'];
						$dataProvider[$i]['family'] = $datos_ar[$i][2]['name'];
						$dataProvider[$i]['genus'] = $datos_ar[$i][1]['name'];
						$dataProvider[$i]['specie'] = $datos_ar[$i][0]['name'];
						$dataProvider[$i]['specieid'] = $datos_ar[$i][0]['lsid'];
					}
					//print_r($dataProvider);
					$gridDataProvider = new CArrayDataProvider($dataProvider);
					
					return $gridDataProvider;
					//echo $lsids_result->name;
				}
				
			}
		}
	}
	
	function  init_datos($datos = Array()){
		for ($i = 0; $i < 7; $i++) {
			$datos[$i]	= Array("name" => "-","lsid" => "-");
		}
	
		return $datos;
	
	}
	
	function getLSIDS($datos = Array(), $name = "", $lsid = "", $rank = "", $parent_id = 0){
	
		$parent_name = "";
		$parent_lsid = "";
		$parent_id_p = 0;
		$parent_rank = "";
	
		if ($parent_id != 0) {
			$criteria = new CDbCriteria;
			$criteria->addCondition("taxon_id = ".$parent_id);
			$result = $this->find($criteria);
				
			if($result){
				$parent_name = $result->name;
				$parent_lsid = $result->lsid;
				$parent_id_p = $result->parent_id;
				$parent_rank = $result->rank;
			}
		}
		switch ($rank) {
			case "species":
				$datos[0]["name"] 	= $name;
				$datos[0]["lsid"]	= $lsid;
				return  $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "genus":
				$datos[1]["name"] 	= $name;
				$datos[1]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "family":
				$datos[2]["name"] 	= $name;
				$datos[2]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "order":
				$datos[3]["name"] 	= $name;
				$datos[3]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "class":
				$datos[4]["name"] 	= $name;
				$datos[4]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "phylum":
				$datos[5]["name"] 	= $name;
				$datos[5]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "kingdom":
				$datos[6]["name"] 	= $name;
				$datos[6]["lsid"]	= $lsid;
				return $datos;
				break;
	
			default:
				if($parent_id != 0){
					return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				}
				break;
		}
	
	}
	
	public function getNombresTaxones() {
		return $this->nombresTaxones;
	}
	
	public function setNombresTaxones($value)
	{
		$this->nombresTaxones = $value;
	}
	
	public function getArchivoTaxones() {
		return $this->archivoTaxones;
	}
	
	public function setArchivoTaxones($value)
	{
		$this->archivoTaxones = $value;
	}
}