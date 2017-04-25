<?php
require_once 'controllerBase.php';
require_once '../module/QuestionModel.php';

class UpdateQuestion extends controllerBase {
    protected $_fields = array('qid', 'title', 'content');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['qid'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $questionModel = new QuestionModel();
        $res = $questionModel->getQuestionList(array('qid'=>$params['qid']));
        if (empty($res)) {
            aj_output(ErrorMsg::NOQUESTION);
        }
        $edisArr = array();
        if (!empty($params['title'])) {
            $edisArr['title'] = $params['title'];
            $edisArr['title_key'] = md5($params['title']);
        }
        if (!empty($params['content'])) {
            $edisArr['content'] = $params['content'];
        }
        $r = $questionModel->update($edisArr, array('qid' => $params['qid']));
        if ($r === false) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}
new UpdateQuestion();