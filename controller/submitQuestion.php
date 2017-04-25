<?php

require_once 'controllerBase.php';
require_once '../module/QuestionModel.php';

class SubmitQuestion extends controllerBase {
    protected $_fields = array('title', 'content', 'tids');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['title'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $condition = array(
            'title_key' => md5($params['title']),
        );
        $questionModel = new QuestionModel();
        $res = $questionModel->getQuestionList($condition);
        if (!empty($res)) {
            aj_output(ErrorMsg::HAVEDTITLE);
        }
        $condition['title'] = $params['title'];
        $condition['content'] = empty($params['content']) ? '' : $params['content'];
        $condition['creator_uid'] = $this->_curUser['uid'];
        $condition['create_time'] = time();
        $condition['uname'] = $this->_curUser['uname'];
        $condition['status'] = 1;
        $condition['tids'] = empty($params['tids']) ? '' : $params['tids'];
        $this->requestHander('question', json_encode($condition));
        aj_output(ErrorMsg::SUCCESS);
    }
}

new SubmitQuestion();