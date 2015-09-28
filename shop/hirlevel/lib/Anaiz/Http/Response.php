<?php
/**
 * Description of Response
 */
class Response {

    public function  __construct() {
    }

    

    /**
     * Static method to trigger an HTTP redirect.
     * @param string    $address    Address to be redirected to.
     */
    public static function redirect($address) {
        //if ((0 !== strpos($address, 'http://')) && (0 !== strpos($address, 'https://')) && (0 !== strpos($address, 'www.'))) {
        //}
        header('Location: ' . $address);
    }

}

class RequestParams {
    
    const EXACT_MATCH     = 'exact';
    const PARTIAL_MATCH   = 'partial';
    const NO_PARAMS       = 'no_params';
    
    protected $signature    = '';
    protected $matchType    = self::NO_PARAMS;
    protected $params       = array();

    public function  __construct($signature, $params, $matchType = self::EXACT_MATCH) {
        $this->signature = $signature;
        $this->params = $params;
        $this->matchType = $matchType;
    }

    public function __get($name) {
        return (isset($this->params[$name])) ? $this->params[$name] : null;
    }

}

class KittyController extends Controller {

    public function defaultAction() {
        $params = Request::getParams(array('recipe', 'recipe/id', 'user', 'user/id', ''));
        $params = array(
            'login' => 'User/login',
            'logout' => 'User/logout',
            'uj/recept' => 'Recipe/new',
            'recept/uj' => 'Recipe/new',
        );

    }
}


Request::setRequestAdapter(new SimpleRequestAdapter());
$controller = Request::getController();

echo Request::link('');