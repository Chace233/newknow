<?php

require_once 'Model.php';

class ReplyModel extends Model {
    protected $_tbName = '`tblReply`';
    protected $_tbQuestions = '`tblQuestions`';
    protected $_tbUser = '`tblUser`';

    public function getReplyList($condition, $page=1, $pagesize=15) {
        $sql = "SELECT r.`rid`, r.`content`, r.`qid`, r.`type`, r.`uid`, r.`create_time`, r.`vote_num`, u.`uname`, u.`headpic`
                FROM " . $this->_tbName . " AS `r` LEFT JOIN " . $this->_tbUser . " AS `u` ON r.`uid` = u.`uid`";
        $whereArr = array();
        if (!empty($condition['qid'])) {
            if (is_array($condition['qid'])) {
                $whereArr['qid'] = "r.`qid` IN (" . implode(',', $condition['qid']) . ")";
            } else {
                $whereArr['qid'] = "r.`qid` = " . $condition['qid'];
            }
        }
        if (!empty($condition['type'])) {
            $whereArr['type'] = "r.`type` = " . $condition['type'];
        }
        if (!empty($condition['uid'])) {
            $whereArr['uid'] = "r.`uid` = " . $condition['uid'];
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $sql .= " ORDER BY r.`create_time` DESC LIMIT " . ($page-1)*$pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    public function getTotalReply($condition) {
        $sql = "SELECT COUNT(r.`rid`) AS `total`
                FROM " . $this->_tbName . " AS `r` ";
        $whereArr = array();
        if (!empty($condition['qid'])) {
            if (is_array($condition['qid'])) {
                $whereArr['qid'] = "r.`qid` IN (" . implode(',', $condition['qid']) . ")";
            } else {
                $whereArr['qid'] = "r.`qid` = " . $condition['qid'];
            }
        }
        if (!empty($condition['type'])) {
            $whereArr['type'] = "r.`type` = " . $condition['type'];
        }
        if (!empty($condition['uid'])) {
            $whereArr['uid'] = "r.`uid` = " . $condition['uid'];
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $res = $this->Query($sql);
        return current($res[0]);
    }

    /**
     * @param $uid
     * @param int $page
     * @param int $pagesize
     * @return 成功返回结果
     */
    public function getMyReplyQuestion($uid, $page=1, $pagesize=15) {
        $sql = "SELECT q.`title`, r.`qid`, r.`rid`, r.`type`, r.`content`, r.`create_time`
                FROM " . $this->_tbName . " AS `r` LEFT JOIN " . $this->_tbQuestions . " AS `q` ON r.`qid` = q.`qid`
                WHERE r.`uid` = " . $uid . "
                AND r.`type` = 1
                ORDER BY `create_time` DESC
                LIMIT " . ($page-1)*$pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }
}