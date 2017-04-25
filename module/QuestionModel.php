<?php

/*
 * question model
 */
require_once 'Model.php';

class QuestionModel extends Model {
    protected $_tbName = '`tblQuestions`';
    protected $_tbUser = '`tblUser`';

    public function __construct() {

    }

    public function getQuestionList($condition, $page=1, $pagesize=15) {
        $sql = "SELECT q.`qid`, q.`title`, q.`content`, q.`create_time`, q.`reply_num`, q.`follower_num`, q.`browser_num`, u.`uname`, u.`feature`, u.`headpic`
                FROM " . $this->_tbName . " AS `q` LEFT JOIN " . $this->_tbUser . " AS `u` ON q.`creator_uid` = u.`uid`";
        $whereArr = array();
        if (!empty($condition['qid'])) {
            if (is_array($condition['qid'])) {
                $whereArr['qid'] = "q.`qid` IN (" . implode(', ' , $condition['qid']) . ")";
            } else {
                $whereArr['qid'] = "q.`qid` = " . $condition['qid'];
            }
        }
        if (!empty($condition['title'])) {
            $whereArr['title'] = "q.`title` LIKE %" . $condition['title'] . "%";
        }
        if (!empty($condition['title_key'])) {
            $whereArr['title_key'] = "q.`title_key` = '" . $condition['title_key'] . "'";
        }
        if (!empty($condition['uid'])) {
            $whereArr['creator_uid'] = "q.`creator_uid` = " . $condition['uid'] . "";
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $sql .= " ORDER BY q.`create_time` DESC LIMIT " . ($page-1)*$pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    public function getTotalQuestion ($condition) {
        $sql = "SELECT COUNT(q.`qid`) AS `total`
                FROM " . $this->_tbName . " AS `q` ";
        $whereArr = array();
        if (!empty($condition['qid'])) {
            if (is_array($condition['qid'])) {
                $whereArr['qid'] = "q.`qid` IN (" . implode(', ' , $condition['qid']) . ")";
            } else {
                $whereArr['qid'] = "q.`qid` = " . $condition['qid'];
            }
        }
        if (!empty($condition['title'])) {
            $whereArr['title'] = "q.`title` LIKE %" . $condition['title'] . "%";
        }
        if (!empty($condition['title_key'])) {
            $whereArr['title_key'] = "q.`title_key` = '" . $condition['title_key'] . "'";
        }
        if (!empty($condition['uid'])) {
            $whereArr['creator_uid'] = "q.`creator_uid` = " . $condition['uid'] . "";
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $res = $this->Query($sql);
        return current($res[0]);
    }

    public function addQuestionReplyNum($qid) {
        $sql = "UPDATE " . $this->_tbName . " SET `reply_num` = `reply_num` + 1 WHERE `qid` = " . $qid;
        $res = $this->querySql($sql);
        return $res;
    }
}