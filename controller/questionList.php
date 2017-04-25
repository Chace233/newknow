<?php
require_once 'controllerBase.php';
require_once '../module/QuestionModel.php';

class QuestionList extends controllerBase {
    protected $_fields = array('qid','page', 'pagesize');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $questionModel = new QuestionModel();
        $conditions = array();
        if (isset($params['qid'])) {
            $conditions['qid'] = $params['qid'];
            $result = $questionModel->getQuestionList($conditions);
        } else {
            $conditions['uid'] = $this->_curUser['uid'];
            $page = empty($params['page'])? 1 : $params['page'];
            $pagesize = empty($params['pagesize'])? 15 : $params['pagesize'];
            $res = $questionModel->getQuestionList($conditions, $page, $pagesize);
            $total = $questionModel->getTotalQuestion($conditions);
            $result = array(
                'total' => $total,
                'page'  => $page,
                'pagesize' => $pagesize,
                'list'  => $res,
            );
        }
        aj_output(ErrorMsg::SUCCESS, '', $result);
    }
}

new QuestionList();