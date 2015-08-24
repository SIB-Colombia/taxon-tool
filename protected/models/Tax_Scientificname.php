<?php
/**
 * This is the model class for table "Tax_Scientificname".
 *
 * The followings are the available columns in table 'Tax_Scientificname':
 * @property integer $id
 * @property string  $scientificName
 * @property integer $darwin_id
 *
 * The followings are the available model relations:
 * @property Taxontree $taxontree
 */

class Tax_Scientificname extends CActiveRecord{
	
		
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tax_Scientificname the static model class
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
		return 'tax_scientificname';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('scientificName, darwin_id', 'required'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('scientificName, darwin_id', 'safe', 'on'=>'search')
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
			'taxontree' => array(self::BELONGS_TO, 'Taxontree', 'darwin_id'),
		);
	}
	
}