<?php
class SiteController extends Controller {
	
	public function filters() {
		return array (
				'postOnly + adicionarUsuario, editarUsuario, deletarUsuario, listarUsuarios, registrarAcesso, relatorioAcesso' 
		);
	}
	public function actionIndex() {
		$this->render ( 'index' );
	}
	public function actionAutenticar($matricula, $senha) {
		$usuario = Usuario::model()->with('tipoUsuario')->findByAttributes(array(
				'matricula' => $matricula,
				'senha' => $senha 
			)
		);
		echo CJSON::encode($usuario);
	}
	public function actionAdicionarUsuario() {
		if (isset ( $_POST ['Usuario'] )) {
			$model = new Usuario();
			$model->attributes = $_POST ['Usuario'];
			if($model->validate())
				echo CJSON::encode($model->save()?'OK':'NOK');
			else 
				echo CJSON::encode($model->getErrors());
		}
	}
	public function actionEditarUsuario() {
		if (isset ( $_POST ['Usuario'] )) {
			$model = new Usuario();
			$model->attributes = $_POST['Usuario'];
			if($model->validate())
				echo CJSON::encode($model->update()?'OK':'NOK');
			else 
				echo CJSON::encode($model->getErrors());
		}
	}
	public function actionDeletarUsuario() {
		if (isset ( $_POST ['Usuario'] )) {
			$model = Usuario::model()->findByAttributes($_POST['Usuario']);
			if($model != null) {
				$model->data_exclusao = new CDbExpression("datetime('now')");
				echo CJSON::encode($model->update()?'OK':'NOK');
			} else { 
				echo CJSON::encode('O Usuário não existe!');
			}
		}
	}
	public function actionListarUsuarios() {
		$usuarios = Usuario::model()->findAll();
		echo CJSON::encode($usuarios);
	}
	
	public function actionRegistrarAcesso() {
		if (isset ( $_POST ['LogAcesso'] )) {
			$model = new LogAcesso();
			$model->attributes = $_POST['LogAcesso'];
			$model->data_hora = new CDbExpression("datetime('now')");
			if($model->validate())
				echo CJSON::encode($model->save()?'OK':'NOK');
			else 
				echo CJSON::encode($model->getErrors());
		}
	}
	
	public function actionRelatorioAcesso() {
		$sql = "SELECT 
					u.matricula, la.data_hora, la.acao 
				FROM 
					log_acesso la
				JOIN usuario u 
					ON u.codigo = la.cod_usuario AND u.data_exclusao IS NULL
				ORDER 
					BY la.data_hora";
		$cmd = new CDbCommand(Yii::app()->db, $sql);
		$ds = $cmd->queryAll();
		echo CJSON::encode($ds);
	}
	
	public function actionError() {
		if ($error = Yii::app ()->errorHandler->error) {
			if (Yii::app ()->request->isAjaxRequest)
				echo $error ['message'];
			else
				$this->render ( 'error', $error );
		}
	}
}