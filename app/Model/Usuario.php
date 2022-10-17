<?php

App::uses('SoftDeletableModel', 'CakeSoftDelete.Model');

/**
 * Part Comunicação Online
 * Model Usuario
 */
class Usuario extends AppModel{

    public $useTable = 'usuarios';

	public $displayField = 'nome';

	/**
     * Regras de validacao
     *
     * @var array
     */
	public $validate = array(
        'usuario' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Campo obrigatório',
                'required' => true
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 100),
                'message' => 'O campo usuario deve conter no máximo 100 caracteres'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'O usuário já está sendo utilizado.'
            )
        ),
        'senha' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Campo obrigatório',
                'required' => true,
                'on' => 'create'
            ),
        ),
		'nome' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 45),
                'message' => 'O campo nome deve conter no máximo 45 caracteres'
            )
        ),
		'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Insira um e-mail válido',
                'allowEmpty' => true
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 100),
                'message' => 'O campo email deve conter no máximo 100 caracteres'
            )
		),
	);

    /**
     * Called before each save operation, after validation. Return a non-true result
     * to halt the save.
     *
     * @param array $options Options passed from Model::save().
     * @return bool True if the operation should continue, false if it should abort
     */
    public function beforeSave($options = array())
    {
        // transforma a senha utilizando hash
        if(isset($this->data['Usuario']['senha'])) {
            $this->data['Usuario']['senha'] = Security::hash($this->data['Usuario']['senha'], null, true);
        }

        return true;
    }
}