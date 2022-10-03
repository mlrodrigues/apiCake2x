<?php 
class EventosController extends AppController {

	public $components = array('RequestHandler', 'Paginator');

  public $paginate = array(
      'limit' => 10,
      'order' => ['data_inicio' => 'desc'],
  );

  public function index(){
    $this->layout = false;
    $response = [
      'status' => 'failed',
      'message' => 'Failed to process request'
    ];
    
    $this->Paginator->settings = $this->paginate;
		$result = $this->Paginator->paginate('Evento');

    if(!empty($result)){
      $response = [
        'status' => 'success',
        'data' => $result
      ];      
    }
    else{
      $response['message'] = "Eventos não encontrados";
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
      $result = $this->Evento->findById($id);
      if(!empty($result)){
        $response = [
          'status' => 'success',
          'data' => $result
        ];        
      }
      else{
        $response['message'] = "Evento não encontrado";
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
				if($this->Evento->save($data)){
					$response = [
            'status'=>'success',
            'message'=>'Evento criado com sucesso'
          ];
				}
				else{
					$response = [
            'status'=>'failed', 
            'message'=>'Evento não criado'
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
			if($this->Evento->save($this->request->data)){
				$response = [
          'status'=>'success',
          'message'=>'Evento atualiadas'
        ];
			} 
      else {
				$response = [
          'status'=>'success',
          'message'=>'Evento não atualizada'
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
				if($this->Evento->delete($id, true)){
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