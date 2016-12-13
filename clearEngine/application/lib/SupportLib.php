<?php

/**
 * supportLib
 *
 * @author DartVadius
 */
class SupportLib {
    
    /**
     * pagination
     * 
     * @param array $obj array of all ID`s in the specified table in database
     * @param int $page
     * @param int $limit
     * @return boolean | array of ID`s on specified  page
     */
    public static function pagination(array $obj, $page, $limit) {        
        $objCount = count($obj);
        $pages = ceil($objCount / $limit);
        $_SESSION['page_num'] = $pages;
        if ($page <= 0) {
            $page = 1;
        }
        if ($page > $pages) {
            $page = $pages;
        }
        $start = $page * $limit - $limit;
        $output = array_slice($obj, $start, $limit);
        if (!empty($output)) {
            return $output;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * 
     * @param string $id name of ID folder in DB
     * @param string $parent_id name of parent ID folder in DB     
     * @param string $table  table name in DB
     * @return array
     */
    public static function tree($id, $parent_id, $table) {
        $pdo = PDOLib::getInstance()->getPdo();
        $sql = "SELECT * FROM " . $table;
        $res = $pdo->query($sql);
        $category = $res->fetchAll();        
        $tree = [['children' => []]];
        $references = [&$tree[0]];
        foreach($category as $item) {
            if(isset($references[$item[$id]])) {
                $item['children'] = $references[$item[$id]]['children'];
            }
            $references[$item[$parent_id]]['children'][] = $item;
            $references[$item[$id]] =& $references[$item[$parent_id]]['children'][count($references[$item[$parent_id]]['children']) - 1];
        }         
        return $tree[0]['children'];
    }    
}
