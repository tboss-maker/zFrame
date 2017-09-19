<?php

/**
 * PDO封装类
 * @authors YangHaiTao
 * @date    2016-04-07 09:29:51
 * Created by sublime.
 */
class MysqlDatabase
{
    public static $ins;
    protected static $db;
    protected $_queryString = '';

    protected function __construct($dbname, $configs = [])
    {
        self::setDb($dbname, $configs);
    }

    protected function __clone()
    {
    }

    /**
     * 获取实例
     * @param string $dbname
     * @return MysqlDatabase
     */
    public static function getIns($dbname = 'database', $configs = [])
    {
        if (!(self::$ins instanceof self)) {
            self::$ins = new self($dbname, $configs);
        }
        return self::$ins;
    }

    /**
     * 获取数据库对象
     * @param string $dbname
     */
    public static function setDb($dbname, $configs = [])
    {
        if (empty($configs)) {
            global $config;
        } else {
            $config = $configs;
        }

        $configs = $config[$dbname];
        $options = array(
            PDO::ATTR_PERSISTENT => true,//设置长链接
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,//设置错误处理方式
            PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8',//设置字符集
            PDO::ATTR_CASE => PDO::CASE_LOWER//指定列小写
        );
        $host = $configs['host'];
        $dbName = $configs['dbname'];
        $username = $configs['username'];
        $password = $configs['password'];
        $port = isset($configs['port']) ? $configs['port'] : 3306;
        try {
            self::$db = new PDO("mysql:host=$host;port=$port;dbname=$dbName", "$username", "$password", $options);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 对数组或字符串进行转义
     * @param $arr
     */
    protected function _fmt_arr_addslashes(&$arr)
    {
        if (is_array($arr)) {
            foreach ($arr as $k => &$v) {
                $v = addslashes($v);
            }
        } else {
            $arr = addslashes($arr);
        }
    }

    /**
     * 转义过滤字符串
     * @param $value
     *
     * @return string
     */
    protected function _Quote($value)
    {
        if (is_int($value)) {
            return $value;
        } elseif (is_float($value)) {
            return sprintf('%F', $value);
        } elseif (is_null($value)) {
            return "NULL";
        }
        return "'" . addcslashes($value, "\000\n\r\\'\"\032") . "'";
    }

    /**
     * 将列名加上`符号
     * @param string $key
     * @return string
     */
    protected function _QuoteIdentifier($key)
    {
        $tmp = explode(".", $key);
        foreach ($tmp as $k => &$v) {
            $v = "`$v`";
        }
        $newkey = implode(".", $tmp);
        return $newkey;
    }

    /**
     * 编排where  如 $where['id_!='] = '3';  》 id != '3'
     * @param $where
     *
     * @return mixed
     */
    protected function _FmtWhere($where)
    {
        if (empty($where)) {
            return $where;
        }
        if (!is_array($where)) {
            return $where;
        }

        $allowfh = array("LIKE", ">", ">=", "<", "<>", "<=", "!=", "IN", "NOTIN", 'IS');
        foreach ($where as $cond => &$term) {

            $rest = explode("_", $cond);
            $fldop = '-1';
            if (count($rest) > 1) {
                $fldop = array_pop($rest);
                $fldop = strtoupper($fldop);
                $rest = implode("_", $rest);
            }
            if (array_key_exists("LIKE", $where) && in_array($cond, $where['LIKE'])) {
                $term = $this->_QuoteIdentifier($cond) . " LIKE '%" . $this->_Quote($term) . "%'";
            } else if ($fldop != '-1' && in_array($fldop, $allowfh)) {// $rest == "_LIKE"){
                switch ($fldop) {
                    case "LIKE":
                        $term = addslashes($term);
                        $term = strpos($term, '%') !== false ? str_replace("%", "\%", $term) : $term;
                        //使用左前缀匹配
                        $term = $this->_QuoteIdentifier($rest) . " LIKE '" . $term . "%'";
                        break;
                    case ">":
                    case ">=":
                    case "<":
                    case "<=":
                    case "<>":
                    case "!=":
                        $term = $this->_QuoteIdentifier($rest) . " " . $fldop . " '" . addslashes($term) . "'";
                        break;
                    case "IS":
                        $term = $this->_QuoteIdentifier($rest) . " " . $fldop . " " . addslashes($term) . "";
                        break;
                    case "IN":
                        if (!is_array($term)) {
                            $term = explode(",", $term);
                        }
                        $this->_fmt_arr_addslashes($term);
                        $term = $this->_QuoteIdentifier($rest) . " IN ('" . implode("','", $term) . "')";
                        break;
                    case "NOTIN":
                        if (!is_array($term)) {
                            $term = explode(",", $term);
                        }
                        $this->_fmt_arr_addslashes($term);
                        $term = $this->_QuoteIdentifier($rest) . " NOT IN ('" . implode("','", $term) . "')";
                        break;
                }
            } else {
                $term = $this->_QuoteIdentifier($cond) . "=" . $this->_Quote($term);
            }
            $term = '(' . $term . ')';
        }
        return $where;
    }

    protected function _FieldsExpr($fields = '*')
    {
        if (!is_array($fields)) {
            return $fields;
        }
        return implode(',', $fields);
    }

    /**
     * 生成where条件
     * @param $where
     *
     * @return string
     */
    protected function _WhereExpr($where)
    {
        if (!is_array($where)) return $where;
        if (count($where) == 0) return '';
        $sql = '';
        if (array_key_exists("OR", $where)) {
            $or = $where['OR'];
            unset($where['OR']);

        }
        $where3 = $this->_FmtWhere($where);
        if (!empty($where3)) {
            $sql .= ' AND (' . implode(' AND ', $where3) . ') ';
        }
        $sql = trim($sql, ' AND');

        if (isset($or) && $or) {
            $where2 = $this->_FmtWhere($or);

            if (!empty($where2)) {
                $sql .= ' OR (' . implode(' AND ', $where2) . ')';
            }
        }


        return $sql;
    }

    /**
     * 查询多条记录
     * 如：getList(['id'=>1],'name,id','tt_user');等价于
     * SELECT name,id FROM tt_user WHERE ((`id`=1))
     * @param array $where where条件  默认是and  也可以形如$where['id_>='] =1 等；
     * @param string $fields 需要取出的字段 可以是字符串如“id,name”,也可以是数组，如['id','name'];
     * @param string $order 排序字段 如 'id desc,默认为空
     * @param int $cur_page 当前的页数
     * @param int $page_size 每页显示的条数
     * @param string $tbname 表名，如果为空默认取当前的model名
     *
     *
     * @return array   返回总的条数和多条记录
     */
    public function getList($where, $fields = "*", $order = '', $cur_page = 1, $page_size = 0, $tbname = '')
    {

        $tbname = strtolower($tbname);
        $where = $this->_WhereExpr($where);
        $fields = $this->_FieldsExpr($fields);
        // print_r ($fields);exit;
        $result = array("allrow" => array(), "allnum" => 0);

        $sql = 'SELECT ' . $fields . ' FROM ' . $tbname;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }
        if ($order) {
            $sql .= ' ORDER BY ' . $order;
        }
        //        echo $sql;exit;

        // 		echo $cur_page.$page_size;
        if ($cur_page >= 0 && $page_size > 0) {
            $start = ($cur_page - 1) * $page_size;
            $sql .= " limit $start,$page_size";

            $sqlc = "SELECT COUNT(*) AS num FROM " . $tbname;
            //            echo $sql;exit;
            if ($where) {
                $sqlc .= ' WHERE ' . $where;
            }


        } elseif ($page_size > 0) {
            $sql .= " limit 0,$page_size";
        }
        //         	   echo $sql."\n";EXIT;
        $sqlc = "SELECT COUNT(*) AS num FROM " . $tbname;
        if ($where) {
            $sqlc .= ' WHERE ' . $where;
        }

        $this->_setQueryString($sql);

        $sth = self::$db->prepare($sql);
        $sth->execute();
        $allrow = $sth->fetchAll(PDO::FETCH_ASSOC);

        $allnum = self::$db->query($sqlc)->fetchColumn();

        $result['allnum'] = intval($allnum);
        $result['allrow'] = $allrow;

        return $result;
    }

    protected function _setQueryString($sql)
    {
        $this->_queryString = $sql;
    }


    /**
     * 取得单个查询
     * 如：getOne(['id_>'=>0,'name'=>'ee','OR'=>['name_IN'=>'bb,cc']],'name,id','tt_user');等价于
     * SELECT name,id FROM tt_user WHERE ((`id` > '0') AND (`name`='ee')) OR ((`name` IN ('bb','cc')))
     * @param        $where
     * @param string $fields
     * @param string $tbname
     *
     * @return array
     */
    public function getOne($where, $fields = "*", $tbname = '')
    {
        $tbname = strtolower($tbname);

        $where = $this->_WhereExpr($where);
        $fields = $this->_FieldsExpr($fields);

        $sql = 'SELECT ' . $fields . ' FROM ' . $tbname;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }
        $sql = $sql . ' limit 1';
        $this->_setQueryString($sql);
        $sth = self::$db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return (isset($result[0])) ? $result[0] : array();
    }

    /**
     * 更新数据
     * @param array $where 筛选条件
     * @param array $data 要更新的数据，key字段名，VAL是字段值
     * @param string $tbname 表明
     * @return bool
     */
    public function updateData($where, array $data, $tbname = '')
    {
        if (empty($data)) {
            return;
        }

        $tbname = strtolower($tbname);
        $where = $this->_WhereExpr($where);

        $set = array();
        $i = 0;

        foreach ($data as $col => $val) {
            $rest = explode("_", $col);
            if (count($rest) > 1 && in_array(end($rest), array("+=", "-=", "*=", "/="))) {
                $val = $this->_Quote($val);
                array_pop($rest);
                $col2 = $this->_QuoteIdentifier(implode('_', $rest), true);
                switch ($rest[1]) {
                    case '-=':
                        $set[] = $col2 . '=' . $col2 . ' - ?';
                        break;
                    case '*=':
                        $set[] = $col2 . '=' . $col2 . ' * ?';
                        break;
                    case '/=':
                        $set[] = $col2 . '=' . $col2 . ' / ?';
                        break;
                    case '+=':
                    default:
                        $set[] = $col2 . '=' . $col2 . ' + ?';
                        break;
                }
                //$set[] = $this->_QuoteIdentifier($rest[0], true) . $rest[1] . $val;
            } else {
                if (is_null($val)) {
                    $val = "NULL";
                    unset($data[$col]);
                } else if ($val == "" && $val != '0') {
                    $val = "''";
                    unset($data[$col]);
                } else {
                    $val = '?';
                }
                $set[] = $this->_QuoteIdentifier($col, true) . " = " . $val;
            }
        }

        $sql = "UPDATE "
            . $tbname
            . ' SET ' . implode(', ', $set)
            . (($where) ? " WHERE $where" : '');
        $this->_setQueryString(['sql' => $sql, 'bind' => array_values($data)]);
        $sth = self::$db->prepare($sql);
        $executeResult = $sth->execute(array_values($data));
        if (false === $executeResult) {
            return false;
        }

//        return $sth->rowCount();
        return true;
    }


    public function isExists(array $where, $tbname = '')
    {
        $tbname = strtolower($tbname);
        $where = $this->_WhereExpr($where);

        $sql = "SELECT COUNT(*) AS num FROM " . $tbname;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        $this->_setQueryString($sql);
        return self::$db->query($sql)->fetchColumn();
    }


    /**
     * 自动组合SQL语句:
     * Insert into tba (`cola`,`colb`) values (?,?)==>
     * array("cola"=>value1,"colb"=>value2)
     * @param unknown_type $table
     * @param array $data array("colname"=>value1,"colname"=>value2)
     * @param boolean $brtnId 是否返回自增长ID
     * @return 成功返回自增加ID，否则返回0
     */
    public function insertData(array $data, $tbname = '', $brtnId = TRUE)
    {

        $tbname = strtolower($tbname);

        $cols = array();
        $vals = array();
        foreach ($data as $col => $val) {
            $cols[] = $this->_QuoteIdentifier($col);
            if (is_null($val)) {
                $vals[] = "NULL";
                unset($data[$col]);
            } else {
                $vals[] = '?';
            }
        }


        $sql = "Insert INTO "
            . $tbname
            . ' (' . implode(', ', $cols) . ') '
            . 'VALUES (' . implode(', ', $vals) . ')';

        $this->_setQueryString(['sql' => $sql, 'bind' => array_values($data)]);
        $result = self::$db->prepare($sql)->execute(array_values($data));

        if ($result === false) {
            return false;
        } else {
            return ($brtnId === true) ? self::$db->lastInsertId() : true;
        }

    }


    /**
     * 同时插入多条数据
     * @param array $data
     * @param string $tbname
     * @param bool $brtnId
     * @return bool
     */
    public function insertMutilData(array $data, $tbname = '')
    {
        $tbname = strtolower($tbname);

        $colsArr = array();
        $valuesArr = array();
        $preValuesStr = '';
        foreach ($data as $insertDataItem) {
            $tempArr = array();
            $valuesStr = '';
            foreach ($insertDataItem as $col => $val) {
                $tempArr[] = $this->_QuoteIdentifier($col);
                if ($val === null) {
                    $valuesStr .= " NULL,";
                    continue;
                }
                $valuesStr .= "'" . $val . "',";
            }

            $colsArr = $tempArr;
            $valuesArr[] = array_values($insertDataItem);
            $preValuesStr .= '( ' . trim($valuesStr, ',') . '),';
        }

        $sql = 'INSERT INTO ' . $tbname
            . ' (' . implode(',', $colsArr) . ')'
            . ' VALUES ' . trim($preValuesStr, ',');
        $result = self::$db->exec($sql);
        return $result === false ? false : true;
    }

    public function delData(array $where, $tbname = '', $brtnId = TRUE)
    {
        if (empty($where)) {
            return;
        }

        $tbname = strtolower($tbname);
        $where = $this->_WhereExpr($where);

        $sql = " DELETE FROM " . $tbname . " WHERE " . $where;

        $this->_setQueryString(['sql' => $sql]);

        $sth = self::$db->prepare($sql);
        $deleteResult = $sth->execute();
        if ($deleteResult === false) {
            return false;
        }

        return $sth->rowCount();
    }


    /**
     * 获取当前查询的sql
     * @return string
     */
    public function getQueryString()
    {
        return $this->_queryString;
    }


    public function beginTransaction()
    {
        self::$db->beginTransaction();
    }

    public function rollBack()
    {
        self::$db->rollBack();
    }


    public function commit()
    {
        self::$db->commit();
    }

    public function inTransaction()
    {
        return self::$db->inTransaction();
    }

    public function selectQuery($sql, $mode = 2)
    {
        if (!$sql) {
            return false;
        }
        if ($mode == 2) {
            $type = PDO::FETCH_ASSOC;
        } elseif ($mode == 1) {
            $type = PDO::FETCH_NUM;
        } else {
            return false;
        }

        $queryResult = self::$db->query($sql)->fetchAll($type);
        return $queryResult;
    }
}