<?php 
class InformativosController extends AppController {

	public $components = array('RequestHandler');

  public function index(){
    $this->layout = false;
    $response = [
      'status' => 'failed',
      'message' => 'Failed to process request'
    ];
    $result = $this->Informativo->find('all');
    if(!empty($result)){
      $response = [
        'status' => 'success',
        'data' => $result
      ];      
    }
    else{
      $response['message'] = "Informativos não encontrados";
    }

    $this->response->type('application/json');
    $this->response->body(json_encode($response));

    return $this->response->send();
  }

  public function view($id){
    $this->layout = false;
    $response = [
      'status' => 'failed',
      'message' => 'Falha ao processar a requisição' 
    ];

    if(!empty($id)){
      $result = $this->Informativo->findById($id);
      if(!empty($result)){
        $response = [
          'status' => 'success',
          'data' => $result
        ];        
      }
      else{
        $response['message'] = "Informativo não encontrado";
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
		$response = [
      'status'=>'failed', 
      'message'=>'HTTP method not allowed'
    ];
		if($this->request->is('post')){
			$data = $this->request->input('json_decode', true);
			if(empty($data)){
				$data = $this->request->data;
			}
			$response = [
        'status'=>'failed', 
        'message'=>'Insira os dados!'
      ];
			if(!empty($data)){
				if($this->Informativo->save($data)){
					$response = [
            'status'=>'success',
            'message'=>'Informativo criado com sucesso'
          ];
				}
				else{
					$response = [
            'status'=>'failed', 
            'message'=>'Informativo não criado'
          ];
				}
			}
		}

    $this->response->type('application/json');
		$this->response->body(json_encode($response));

		return $this->response->send();
  }

  public function _edit($id) {
		$this->layout = false;
		$response = [
      'status'=>'failed', 
      'message'=>'HTTP method not allowed'
    ];
		if($this->request->is('put')){
			$this->Noticia->id = $id;
			if($this->Informativo->save($this->request->data)){
				$response = [
          'status'=>'success',
          'message'=>'Noticia atualiadas'
        ];
			} 
      else {
				$response = [
          'status'=>'success',
          'message'=>'Noticia não atualizada'
        ];
			}
		}
			
		$this->response->type('application/json');
		$this->response->body(json_encode($response));

		return $this->response->send();
	}

  public function _delete($id) {
		$this->layout = false;
    $response = [
      'status'=>'failed', 
      'message'=>'HTTP method not allowed'
    ];

    if($this->request->is('delete')){
			$data = $this->request->input('json_decode', true);

			if(empty($data)){
				$data = $this->request->data;
			}

			if(!empty($id)){
				if($this->Informativo->delete($id, true)){
					$response = [
            'status'=>'success',
            'message'=>'Notícia deletada'
          ];  
				}
			}
    }
        
    $this->response->type('application/json');
    $this->response->body(json_encode($response));

    return $this->response->send();
	}

}