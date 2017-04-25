<?php

require_once 'controllerBase.php';
require_once '../module/ReplyModel.php';

class AnswerQuestion extends controllerBase {
    protected $_fields = array('qid', 'type', 'content');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['qid']) || empty($params['type']) || empty($params['content'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $replyModel = new ReplyModel();
        $res = $replyModel->getReplyList(array('qid'=>$params['qid'], 'uid'=>$this->_curUser['uid']));
        if (!empty($res)) {
            aj_output(ErrorMsg::ANSWERED);
        }
        $addArr = array(
            'qid' => $params['qid'],
            'type' => $params['type'],
            'content' => $params['content'],
            'uid'     => $this->_curUser['uid'],
            'create_time' => time(),
        );
        $this->requestHander('answer', json_encode($addArr));
        aj_output(ErrorMsg::SUCCESS);
    }
}

new AnswerQuestion();