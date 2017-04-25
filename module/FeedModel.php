<?php
require_once 'Model.php';

class FeedModel extends Model {
    protected $_tbName = '`tblFeed`';

    public function __construct()   {

    }

    public function getFeedList($condition, $page=1, $pagesize) {
        $sql = "SELECT `qid`, `uid`, `create_time`, `type`
                FROM " . $this->_tbName;
        $whereArr = array();
        if (!empty($qid)) {
            $whereArr['qid'] = '`qid` = ' . $condition['qid'];
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ' , $whereArr);
        }
        $sql .= " ORDER BY `create_time` DESC LIMIT " . ($page-1)*$pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    public function updateFeed($editArr, $qid) {
        $res = $this->update($editArr, array('qid'=> $qid));
        return $res;
    }
}