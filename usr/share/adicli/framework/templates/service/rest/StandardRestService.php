<?php

use Adianti\Service\FNAdiantiRecordService;

/**
 * {ACTIVE_RECORD}RestService REST service
 */
class {ACTIVE_RECORD}RestService extends FNAdiantiRecordService
{
    const DATABASE      = '{DATABASE}';
    const ACTIVE_RECORD = '{ACTIVE_RECORD}';


    /**
     * load($param)
     *
     * Load an Active Records by its ID
     * 
     * @return The Active Record as associative array
     * @param $param['id'] Object ID
     */
    
    
    /**
     * delete($param)
     *
     * Delete an Active Records by its ID
     * 
     * @return The Operation result
     * @param $param['id'] Object ID
     */
    
    
    /**
     * store($param)
     *
     * Save an Active Records
     * 
     * @return The Operation result
     * @param $param['data'] Associative array with object data
     */
    
    
    /**
     * loadAll($param)
     *
     * List the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['offset']    Query offset
     *        $param['limit']     Query limit
     *        $param['order']     Query order by
     *        $param['direction'] Query order direction (asc, desc)
     *        $param['filters']   Query filters (array with field,operator,field)
     */
    
    
    /**
     * deleteAll($param)
     *
     * Delete the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['filters']   Query filters (array with field,operator,field)
     */


    /**
     * função handle. Faz o redirect para demais funções.
     * 
     * Função pública. Dependendo do método utilizado, redireciona para as demais funções privadas.
     * Permite método GET. Demais métodos retornarão erro. 
     *  
     * @param array $param Contendo todo o conteúdo da requisição.
     * @route /api/{ACTIVE_RECORD}
     * @method GET -> function load
     * @header Authorization Basic REST_KEY
     * @throws 501 error se outros MÉTODOS forem usados.
     * @see load function (GET).
     * @return redirect para private functions
     */
    public function handle($param)
    {
        try {
            $method = strtoupper($_SERVER['REQUEST_METHOD']);

            unset($param['class']);
            unset($param['method']);
            $param['data'] = $param;

            if (TSession::getValue('login') == null) {
                throw new Error("You must be logged", 401);
            }

            switch ($method) {
                case 'GET':

                    if (!empty($param['id'])) {
                        return self::load($param);
                    } else {
                        return self::loadAll($param);
                    }
                    break;

                case 'POST':
                    http_response_code(501);
                    throw new Error('Cannot POST records');
                    break;

                case 'PUT':
                    http_response_code(501);
                    throw new Error('Cannot PUT records');
                    break;

                case 'PATCH':
                    http_response_code(501);
                    throw new Error('Cannot PATCH records');
                    break;

                case 'DELETE':
                    http_response_code(501);
                    throw new Error('Cannot delete records');
                    break;
            }
        } catch (Exception $e) {
            http_response_code(500);
            $object = new stdClass;
            $object->data = json_encode($e->getMessage());
            $object->status = 'Error';
            return $object;
        }
    }
}
