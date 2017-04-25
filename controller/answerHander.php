<?php
require_once 'controllerBase.php';
require_once '../module/ReplyModel.php';
require_once '../module/QuestionModel.php';
require_once '../module/ExpModel.php';
require_once '../module/FeedModel.php';

class AnswerHander extends controllerBase {

    public function __construct() {
        $this->run();
    }

    public function run() {
        $json = $this->getHander('answer');
        $data = json_decode($json);
        if (is_object($data)) {
            $data = (array)$data;
        }
        var_dump($data);
        $replyModel = new ReplyModel();
        $replyModel->startTransaction();
        $rid = $replyModel->insert($data);
        if ($rid === false) {
            $replyModel->rollback();
            return false;
        }
        if ($data['type'] == 1) {
            $questionModel = new QuestionModel();
            $res = $questionModel->addQuestionReplyNum($data['qid']);
            if ($res === false) {
                $replyModel->rollback();
                return false;
            }
        } else if ($data['type'] == 2) {
            $expModel = new ExpModel();
            $res = $expModel->addExpReplyNum($data['qid']);
            if ($res === false) {
                $replyModel->rollback();
            }
        }
        $feedModel = new FeedModel();
        $feedInfo = $feedModel->getFeedList(array('qid'=> $data['qid']));
        if (empty($feedInfo)) {
            $addFeed = array(
                'qid'         => $data['qid'],
                'uid'         => $data['uid'],
                'create_time' => time(),
                'type'        => 2,
            );
            $res = $feedModel->insert($addFeed);
            if ($res === false) {
                $replyModel->rollback();
            }
        } else {
            $editFeed = array(
                'uid'         => $data['uid'],
                'create_time' => time(),
                'type'        => 2,
            );
            $res = $feedModel->updateFeed($editFeed, $data['qid']);
            if ($res === false) {
                $replyModel->rollback();
                return false;
            }
        }
        return true;
    }
}

new AnswerHander();