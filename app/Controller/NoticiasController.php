<?php 
class NoticiasController extends AppController {

	public $components = array('RequestHandler');

	public function index() {
		$this->layout = false;
		$response = [
			'status' => 'failed',
			'message' => 'Failed to process request'
		];
		$result = $this->Noticia->find('all', [
			'order' => ['data' => 'desc']
		]);
		if(!empty($result)){
			$response = [
				'status' => 'success',
				'data' => $result
			];	
		}
		else{
			$response['message'] = 'Notícia não encontrada';
		}
	
		$this->response->type('application/json');
		$this->response->body(json_encode($response));

		return $this->response->send();
	}

	public function view($id) {
		$this->layout = false;
		//set default response
		$response = [
			'status'=>'failed', 
			'message'=>'Failed to process request'
		];
				
		if(!empty($id)){
			$result = $this->Noticia->findById($id);
			if(!empty($result)){
				$response = array('status'=>'success','data'=>$result);  
			}
			else{
				$response['message'] = 'Notícia não encontrada';
			}  
		}
		else{
			$response['message'] = "Insira um ID";
		}
						
		$this->response->type('application/json');
		$this->response->body(json_encode($response));
		return $this->response->send();
	}

	public function _add() {
		$this->layout = false;
		$response = array('status'=>'failed', 'message'=>'HTTP method not allowed');
		if($this->request->is('post')){
			//get data from request object
			$data = $this->request->input('json_decode', true);
			if(empty($data)){
				$data = $this->request->data;
			}
			//response if post data or form data was not passed
			$response = array('status'=>'failed', 'message'=>'Insira os dados!');
			if(!empty($data)){
				//call the model's save function
				if($this->Noticia->save($data)){
					//return success
					$response = array('status'=>'success','message'=>'Notícia criado com sucesso');
				}
				else{
					$response = array('status'=>'failed', 'message'=>'Notícia não criada');
				}
			}
		}
				
		$this->response->type('application/json');
		$this->response->body(json_encode($response));
		return $this->response->send();
	}

	public function _edit($id) {
		$this->layout = false;
		$response = array('status'=>'failed', 'message'=>'HTTP method not allowed');
		if($this->request->is('put')){
			//Código do site do cake
			$this->Noticia->id = $id;
			if($this->Noticia->save($this->request->data)){
				$response = ['status'=>'success','message'=>'Noticia atualiadas'];
			} else {
				$response = ['status'=>'success','message'=>'Noticia não atualizada'];
			}
		}
			
		$this->response->type('application/json');
		$this->response->body(json_encode($response));
		return $this->response->send();
	}

	public function _delete($id) {
		$this->layout = false;
    //set default response
    $response = array('status'=>'failed', 'message'=>'HTTP method not allowed');
    
    //check if HTTP method is DELETE
    if($this->request->is('delete')){
			//get data from request object
			$data = $this->request->input('json_decode', true);
			if(empty($data)){
				$data = $this->request->data;
			}
			
			//check if product ID was provided
			if(!empty($id)){
				if($this->Noticia->delete($id, true)){
					$response = array('status'=>'success','message'=>'Notícia deletada');
				}
			}
    }
        
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response->send();
	}
}