<?php
/**
 * render
 *
 * @author DartVadius
 */
class ViewLib {
    private $viewPath;
    private $layout;
    public function __construct($className) {
        preg_match_all('/[A-Z][^A-Z]*/', $className, $results);
        $controllerFolder =  strtolower(current($results[0]));
        $this->viewPath = APP . 'view/' . $controllerFolder . '/';
        $this->layout = APP . 'view/layout/' . Application::$App->layout . '.php';
    }
    private function getTemplateContent($template, $params = []) {
        extract($params);
        ob_start();
        $pathToTemplate = APP . 'view/' . $template . '.php';
        if (file_exists($pathToTemplate)) {            
            require_once $pathToTemplate;
        }
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public function render($array) {
        $content = array();        
        foreach ($array as $temp) {            
            $template = $temp[0];
            $params = $temp[1];
            array_push($content, $this->getTemplateContent($template, $params));            
        }
        if (file_exists($this->layout)) {
            require_once $this->layout;
        } 
    }


    /*
    public function render($template, $params = []) {        
        $content = $this->getTemplateContent($template, $params);
        if (file_exists($this->layout)) {
            require_once $this->layout;
        }
    }*/
    
    public function renderPartial($template, $params = []) {
        echo $this->getTemplateContent($template, $params);
    }
}