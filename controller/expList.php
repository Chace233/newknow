<?php
require_once 'controllerBase.php';
require_once '../module/ExpModel.php';

class ExpList extends controllerBase {
    protected $_fields = array('eid', 'page', 'pagesize');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $condition = array();
        $expModel = new ExpModel();
        if (isset($params['eid']) && !empty($params['eid'])) {
            $condition['eid'] = $params['eid'];
            $result = $expModel->getExpList($condition);
        } else {
            $condition['uid'] = $this->_curUser['uid'];
            $page = empty($page) ? 1 : $params['page'];
            $pagesize = empty($pagesize) ? 15 : $params['pagesize'];
            $res = $expModel->getExpList($condition, $page, $pagesize);
            $total = $expModel->getTotalExp($condition);
            $result = array(
                'total' => $total,
                'page'  => $page,
                'pagesize' => $pagesize,
                'list'     => $res,
            );
        }
        aj_output(ErrorMsg::SUCCESS, '', $result);
    }
}

new ExpList();