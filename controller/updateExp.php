<?php
require_once 'controllerBase.php';
require_once '../module/ExpModel.php';

class UpdateExp extends controllerBase {
    protected $_fields = array('eid', 'title', 'summary', 'content');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['eid'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $editArr = array();
        if (!empty($params['title'])) {
            $editArr['title_key'] = md5($params['title']);
            $expModel = new ExpModel();
            $res = $expModel->getExpList($editArr);
            if (!empty($res)) {
                aj_output(ErrorMsg::HAVEDTITLE);
            }
            $editArr['title'] = $params['title'];
        }
        if (!empty($params['summary'])) {
            $editArr['summary'] = $params['summary'];
        }
        if (!empty($params['content'])) {
            $editArr['content'] = $params['content'];
        }
        $res = $expModel->update($editArr, array('eid'=>$params['eid']));
        if ($res === false) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new UpdateExp();