<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components =[
		'Flash',
		'Session',
		'Auth' => [
			'loginAction' => "/usuarios/login",
			'loginRedirect' => ['controller' => 'noticias', 'action' => 'index'],
			'authenticate' => [
				'Form' => [
					'userModel' => 'Usuario',
					'fields' => ['username' => 'usuario', 'password' => 'senha']
				]
			],	
			'authError' => 'Acesso restrito',
			'flash' => ['key' => 'auth', 'element' => 'alert', 'clear' => true],
			'ADmad/JwtAuth.Jwt' => [
				'scope' => ['Usuarios.ativo' => 1],
				'parameter' => '_token',
				'userModel' => 'Usuarios',
				'fields' => [
					'username' => 'usuario',
					'password' => 'senha'
				],
			],
		],
		'Cookie',
	];

	function beforeFilter() {
		$jwt = explode(" ", $_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
		
		if($jwt[0] == ''){
			$this->response->statusCode(401);
			$response = [
				'status'=>'failed', 
				'message'=>'Não Autorizado'
			];	
			return $response;
		}
		else{
			try{			
				JWT::decode($jwt[1], new Key(Configure::read('Security.salt'), 'HS256'));
			}
			catch (Exception $e){
				$this->Auth->logout();
				return $this->redirect($this->Auth->logout);
			}
		}
	}
}