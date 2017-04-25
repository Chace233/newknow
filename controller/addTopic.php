<?php

require_once 'controllerBase.php';
require_once '../module/TopicModel.php';

class AddTopic extends controllerBase {
    protected $_fields = array('title', 'intro', 'pic_url');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['title'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $addArr = array(
            'title_key' => md5($params['title']),
        );
        $topicModel = new TopicModel();
        $res = $topicModel->getTopicinfo($addArr);
        if (!empty($res)) {
            aj_output(ErrorMsg::HAVEDTITLE);
        }
        $addArr['title'] = $params['title'];
        $addArr['intro'] = empty($params['intro']) ? '' : $params['intro'];
        $addArr['pic_url'] = empty($params['intro']) ? '../template/images/test01.jpg' : $params['pic_url'];
        $addArr['creator_uid'] = $this->_curUser['uid'];
        $addArr['creator_uname'] = $this->_curUser['uname'];
        $addArr['create_time'] = time();
        $res = $topicModel->insert($addArr);
        if ($res === false) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new AddTopic();