<?php
require_once 'controllerBase.php';
require_once '../module/ExpModel.php';

class AddExp extends controllerBase {
    protected $_fields = array('title', 'summary', 'content');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['title']) || empty($params['summary']) || empty($params['content'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $expModel = new ExpModel();
        $addArr = array(
            'title_key' => md5($params['title']),
        );
        $res = $expModel->getExpList($addArr);
        if (!empty($res)) {
            aj_output(ErrorMsg::HAVEDTITLE);
        }
        $addArr = array(
            'title_key' => md5($params['title']),
            'title'     => $params['title'],
            'summary' => $params['summary'],
            'content' => $params['content'],
            'creator_uid' => intval($this->_curUser['uid']),
            'creator_uname' => $this->_curUser['uname'],
            'create_time' => time(),
        );
        $res = $expModel->insert($addArr);
        if ($res === false) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new AddExp();