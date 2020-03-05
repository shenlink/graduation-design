<?php

namespace core\lib;

use core\lib\Config;

/*
 * @Descripttion:数据库操作类
 */

class Db
{
    private static $db;
    private $table;
    private $field = '*';
    private $order = '';
    private $where;
    private $pdo = null;

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

    public function init()
    {
        $config = Config::all('database');
        $type = $config['type'];
        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname'];
        $charset = $config['charset'];
        $dsn = "{$type}:host={$host};charset={$charset};dbname={$dbname}";
        try {
            $this->pdo = new \PDO($dsn, $username, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
        return $this->pdo;
    }

    public function table($table)
    {
        $this->init();
        $this->table = $table;
        return $this;
    }

    // 注意，传入多个字段时，应这样：'username,user_id';
    public function field($field)
    {
        $this->field = $field;
        return $this;
    }

    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    public function select()
    {
        $sql = $this->fixsql('select') . ' limit 1';
        if (is_array($this->where)) {
            $wheres = $this->fixPrepareWhere($this->where);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($wheres);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return isset($result) ? $result : false;
    }

    public function selectAll()
    {
        $sql = $this->fixSql('select');
        if ($this->where) {
            if (is_array($this->where)) {
                $wheres = $this->fixPrepareWhere($this->where);
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($wheres);
            } else {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
            }
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    // 查询数据总数
    public function count()
    {
        $sql = $this->fixSql('count');
        if (is_array($this->where)) {
            $wheres = $this->fixPrepareWhere($this->where);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($wheres);
            $count = $stmt->fetchColumn(0);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetchColumn(0);
        }
        return $count;
    }

    // 分页
    public function pages($currentPage, $pageSize = 10)
    {
        $count = $this->count();
        $this->limit = ($currentPage - 1) * $pageSize . ',' . $pageSize;
        $items = $this->selectAll();
        $pageHtml = $this->createPages($currentPage, $pageSize, $count);
        return array('items' => $items, 'pageHtml' => $pageHtml);
    }

    // 生成分页pageHtml(bootstrap风格)；currentPage：当前第几页，pageSize:每页大小，count:数据总数
    private function createPages($currentPage, $pageSize, $count)
    {

        // 分页数，向上取整
        $pageHtml = '';
        $pageCount = ceil($count / $pageSize);
        // 生成首页,生成上一页
        if ($currentPage >= 1) {
            if ($currentPage == 1) {
                $pageHtml .= "<li data-index='current_1' onclick='changePage(this)' class='page-item'><a class='page-link' href='javascript:void(0)'>首页</a></li>";
            } else {
                $pageHtml .= "<li data-index='1' onclick='changePage(this)' class='page-item'><a class='page-link' href='javascript:void(0)'>首页</a></li>";
            }
            $prePage = $currentPage - 1;
            if ($prePage < 1) {
                $prePage = 'current_1';
            }
            $pageHtml .= "<li data-index={$prePage} onclick='changePage(this)' class='page-item'><a class='page-link' href='javascript:void(0)'>上一页</a></li>";
        }
        $start = $currentPage - 3 >= 1 ? $currentPage - 3 : 1;
        $end = $currentPage + 3 <= $pageCount ? $currentPage + 3 : $pageCount;
        for ($i = $start; $i <= $end; $i++) {
            $pageHtml .= $i == $currentPage ? "<li data-index={$i} onclick='changePage(this)' class='page-item active'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>" : "<li data-index={$i} onclick='changePage(this)' class='page-item'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
        }
        // 生成下一页,生成尾页
        if ($currentPage <= $pageCount) {
            $nextPage = $currentPage + 1;
            if ($nextPage > $pageCount) {
                $nextPage = 'current_end';
            }
            $pageHtml .= "<li data-index={$nextPage} onclick='changePage(this)' class='page-item '><a class='page-link' href='javascript:void(0)'>下一页</a></li>";
            if ($currentPage == $pageCount) {
                $pageCount = 'current_end';
            }
            $pageHtml .= "<li data-index={$pageCount} onclick='changePage(this)' class='page-item '><a class='page-link' href='javascript:void(0)'>尾页</a></li>";
        }
        $pageHtml = '<ul class="pagination justify-content-center">' . $pageHtml . '</ul>';

        return $pageHtml;
    }

    public function insert($data)
    {
        $sql = $this->fixSql('insert', $data);
        if (is_array($data)) {
            $values = $this->fixPrepareValue($data);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        $result = $this->pdo->lastInsertId();
        return $result;
    }

    public function update($data)
    {
        $sql = $this->fixSql('update', $data);
        if (is_array($data) && is_array($this->where)) {
            $values = $this->fixPrepareValue($data);
            $wheres = $this->fixPrepareWhere($this->where);
            $allParams = array_merge($values, $wheres);
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($allParams);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute();
        }
        return $result;
    }

    public function delete()
    {
        $sql = $this->fixSql('delete');
        if (is_array($this->where)) {
            $wheres = $this->fixPrepareWhere($this->where);
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($wheres);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute();
        }
        return $result;
    }

    public function limit($limit = 1)
    {
        $this->limit = $limit;
        return $this;
    }

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

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
            return $sql;
        }

        if ($type == 'count') {
            $where = $this->fixWhere();
            $fieldList = explode(',', $this->field);
            $field = count($fieldList) > 1 ? '*' : $this->field;
            $sql = "select count({$field}) from {$this->table} {$where}";
            return $sql;
        }

        if ($type === 'insert') {
            $sql = "insert into {$this->table}";
            $fields = array();
            $values = array();
            foreach ($data as $key => $value) {
                $fields[] = $key;
                $values[] = '?';
            }
            $sql .= " (" . implode(',', $fields) . ") values (" . implode(',', $values) . ")";
            return $sql;
        }
        if ($type == 'update') {
            if (is_array($data)) {
                $str = '';
                foreach ($data as $key => $value) {
                    $value = '?';
                    $str .= "{$key} = {$value},";
                }
                $str = rtrim($str, ',');
            } else {
                $str = $data;
            }
            $str = $str ? "set {$str}" : '';
            $sql = "update {$this->table} {$str} {$where}";
            return $sql;
        }

        if ($type === 'delete') {
            $sql = "delete from {$this->table} {$where}";
            return $sql;
        }
    }

    private function fixWhere()
    {
        $where = '';
        if (is_array($this->where)) {
            foreach ($this->where as $key => $value) {
                $value = '?';
                $where .= "`{$key}` = {$value} and ";
            }
        } else {
            $where = $this->where;
        }
        $where = rtrim($where, 'and ');
        $where = $where == '' ? '' : "where {$where}";
        return $where;
    }

    public function fixPrepareWhere($prepareWheres)
    {
        $wheres = array();
        foreach ($prepareWheres as $value) {
            $wheres[] = $value;
        }
        return $wheres;
    }

    public function fixPrepareValue($data)
    {
        $values = array();
        foreach ($data as $value) {
            $values[] = $value;
        }
        return $values;
    }
}
