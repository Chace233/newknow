<?php
require_once 'controllerBase.php';
require_once '../module/QuestionModel.php';
require_once '../module/TopicModel.php';
require_once '../module/FeedModel.php';

class QuestionHander extends controllerBase {

    public function __construct() {
        $this->run();
    }

    public function run() {
        $json = $this->getHander('question');
        $data = json_decode($json);
        if (is_object($data)) {
            $data = (array)$data;
        }
        $questionModel = new QuestionModel();
        $questionModel->startTransaction();
        $addQuestion = array(
            'title'       => $data['title'],
            'content'     => $data['content'],
            'creator_uid' => $data['creator_uid'],
            'create_time' => $data['create_time'],
            'status'      => 1,
            'title_key'   => $data['title_key'],
        );
        $qid = $questionModel->insert($addQuestion);
        if ($qid === false) {
            $questionModel->rollback();
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        $topicModel = new TopicModel();
        $addQuestionTopic = array(
            'qid'         => $qid,
            'uid'         => $data['creator_uid'],
            'uname'       => $data['uname'],
            'type'        => 1,
            'create_time' => $data['create_time'],
        );
        $feedModel = new FeedModel();
        $addFeed = array(
            'qid' => $qid,
            'uid' => $this->_curUser['uid'],
            'create_time' => time(),
            'type' => 1,
        );
        $res = $feedModel->insert($addFeed);
        if ($res === false) {
            $questionModel->rollback();
        }
        $tids = explode(',', $data['tids']);
        if (!empty($tids) && is_array($tids)) {
            foreach($tids as $tid) {
                $addQuestionTopic['tid'] = $tid;
                $resT = $topicModel->addQuestionTopic($addQuestionTopic);
                if ($resT === false) {
                    $questionModel->rollback();
                }
                $resU = $topicModel->updateQuestionNum($tid);
                if ($resU === false) {
                    $questionModel->rollback();
                }
            }
        } else {
            $tid = 0;
            $addQuestionTopic['tid'] = $tid;
            $resT = $topicModel->addQuestionTopic($addQuestionTopic);
            if ($resT === false) {
                $questionModel->rollback();
            }
            $resU = $topicModel->updateQuestionNum($tid);
            if ($resU === false) {
                $questionModel->rollback();
            }
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new QuestionHander();