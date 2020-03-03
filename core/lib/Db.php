<?php

namespace core\lib;

use core\lib\Config;
use \PDO, \PDOException;

/*
 * @Descripttion:数据库操作类
 */

class Db
{
    private static $db;
    private $table;
    private $field = '*';
    private $order = '';
    private $where = '';
    private $pdo = null;
    /**
     * @access:public
     * @name:__construct
     * @param
     * @return:
     * @msg:
     */
    // 单例模式
    private function __construct()
    {
    }
    private function __clone()
    {
    }
    public static function getInstance()
    {
        if (self::$db) {
            return self::$db;
        } else {
            self::$db = new self();
            return self::$db;
        }
    }

    /**
     * @access:public
     * @name:table
     * @param $type
     * @return:object
     * @msg:
     */
    public function init()
    {
        if ($this->pdo) {
            return $this->pdo;
        } else {
            $config = Config::all('database');
            $type = $config['type'];
            $host = $config['host'];
            $username = $config['username'];
            $password = $config['password'];
            $dbname = $config['dbname'];
            $charset = $config['charset'];
            $dsn = "{$type}:host={$host};charset={$charset};dbname={$dbname}";
            try {
                $this->pdo = new PDO($dsn, $username, $password);
            } catch (PDOException $e) {
                $e->getMessage();
            }
            return $this->pdo;
        }
    }
    public function table($table)
    {
        $this->init();
        $this->table = $table;
        return $this;
    }
    /**
     * @access:public
     * @name:field
     * @param $filed
     * @return:object
     * @msg:
     */
    // 注意，传入多个字段时，应这样：'username,user_id';
    public function field($field)
    {
        $this->field = $field;
        return $this;
    }
    /**
     * @access:public
     * @name:where
     * @param $where
     * @return:object
     * @msg:
     */
    public function where($where)
    {
        $this->where = $where;
        return $this;
    }
    /**
     * @access:public
     * @name:select
     * @param $select
     * @return:object
     * @msg:
     */
    public function select()
    {
        $sql = $this->fixsql('select') . ' limit 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($result) ? $result : false;
    }
    /**
     * @access:public
     * @name:selectAll
     * @param
     * @return:
     * @msg:
     */
    public function selectAll()
    {
        $sql = $this->fixSql('selectAll');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // 查询数据总数
    public function count()
    {
        $sql = $this->fixSql('count');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn(0);
        return $count;
    }

    // 分页
    public function pages($currentPage, $pageSize = 10)
    {
        $count = $this->count();
        $this->limit = ($currentPage - 1) * $pageSize . ',' . $pageSize;
        $article = $this->selectAll();
        $pageHtml = $this->createPages($currentPage, $pageSize, $count);
        return array('article' => $article, 'pageHtml' => $pageHtml);
    }

    // 生成分页pageHtml(bootstrap风格)；currentPage：当前第几页，pageSize:每页大小，count:数据总数
    private function createPages($currentPage, $pageSize, $count)
    {

        // 分页数，向上取整
        $pageHtml = '';
        $pageCount = ceil($count / $pageSize);
        // 生成首页,生成上一页
        if ($currentPage >= 1) {
            $pageHtml .= "<li data-index='1' class='page-item'><a class='page-link' href='javascript:void(0)'>首页</a></li>";
            $prePage = $currentPage - 1;
            $pageHtml .= "<li data-index={$prePage} class='page-item'><a class='page-link' href='javascript:void(0)'>上一页</a></li>";
        }
        $start = $currentPage > ($pageCount - 6) ? ($pageCount - 6) : $currentPage;
        $start = $start - 2;
        $start = $start <= 0 ? 1 : $start;
        $end = ($currentPage + 6) > $pageCount ? $pageCount : ($currentPage + 6);
        $end = $end - 2;
        if ($end <= $start) {
            $end = $pageCount;
        }
        if (($currentPage + 2) >= $end && $pageCount > 6) {
            $start = $start + 2;
            $end = $end + 2;
        }
        if ($end - $start <= 5) {
            $end = $pageCount;
        }

        for ($i = 1; $i <= $pageCount; $i++) {
            $pageHtml .= $i == $currentPage ? "<li data-index={$i} class='page-item active'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>" : "<li data-index={$i} class='page-item'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
        }
        // 生成下一页,生成尾页
        if ($currentPage <= $pageCount) {
            $nextPage = $currentPage + 1;
            $pageHtml .= "<li data-index={$nextPage} class='page-item '><a class='page-link' href='javascript:void(0)'>下一页</a></li>";
            $pageHtml .= "<li data-index={$pageCount} class='page-item '><a class='page-link' href='javascript:void(0)'>尾页</a></li>";
        }
        $pageHtml = '<ul class="pagination justify-content-center">' . $pageHtml . '</ul>';

        return $pageHtml;
    }

    /**
     * @access:public
     * @name:
     * @param $
     * @return:
     * @msg:
     */
    public function insert($data)
    {
        $sql = $this->fixSql('insert', $data);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $this->pdo->lastInsertId();
        return $result;
    }
    /**
     * @access:public
     * @name:
     * @param
     * @return:
     * @msg:
     */
    public function update($data)
    {
        $sql = $this->fixSql('update', $data);
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }
    /**
     * @access:public
     * @name:
     * @param
     * @return:
     * @msg:
     */
    public function delete()
    {
        $sql = $this->fixSql('delete');
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }
    /**
     * @access:public
     * @name:
     * @param
     * @return:object
     * @msg:
     */
    public function limit($limit = 1)
    {
        $this->limit = $limit;
        return $this;
    }
    /**
     * @access:public
     * @name:order
     * @param:$order
     * @return:object
     * @msg:
     */
    public function order($order)
    {
        $this->order = $order;
        return $this;
    }
    /**
     * @access:public
     * @name:
     * @param
     * @return:
     * @msg:
     */
    public function fixSql($type, $data = null)
    {
        $sql = '';
        $where = $this->fixWhere();
        if ($type === 'select') {
            $sql = "select {$this->field} from {$this->table} {$where}";
            if ($this->order) {
                $sql .= " order by {$this->order}";
            }
            if ($this->limit) {
                $sql .= " limit {$this->limit}";
            }
        }

        if ($type === 'selectAll') {
            $sql = "select {$this->field} from {$this->table} {$where}";
            if ($this->order) {
                $sql .= " order by {$this->order}";
            }
        }

        if ($type == 'count') {
            $where = $this->fixWhere();
            $fieldList = explode(',', $this->field);
            $field = count($fieldList) > 1 ? '*' : $this->field;
            $sql = "select count({$field}) from {$this->table} {$where}";
        }

        if ($type === 'insert') {
            $sql = "insert into {$this->table}";
            $fields = $values = [];
            foreach ($data as $key => $val) {
                $fields[] = $key;
                $values[] = is_string($val) ? "'" . $val . "'" : $val;
            }
            $sql .= " (" . implode(',', $fields) . ") values (" . implode(',', $values) . ")";
        }
        if ($type == 'update') {
            if (is_array($data)) {
                $str = '';
                foreach ($data as $key => $val) {
                    $val = is_string($val) ? "'" . $val . "'" : $val;
                    $str .= "{$key}={$val},";
                    $str = rtrim($str, ',');
                }
            }else{
                $str = $data;
            }
            $str = $str ? " set {$str}" : '';
            $sql = "update {$this->table} {$str} {$where}";
        }

        if ($type === 'delete') {
            $sql = "delete from {$this->table} {$where}";
        }
        return $sql;
    }
    /**
     * @access:
     * @name:
     * @param {type}
     * @return:
     * @msg:
     */
    private function fixWhere()
    {
        $where = '';
        if (is_array($this->where)) {
            foreach ($this->where as $key => $value) {
                $value = is_string($value) ? "'" . $value . "'" : $value;
                $where .= "`{$key}` = {$value} and ";
            }
        } else {
            $where = $this->where;
        }
        $where = rtrim($where, 'and ');
        $where = $where == '' ? '' : "where {$where}";
        return $where;
    }
}
