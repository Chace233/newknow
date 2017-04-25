<?php
require_once 'Model.php';

class ExpModel extends Model {
    protected $_tbName = '`tblExp`';

    public function __construct() {
    }

    /**
     * @param $condition
     * @param int $page
     * @param int $pagesize
     * @return 成功返回结果
     */
    public function getExpList($condition, $page=1, $pagesize=15) {
        $sql = "SELECT `eid`, `title`, `summary`, `content`, `type`, `creator_uid`, `creator_uname`, `status`, `reply_num`, `approve_num`, `follower_num`, `browser_num`
                FROM " . $this->_tbName;
        $whereArr = array();
        if (!empty($condition['eid'])) {
            $whereArr['eid'] = "`eid` = " . $condition['eid'];
        }
        if (!empty($condition['title_key'])) {
            $whereArr['title_key'] = "`title_key` = '" . $condition['title_key'] . "'";
        }
        if (!empty($condition['uid'])) {
            $whereArr['creator_uid'] = "`creator_uid` = " . $condition['uid'];
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $sql .= " ORDER BY `create_time` DESC LIMIT " . ($page-1)*$pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    /**
     * @param $condition
     * @return mixed
     */
    public function getTotalExp($condition) {
        $sql = "SELECT COUNT(`eid`) AS total
                FROM " . $this->_tbName;
        $whereArr = array();
        if (!empty($condition['eid'])) {
            $whereArr['eid'] = "`eid` = " . $condition['eid'];
        }
        if (!empty($condition['title_key'])) {
            $whereArr['title_key'] = "`title_key` = '" . $condition['title_key'] . "'";
        }
        if (!empty($condition['uid'])) {
            $whereArr['creator_uid'] = "`creator_uid` = " . $condition['uid'];
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $res = $this->Query($sql);
        return current($res[0]);
    }

    /**
     * @param $eid
     * @return bool
     */
    public function addExpReplyNum($eid) {
        $sql = "UPDATE " . $this->_tbName . " SET `reply_num` = `reply_num` + 1 WHERE `eid` = " . $eid;
        $res = $this->querySql($sql);
        return $res;
    }
}