<?php

namespace core\lib;

use \PDO, \PDOException;
/*
 * @Descripttion:数据库操作类
 */

class Db
{
    private $field = '*';
    private $order = '';
    private $where = array();
    /**
     * @access:public
     * @name:__construct
     * @param
     * @return:
     * @msg:
     */
    // public function __construct($dsn, $username, $password, $charset)
    // {
    //     try {
    //         $this->pdo = new \PDO($dsn, $username, $password, $charset);
    //     } catch (\PDOException $e) {
    //         $e->getMessage();
    //     }
    // }
    public function __construct($config)
    {
        $type = $config['type'];
        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname'];
        $charset = $config['charset'];
        $dsn = "{$type}:host={$host};charset={$charset};dbname={$dbname}";
        try {
            // mysql:host=localhost;port=3306;charset=utf8;dbname=stu
            $this->pdo = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            die("数据库连接失败：{$e->getMessage()} in line {$e->getLine()}");
        }
        return $this->pdo;
    }
    /**
     * @access:public
     * @name:table
     * @param $type
     * @return:object
     * @msg:
     */
    public function table($table)
    {
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
        // select * from article where id=1 and title='php' limit 1;
        // $sql='select * from ${$table} where $where limit = $limit';
        $sql = $this->fixsql('select') . ' limit 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        //获取多条数据后，截取一条
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
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
     * @name:field
     * @param
     * @return:
     * @msg:
     */
    public function count()
    {
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
        if ($type === 'select') {
            $where = $this->fixWhere();
            $sql = "select {$this->field} from {$this->table} where {$this->where}";
            if ($this->order) {
                $sql .= " order by {this->order}";
            }
            if ($this->limit) {
                $sql .= " limit {$this->limit}";
            }
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
        if ($type === 'delete') {
            // $sql = "delete from {$this->table} {$this->where}";
            $where = $this->fixWhere();
            $sql = "delete from {$this->table} {$where}";
        }
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
                //还不能确定有几个条件
                $where .= "`{$key}` = {$value} and ";
            }
        } else {
            $where = $this->where;
        }
        $where = rtrim($where, 'and ');
        $where = $where = '' ? '' : "where {$where}";
        return $where;
    }
}
