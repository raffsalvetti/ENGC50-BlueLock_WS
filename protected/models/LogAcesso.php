<?php

/**
 * This is the model class for table "log_acesso".
 *
 * The followings are the available columns in table 'log_acesso':
 * @property integer $codigo
 * @property integer $cod_usuario
 * @property string $data_hora
 * @property string $acao
 *
 * The followings are the available model relations:
 * @property Usuario $codUsuario
 */
class LogAcesso extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_acesso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod_usuario, data_hora, acao', 'required'),
			array('cod_usuario', 'numerical', 'integerOnly'=>true),
			array('acao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codigo, cod_usuario, data_hora, acao', 'safe', 'on'=>'search'),
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
			'codUsuario' => array(self::BELONGS_TO, 'Usuario', 'cod_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Código',
			'cod_usuario' => 'Código de Usuário',
			'data_hora' => 'Data e Hora',
			'acao' => 'Ação',
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
		$criteria->compare('cod_usuario',$this->cod_usuario);
		$criteria->compare('data_hora',$this->data_hora,true);
		$criteria->compare('acao',$this->acao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogAcesso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
