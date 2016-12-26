<?php
/**
 * IndexController
 */
class IndexController extends BaseController {
    /**
     * controller of main website page
     *
     * @param int $page
     */
    public function indexAction($page = 1) {
        
            $param = array (
                ['layout/guest', ['' => '']],
                ['layout/menu', ['' => '']],
                ['index/index', ['article' => '', 'page' => '']]
            );
        
        $this->view->render($param);
    }
}