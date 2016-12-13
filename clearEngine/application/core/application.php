<?php

class Application {
    private $params = [];
    public static $App = null;
    /** @var null The controller */
    private $url_controller = null;
    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;
    /** @var array URL parameters */
    private $url_params = array();
    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct($params = []) {
        self::$App = $this;
        $this->params = $params;
        $this->loadConfig();
        session_start();
    }

    private function loadConfig() {
        $envConfigPath = APP . 'config/' . APPLICATION_ENV . '.php';
        if (file_exists($envConfigPath)) {
            $envConfig = require_once $envConfigPath;
            $this->params = array_replace_recursive($this->params, $envConfig);
        }
        define("HOST_NAME", $this->db['host']);
        define("DB_NAME", $this->db['name']);
        define("USER_NAME", $this->db['user']);
        define("PASSWORD", $this->db['password']);
        set_exception_handler(array(get_class($this), "getStaticException"));
    }
    //зачем так сложно?????
    public static function getStaticException($exception) {
        $exceptionHandlerClass = ucwords(Application::$App->exceptionController) . "Controller";
        $exceptionHandlerClass = new $exceptionHandlerClass();
        $exceptionHandlerClass->{Application::$App->exceptionAction}($exception);
    }
    public function __get($name) {
        if(isset($this->params[$name])) {
            return $this->params[$name];
        }
        return FALSE;
    }
    public function __set($name, $value) {
        $this->params[$name] = $value;
    }
    public function run() {
        // create array with URL parts in $url
        $this->splitUrl();
        // check for controller: no controller given ? then load start-page
        if (!$this->url_controller) {
            $page = new IndexController();
            $page->indexAction();
        } elseif (file_exists(APP . 'controller/' . $this->url_controller . '.php')) {
            // here we did check for controller: does such a controller exist ?
            // if so, then load this file and create this controller
            // example: if controller would be "car", then this line would translate into: $this->car = new car();
            $this->url_controller = new $this->url_controller();
            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action)) {
                if (!empty($this->url_params)) {
                    // Call the method and pass arguments to it
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                } else {
                    // If no parameters are given, just call the method without parameters, like $this->home->method();
                    $this->url_controller->{$this->url_action}();
                }
            } else {
                if (strlen($this->url_action) == 0) {
                    // no action defined: call the default index() method of a selected controller
                    $this->url_controller->indexAction();
                }
                else {
                    throw new Exception('Page not found', 404);
                }
            }
        } else {
            throw new Exception('Page not found', 404);
        }
    }
    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (isset($_GET['url'])) {
            // split URL
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            // Put URL parts into according properties
            // By the way, the syntax here is just a short form of if/else, called "Ternary Operators"
            // @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
            $this->url_controller = isset($url[0]) ? ucwords($url[0]). 'Controller' : null;
            $this->url_action = isset($url[1]) ? $url[1] . 'Action' : null;
            // Remove controller and action from the split URL
            unset($url[0], $url[1]);
            // Rebase array keys and store the URL params
            $this->url_params = array_values($url);
            // for debugging. uncomment this if you have problems with the URL
            //echo 'Controller: ' . $this->url_controller . '<br>';
            //echo 'Action: ' . $this->url_action . '<br>';
            //echo 'Parameters: ' . print_r($this->url_params, true) . '<br>';
        }
    }
}