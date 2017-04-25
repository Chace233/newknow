<?php

require_once "Model.php";

class TopicModel extends Model {
    protected $_tbName = '`tblTopic`';
    protected $_tblQuestionTopic = '`tblquestiontopic`';
    protected $_tblQuestions = '`tblQuestions`';

    public function __construct() {

    }

    public function getTopicinfo($condition, $page=1, $pagesize=20) {
        $sql = "SELECT `tid`, `title`, `intro`, `pic_url`, `creator_uid`, `creator_uname`, `create_time`, `status`, `follower_num`, `question_num`, `isclear`
                FROM " . $this->_tbName ;
        $whereArr = array();
        if (!empty($condition['tid'])) {
            $whereArr['tid'] = "`tid` = " . $condition['tid'];
        }
        if (!empty($condition['title_key'])) {
            $whereArr['title_key'] = "`title_key` = '" . $condition['title_key'] . "'";
        }
        if (!empty($condition['uid'])) {
            $whereArr['creator_uid'] = "`creator_uid` = " . $condition['uid'];
        }
        $whereArr['status'] = "`status` = 0";
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $sql .= ' ORDER BY `create_time` DESC LIMIT ' . ($page-1)*$pagesize . " , " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    public function getQuestionsOfTipic($condition, $page=1, $pagesize=15) {
        $sql = "SELECT qt.`tid`, qt.`qid`, qt.`uid`, qt.`uname`, q.`title`, q.`content`, q.`create_time`, q.`reply_num`, q.`follower_num`, q.`browser_num`
                FROM " . $this->_tblQuestionTopic . " AS `qt` LEFT JOIN " . $this->_tblQuestions . " AS `q` ON qt.`qid` = q.`qid`";
        $whereArr = array();
        if (!empty($condition['tid'])) {
            $whereArr['tid'] = "qt.`tid` = " . $condition['tid'];
        }
        if (!empty($condition['type'])) {
            $whereArr['type'] = 'qt.`type` = ' . $condition['type'];
        } else {
            $whereArr['type'] = 'qt.`type` = 1';
        }
        $whereArr['status'] = "q.`status` = 1";
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(" AND ", $whereArr);
        }
        $sql .= " ORDER BY qt.`create_time` DESC LIMIT " . ($page-1) * $pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    public function addQuestionTopic($addArr) {
        $this->insertRaw($addArr, $this->_tblQuestionTopic);
    }

    public function updateQuestionNum($tid) {
        $sql = "UPDATE " . $this->_tbName . "
                SET `question_num` = `question_num` + 1
                WHERE `tid` = " . $tid;
        $res = $this->Query($sql);
        return $res;
    }
}