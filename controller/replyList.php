<?php
require_once 'controllerBase.php';
require_once '../module/ReplyModel.php';

class ReplyList extends controllerBase {
    protected $_fields = array('qid', 'page', 'pagesize');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $condition = array();
        $page = empty($params['page']) ? 1 : $params;
        $pagesize = empty($params['pagesize']) ? 15 : $params['pagesize'];
        $replyModel = new ReplyModel();
        $condition['type'] = 1;
        if (!empty($params['qid'])) {
            $condition['qid'] = $params['qid'];
            $res = $replyModel->getReplyList($condition, $page, $pagesize);
            aj_output(ErrorMsg::SUCCESS, '', $res);
        } else {
            $res = $replyModel->getMyReplyQuestion($this->_curUser['uid'], $page, $pagesize);
            $condition['uid'] = $this->_curUser['uid'];
            $total = $replyModel->getTotalReply($condition);
            $result = array(
                'total'    => $total,
                'page'     => $page,
                'pagesize' => $pagesize,
                'list'     => $res,
            );
            if ($res === false) {
                aj_output(ErrorMsg::ERROR_SUBMIT);
            }
            aj_output(ErrorMsg::SUCCESS, '', $result);
        }
    }
}
new ReplyList();