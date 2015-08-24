<?php
/**
 * This is the model class for table "tax_darwinrecord".
 *
 * The followings are the available columns in table 'tax_darwinrecord':
 * @property integer $taxonID
 * @property string $identifier
 * @property string $datasetID
 * @property string $datasetName
 * @property string $acceptedNameUsageID
 * @property string $parentNameUsageID
 * @property string $taxonomicStatus
 * @property string $taxonRank
 * @property string $verbatimTaxonRank
 * @property string $scientificName
 * @property string $kingdom
 * @property string $phylum
 * @property string $class
 * @property string $tax_order
 * @property string $superfamily
 * @property string $family
 * @property string $genericName
 * @property string $genus
 * @property string $subgenus
 * @property string $specificEpithet
 * @property string $infraspecificEpithet
 * @property string $scientificNameAuthorship
 * @property string $tax_source
 * @property string $namePublishedln
 * @property string $nameAccordingTo
 * @property string $modified
 * @property string $description
 * @property string $taxonConceptID
 * @property string $scientificNameID
 * @property string $tax_references
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
	private $datosExportar;
	private $datosMap;
	
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
		return 'tax_darwinrecord';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				//array('name, rank, lsid', 'required'),
				//array('taxon_id, parent_id, number_of_children, total_species_estimation, total_species', 'numerical', 'integerOnly'=>true),
				//array('name, rank, lsid', 'length', 'max'=>255),
				array('archivoTaxones','file','maxSize' => 20000,'types' => 'txt'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				//array('taxon_id, name, rank, parent_id, lsid, string', 'safe', 'on'=>'search')
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
			'taxon_scientific' => array(self::HAS_MANY, 'Tax_Scientificname', 'darwin_id')
			//'taxon_detail' => array(self::HAS_MANY, 'Taxon_Detail', 'taxon_id')
			//'author_string' => array(self::HAS_ONE, 'Author_String', 'string')
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				/*'taxonId' => 'ID del Taxón',
				'identifier'	=> 'Spec',
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
				'Kingdom_id'	=> 'Kingdom ID',*/
				'kingdom'	=> 'Kingdom',
				'nombresTaxones' => Yii::t('app', 'Ingrese hasta 5000 nombres'),
				'archivoTaxones' => Yii::t('app', 'Archivo de Nombres')
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		if ($this->nombresTaxones != '') {
			$nombresTaxones=str_replace("\n","<br>",$this->nombresTaxones);
			$lsid_ar = explode("<br>", $nombresTaxones);
			$this->datosMap = array();
			for ($i = 0; $i < count($lsid_ar); $i++) {
				$this->datosMap[trim($lsid_ar[$i])] = trim($lsid_ar[$i]);
			}
			
			if(count($lsid_ar) > 0){
				$criteria = new CDbCriteria;
				
				for ($i = 0; $i < count($lsid_ar); $i++) {
					if($i == 0){
						$condicion = "txs.scientificName = '".trim($lsid_ar[$i])."'";
					}else{
						$condicion .= " OR txs.scientificName = '".trim($lsid_ar[$i])."'";
					}
				}

				$lsids_result	= Yii::app()->db->createCommand()
					->select('txs.scientificName as name,txd.*')
					->from('taxon_db.tax_scientificname txs')
					->join('taxon_db.tax_darwinrecord txd','txs.darwin_id = txd.taxonID')
					->where($condicion)
					->queryAll();

				if(isset($lsids_result)){
					
					$dataProvider = array();
					$this->datosExportar = $lsids_result;
					//$keysData = array_keys($datos_ar);
					$i=0;
					foreach ($lsids_result as $data){
						
						$dataProvider[$i]['id'] 				= $data['taxonID'];
						$dataProvider[$i]['name']				= (isset($data['name'])) ? $data['name'] : "-";
						$dataProvider[$i]['kingdom']			= (isset($data['kingdom'])) ? $data['kingdom'] : "-";
						$dataProvider[$i]['phylum']				= (isset($data['phylum'])) ? $data['phylum'] : "-";
						$dataProvider[$i]['class']				= (isset($data['class']))? $data['class'] : "-";
						$dataProvider[$i]['order']				= (isset($data['tax_order'])) ? $data['tax_order'] : "-";
						$dataProvider[$i]['family']				= (isset($data['family'])) ? $data['family'] : "-";
						$dataProvider[$i]['genus']				= (isset($data['genus'])) ? $data['genus'] : "-";
						$dataProvider[$i]['epitetoes']			= (isset($data['specificEpithet'])) ? $data['specificEpithet'] : "-";
						$dataProvider[$i]['epitetoin']			= (isset($data['infraspecificEpithet'])) ? $data['infraspecificEpithet'] : "-";
						$dataProvider[$i]['rank']				= (isset($data['taxonRank'])) ? $data['taxonRank'] : "-";
						$dataProvider[$i]['author']				= (isset($data['scientificNameAuthorship'])) ? $data['scientificNameAuthorship'] : "-";
						$dataProvider[$i]['scientificName']		= (isset($data['scientificName'])) ? $data['scientificName'] : "-";
						$dataProvider[$i]['identifier']			= (isset($data['identifier'])) ? $data['identifier'] : "-";
						$i += 1;
					}
					
					
					$gridDataProvider = new CArrayDataProvider($dataProvider);
					
					return $gridDataProvider;
					//echo $lsids_result->name;
				}
				
			}
		}
	}
	
	function searchData(){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("`t`.`taxon_id` = ".$this->taxon_id);
		$lsids_result = $this->findAll($criteria);
		return $lsids_result;
	}
	
	function  init_datos($datos = Array()){
		for ($i = 0; $i < 10; $i++) {
			$datos[$i]	= Array("name" => "-","lsid" => "-");
		}
	
		return $datos;
	
	}
	
	function getLSIDS($datos = Array(), $name = "", $lsid = "", $rank = "", $parent_id = 0, $author = ""){
	
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
				if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
					$epitetos			= explode(" ", $name);
					$datos[9]["name"] 	= $name;
					$datos[0]["name"] 	= $name." ".$author;
					$datos[0]["lsid"]	= $lsid;
					$datos[1]["name"]	= $rank;
					$datos[1]["lsid"]	= $author;
					$datos[2]["name"]	= (isset($epitetos[1])) ? $epitetos[1] : $epitetos[0];
					$datos[2]["lsid"]	= (isset($epitetos[2])) ? (isset($epitetos[3]))? $epitetos[3]: $epitetos[2] : "-";
				}
				return  $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "genus":
				if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
					$epitetos			= explode(" ", $name);
					$datos[9]["name"] 	= $name;
					$datos[0]["name"] 	= $name." ".$author;
					$datos[0]["lsid"]	= $lsid;
					$datos[1]["name"]	= $rank;
					$datos[1]["lsid"]	= $author;
				}
				$datos[3]["name"] 	= $name;
				$datos[3]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "family":
				if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
					$epitetos			= explode(" ", $name);
					$datos[9]["name"] 	= $name;
					$datos[0]["name"] 	= $name." ".$author;
					$datos[0]["lsid"]	= $lsid;
					$datos[1]["name"]	= $rank;
					$datos[1]["lsid"]	= $author;
				}
				$datos[4]["name"] 	= $name;
				$datos[4]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "order":
				if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
					$epitetos			= explode(" ", $name);
					$datos[9]["name"] 	= $name;
					$datos[0]["name"] 	= $name." ".$author;
					$datos[0]["lsid"]	= $lsid;
					$datos[1]["name"]	= $rank;
					$datos[1]["lsid"]	= $author;
				}
				$datos[5]["name"] 	= $name;
				$datos[5]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "class":
				if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
					$epitetos			= explode(" ", $name);
					$datos[9]["name"] 	= $name;
					$datos[0]["name"] 	= $name." ".$author;
					$datos[0]["lsid"]	= $lsid;
					$datos[1]["name"]	= $rank;
					$datos[1]["lsid"]	= $author;
				}
				$datos[6]["name"] 	= $name;
				$datos[6]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "phylum":
				if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
					$epitetos			= explode(" ", $name);
					$datos[9]["name"] 	= $name;
					$datos[0]["name"] 	= $name." ".$author;
					$datos[0]["lsid"]	= $lsid;
					$datos[1]["name"]	= $rank;
					$datos[1]["lsid"]	= $author;
				}
				$datos[7]["name"] 	= $name;
				$datos[7]["lsid"]	= $lsid;
				return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				break;
	
			case "kingdom":
				if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
					$epitetos			= explode(" ", $name);
					$datos[9]["name"] 	= $name;
					$datos[0]["name"] 	= $name." ".$author;
					$datos[0]["lsid"]	= $lsid;
					$datos[1]["name"]	= $rank;
					$datos[1]["lsid"]	= $author;
				}
				$datos[8]["name"] 	= $name;
				$datos[8]["lsid"]	= $lsid;
				return $datos;
				break;
	
			default:
				if($parent_id != 0){
					if($datos[0]["name"] == '' || $datos[0]["name"] == "-"){
						$epitetos			= explode(" ", $name);
						$datos[9]["name"] 	= $name;
						$datos[0]["name"] 	= $name." ".$author;
						$datos[0]["lsid"]	= $lsid;
						$datos[1]["name"]	= $rank;
						$datos[1]["lsid"]	= $author;
						$datos[2]["name"]	= (isset($epitetos[1])) ? $epitetos[1] : $epitetos[0];
						$datos[2]["lsid"]	= (isset($epitetos[2])) ? (isset($epitetos[3]))? $epitetos[3]: $epitetos[2] : "-";
					}
					return $this->getLSIDS($datos, $parent_name, $parent_lsid, $parent_rank, $parent_id_p);
				}
				break;
		}
	
	}
	
	public function ordenarTaxon($datos = array()){
		for ($i = 0; $i < count($datos); $i++) {
			$this->datosMap[$datos[$i][9]['name']] = $datos[$i];
		}
		return $this->datosMap;
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
	
	public function getDatosExportar(){
		return $this->datosExportar;
	}
	
	public function setDatosExportar($value){
		$this->datosExportar = $value;
	}
	
	public function getDatosMap(){
		return $this->datosMap;
	}
	
	public function setDatosMap($value){
		$this->datosMap = $value;
	}
}