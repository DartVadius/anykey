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
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $_SESSION['page_num']) {
            $page = $_SESSION['page_num'];
        }
        //variable used to return to the original page
        $_SESSION['blog_page'] = $page;

        $rep = new ArticleRepository();
        $artId = $rep->findAllId();
        if (!empty($artId)) {
            $art = array();
            $listId = SupportLib::pagination($artId, $page, Application::$App->article_limit);
            foreach ($listId as $id) {
                array_push($art, $rep->findById($id['article_id']));
            }
        } else {
            $art = '';
        }
        if (!empty($_SESSION['user_id'])) {
            $param = array (
                ['layout/logged', ['' => '']],
                ['layout/menu', ['' => '']],
                ['index/index', ['article' => $art, 'page' => $page]]
            );
        } else {
            $param = array (
                ['layout/guest', ['' => '']],
                ['layout/menu', ['' => '']],
                ['index/index', ['article' => $art, 'page' => $page]]
            );
        }
        $this->view->render($param);
    }
}