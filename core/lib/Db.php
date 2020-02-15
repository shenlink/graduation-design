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
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // 获取多条数据后，截取一条
        return isset($res[0]) ? $res[0] : false;
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
        $sql = $this->fixSql('select');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    // 查询数据总数
    public function count()
    {
        $sql = $this->fixSql('count');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetchColumn(0);
        return $total;
    }

    // 分页
    // $arr = $table('user)->field('username')->where()->pagination();
    public function pagination($currentPage, $pageSize = 10, $path = '/')
    {
        $count = $this->count();
        $this->limit = ($currentPage - 1) * $pageSize . ',' . $pageSize;
        $data = $this->selectAll();
        $pageHtml = $this->seperatePage($currentPage, $pageSize, $count, $path);
        return array('data' => $data, 'pageHtml' => $pageHtml);
    }

    // 生成分页html(bootstrap风格)；currentPage：当前第几页，pageSize:每页大小，total:数据总数
    private function seperatePage($currentPage, $pageSize, $total, $path)
    {
        // 分页数，向上取整
        $html = '';
        // 56/10
        $pageCount = ceil($total / $pageSize);
        // 生成首页,生成上一页
        if ($currentPage > 1) {
            $html .= "<li class='page-item'><a class='page-link' href='{$path}/page/1'>首页</a></li>";

            $prePage = $currentPage - 1;
            $html .= "<li class='page-item'><a class='page-link' href='{$path}/page/{$prePage}'>上一页</a></li>";
        }

        // 生成数字页
        // 假设分10页，最多显示7页
        $start = $currentPage > ($pageCount - 6) ? ($pageCount - 6) : $currentPage;
        $start = $start - 2;
        $start = $start <= 0 ? 1 : $start;
        $end = ($currentPage + 6) > $pageCount ? $pageCount : ($currentPage + 6);
        $end = $end - 2;
        if ($currentPage + 2 >= $end && $pageCount > 6) {
            $start = $start + 2;
            $end = $end + 2;
        }

        for ($i = $start; $i <= $end; $i++) {
            $html .= $i == $currentPage ? "<li class='page-item active'><a class='page-link'>{$i}</a></li>" : "<li><a class='page-link' href='{$path}/page/{$i}'>{$i}</a></li>";
        }
        // 生成下一页,生成尾页
        if ($currentPage < $pageCount) {
            $nextPage = $currentPage + 1;
            $html .= "<li class='page-item><a class='page-link' href='{$path}/page/{$nextPage}'>下一页</a></li>";
            $html .= "<li class='page-item><a class='page-link' href='{$path}/page/{$pageCount}'>尾页</a></li>";
        }

        $html = '<ul class="pagination justify-content-center">' . $html . '</ul>';
        return $html;
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
        return $this->pdo->lastInsertId();
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
        $stmt->execute();
        return $stmt->rowCount();
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
        $stmt->execute();
        return $stmt->rowCount();
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
        return $this->order;
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
                $sql .= " order by {this->order}";
            }
            if ($this->limit) {
                $sql .= " limit {$this->limit}";
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
            $sql .= "(" . implode(',', $fields) . ")values(" . implode(',', $values) . ")";
        }
        if ($type == 'update') {
            // $where = $this->fixWhere();
            $str = '';
            foreach ($data as $key => $val) {
                $val = is_string($val) ? "'" . $val . "'" : $val;
                $str .= "{$key}={$val},";
            }
            $str = rtrim($str, ',');
            $str = $str ? " set {$str}" : '';
            $sql = "update {$this->table} {$str} {$where}";
        }
        if ($type === 'delete') {
            // $where = $this->fixWhere();
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
        // $where = $where = '' ? '' : "where {$where}";
        $where = $where == '' ? '' : "where {$where}";
        // if($where == ''){
        //     $where = '';
        // }else{
        //     $where = $where;
        // }
        return $where;
    }
}
