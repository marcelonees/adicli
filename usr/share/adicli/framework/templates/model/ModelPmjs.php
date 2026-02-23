<?php

use Adianti\Database\TRecord;

/**
 * {CLASS} Active Record
 * @author <your name here>
 */
class {CLASS} extends TRecord
{
    const TABLENAME     = '{TABLENAME}';
    const PRIMARYKEY    = '{PRIMARYKEY}';
    const IDPOLICY      = 'serial'; // {max, serial}

    const CREATEDAT     = 'created_at';
    const UPDATEDAT     = 'updated_at';
    use SystemChangeLogTrait;

    private $system_user;

    {DINAMIC_CODE}


     /**
      * Method set_system_user
      * Sample of usage: $object->system_user = $object;
      * @param $object Instance of SystemUser
      */
     public function set_system_user(SystemUser $object)
     {
         $this->system_user = $object;
         $this->system_user_id = $object->id;
     }
    
    
     /**
      * Method get_system_user
      * Sample of usage: $object->system_user->attribute;
      * @returns SystemUser instance
      */
     public function get_system_user()
     {
         // loads the associated object
         if (empty($this->system_user)) {
             TTransaction::open('permission');
             $this->system_user = new SystemUser($this->system_user_id);

             unset($this->system_user->active);
             unset($this->system_user->password);
             unset($this->system_user->frontpage_id);
             unset($this->system_user->system_unit_id);

             TTransaction::close();
         }
    
         // returns the associated object
         return $this->system_user;
     }


     /**
      * onBeforeStore
      */    
     public function onBeforeStore($object)
     {
         $object->system_user_id = TSession::getValue('userid');
         $object->login  	 = TSession::getValue('login');

         /**
          * Verifica se o documento foi enviado via sistema ou via API REST
          */
         if (isset($_REQUEST['method']) and $_REQUEST['method'] == 'handle') {
             // Se enviado via API REST, verifica se o POST está vazio e emite um erro
             if (empty($_POST)) {
                 http_response_code(405);
                 throw new Exception('Você deve usar o endpoint correto para envio de dados.');
             }
         }

         // Grava o Log de alterações do Adianti
         $pk = $this->getPrimaryKey();
         $this->lastState = array();

         if (isset($object->$pk) and self::exists($object->$pk))
         {
             $this->lastState=parent::load($object->$pk)->toArray();
         }
     }

}
