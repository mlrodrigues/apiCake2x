<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
App::uses('AppController', 'Controller');

/**
 * Part Comunicação Online
 * Controller Textos
 *
 * @property Usuario $Usuario
 */
class UsuariosController extends AppController{

	/**
	 ** @return CakeResponse|false
	**/
	public function login(){ 
		$this->layout = false;
		if(empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){
			$this->response->statusCode(401);
			$response = [
				'status'=>'failed', 
				'message'=>'Não Autorizado'
			];	
		}
	
		if($this->request->is('post')){
			$user = $this->request->input('json_decode', true);
			$this->request->data = [
				"Usuario" => [
					'usuario' => $user['Usuario']['usuario'],
					'senha' => $user['Usuario']['senha']
				]
			];
			if($this->Auth->Login()){
				$user = $this->Auth->user();
				$playload = [
					"exp" => time() + 100000,
					"iat" => time(),
					"usuario" => $user['usuario']
				];
				$key = Configure::read('Security.salt');
				$token = JWT::encode($playload, $key, 'HS256',);
				$this->response->statusCode(200);
				$response = [
					'status' => 'success',
					'data' => $token
				];
			}
			else{
				$this->response->statusCode(401);
				$response = [
					'message' => 'Usuário ou senha errada'
				];
			}
		}
		$this->response->type('application/json');
		$this->response->body(json_encode($response));
		return $this->response->send();
	}   


	public function logout(){
		$this->Auth->logout();
		return $this->redirect($this->Auth->logout);
	}

	/**
 * @return void
 */
	public function index(){
		if (isset($this->request->query['busca'])) {
			$this->paginate = array('conditions'=>array('or' => array(
				"Usuario.usuario LIKE '%{$this->request->query['busca']}%'",
				"Usuario.nome LIKE '%{$this->request->query['busca']}%'",
				"Usuario.email LIKE '%{$this->request->query['busca']}%'",
			)));
		}

		$this->set('usuarios', $this->paginate());
	}

	/**
	 * @param int $id
	 * @return void
	 */
	public function view($id = null){
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException('Usuário inválido.');
		}

		$this->set('usuario', $this->Usuario->read(null, $id));
	}

	/**
	 * @return void
	 */
	public function add(){
		if ($this->request->is('post')) {
			$this->Usuario->create();
			if ($this->Usuario->save($this->request->data)){
				$this->Flash->set('O usuário foi salvo com sucesso.', array('element' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else{
				$this->Flash->set('O usuário não pode ser salvo. Tente novamente.', array('element' => 'alert'));
			}
		}
	}

	/**
	 * @param int $id
	 * @return void
	 */
	public function edit($id = null){
		$this->Usuario->id = $id;

		if (!$this->Usuario->exists()) {
			throw new NotFoundException('Usuário inválido.');
		}
		if($this->request->is('post') || $this->request->is('put')){
			// altera a senha apenas quando o campo for preenchido
			if(empty($this->request->data['Usuario']['senha'])){
				unset($this->request->data['Usuario']['senha']);
			}
			if ($this->Usuario->save($this->request->data)) {
				$this->Flash->set('O usuário foi editado com sucesso.', array('element' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else{
				$this->Flash->set('O usuário não pode ser editado. Tente novamente.', array('element' => 'alert'));
			}
		} 
		else{
			$this->request->data = $this->Usuario->read(null, $id);
		}
	}

	/**
	 * @param int $id
	 * @return void
	 */
	public function delete($id = null){
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$this->Usuario->id = $id;

		if (!$this->Usuario->exists()) {
			throw new NotFoundException('Usuário inválido.');
		}

		if ($this->Usuario->delete()) {
			$this->Flash->set('O usuário foi excluído com sucesso.', array('element' => 'success'));
			$this->redirect(array('action' => 'index'));
		}

		$this->Flash->set('O usuário não pode ser excluído. Tente novamente.', array('element' => 'alert'));
		$this->redirect($this->referer());
	}
}