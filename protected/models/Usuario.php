<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $codigo
 * @property integer $matricula
 * @property string $senha
 * @property integer $cod_tipo_usuario
 * @property string $data_exclusao
 *
 * The followings are the available model relations:
 * @property TipoUsuario $codTipoUsuario
 * @property LogAcesso[] $logAcessos
 */
class Usuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}
	
	public function defaultScope() {
		return array(
			'condition' => 'data_exclusao IS NULL',
			
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		$a = $this->getTableAlias(true, false);
		$c = new CDbCriteria();
		$c->condition = "$a.matricula = :matricula AND $a.data_exclusao IS NULL";
		$c->params = array(':matricula'=>$_POST['Usuario']['matricula']);
		
		return array(
			array('matricula, senha, cod_tipo_usuario', 'required'),
			array('matricula', 'unique', 'caseSensitive' => false, 'criteria'=>$c),
			array('matricula, cod_tipo_usuario', 'numerical', 'integerOnly'=>true),
			array('data_exclusao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codigo, matricula, senha, cod_tipo_usuario, data_exclusao', 'safe', 'on'=>'search'),
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
			'tipoUsuario' => array(self::BELONGS_TO, 'TipoUsuario', 'cod_tipo_usuario'),
			'logAcessos' => array(self::HAS_MANY, 'LogAcesso', 'cod_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'matricula' => 'Matrícula',
			'senha' => 'Senha',
			'cod_tipo_usuario' => 'Código do Tipo de Usuário',
			'data_exclusao' => 'Data de Exclusão',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codigo',$this->codigo);
		$criteria->compare('matricula',$this->matricula);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('cod_tipo_usuario',$this->cod_tipo_usuario);
		$criteria->compare('data_exclusao',$this->data_exclusao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
