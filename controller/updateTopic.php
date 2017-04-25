<?php

require_once 'controllerBase.php';
require_once '../module/TopicModel.php';

class UpdateTopic extends controllerBase {
    protected $_fields = array('tid', 'title', 'intro', 'pic_url');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['tid'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $topicModel = new TopicModel();
        $res = $topicModel->getTopicinfo(array('tid'=>$params['tid']));
        if (empty($res)) {
            aj_output(ErrorMsg::NOTOPIC);
        }
        $editArr = array();
        if (!empty($params['title'])) {
            $editArr['title'] = $params['title'];
            $editArr['title_key'] = md5($params['title']);
        }
        if (!empty($params['intro'])) {
            $editArr['intro'] = $params['intro'];
        }
        if (!empty($params['pic_url'])) {
            $editArr['pic_url'] = $params['pic_url'];
        }
        if (!empty($editArr)) {
            $res = $topicModel->update($editArr, array('tid'=>$params['tid']));
            if ($res === false) {
                aj_output(ErrorMsg::ERROR_SUBMIT);
            }
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new UpdateTopic();