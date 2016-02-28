<?php
namespace Squirrel\Model;
use Squirrel\Lib\Db;
use Squirrel\Bin\SqException;
class MySql implements Db{
    public $sql;
    private $mysql;
    private $table;
    private $where;
    private $limit;
    private $column;
    private  $values;

    private $stmt_mark;     //绑定类型
    private $stmt_bind;     //绑定参数
    private $stmt;      //预编译处理
    private $stmt_state;
    private $prepare_state;       //预处理语句绑定

    public $field_count;       //列数
    public $num_rows;       //列数

    public function __construct($db_host,$db_user,$db_pass,$db_db=NULL)
    {
        $this->mysql = mysqli_connect($db_host,$db_user,$db_pass,$db_db);
        if($this->mysql->errno){
            throw new SqException($this->mysql->error,$this->mysql->errno);
        }
        $this->stmt = NULL;
        $this->stmt_state = false;
        $this->prepare_state = false;
    }
    //数据库选择
    public function select_db($db_dbname)
    {
        return $this->mysql->select_db($db_dbname);
    }
    //选择表
    public function select_table($table)
    {
        $this->table = $table;
    }
    //设置编码
    public function set_charset($scharset)
    {
        return $this->mysql->set_charset($scharset);
    }
    //获取影响的行数
    public function get_affected_rows()
    {
        return $this->mysql->affected_rows;
    }

    //where 条件
    public function where($where=NULL)
    {
        $this->where .= $where;
        return $this;
    }
    //order实现
    public function order()
    {
        return $this;
    }
    //limit实现
    public function limit($start=0,$s=NULL)
    {
        $this->limit[0]=$start;
        if(isset($s)){
            $this->limit[1] = $s;
        }
        return $this;
    }
    //查询
    public function select($column='*')
    {
        $this->sql = 'SELECT '.$column.' FROM '.$this->table;
        if($this->where){
            $this->sql. ' WHERE '.$this->where;
        }
        if(isset($this->limit[0])){
            $this->sql = $this->sql.' limit '.$this->limit[0];
        }
        if(isset($this->limit[1])){
            $this->sql = $this->sql.','.$this->limit[1];
        }
        echo "<h3>$this->sql</h3>";
        $res = $this->query($this->sql);
        if(!$res){
            die('query error:'.$this->mysql->error);
        }
        $res_arr = [];
        while($row = $res->fetch_assoc())
        {
            $res_arr[] = $row;
        }
        $this->field_count = $res->field_count;
        $this->num_rows = $res->num_rows;
        $res->free();
        $this->where = NULL;
        $this->limit = NULL;
        return $res_arr;
    }

    //批量处理
    public function multi_query($sql)
    {
        $data = array();
        $i = 0;
        $res = $this->mysql->multi_query($sql);
        if(!$res){
            throw new SqException($this->mysql->error,$this->mysql->errno);
        }else{
            do{
                if($res_t = $this->mysql->store_result()){
                    $j = 0;
                    while($row = $res_t->fetch_assoc())
                    {
                        $data[$i][$j] = $row;
                        $j++;
                    }
                    $res_t->free();
                }
                if(!$this->mysql->more_results()){
                    break;
                }
                $i++;
            }while($this->mysql->next_result());
        }
        return $data;
    }

    //************插入操作**********************
    public function column($column)
    {
        if(!empty($column)) {
            $this->column = $column;
        }
        return $this;
    }
    public function values($val)
    {
        if(!empty($val)) {
            $this->values = $val;
        }
        $this->stmt_mark = 1;
        return $this;
    }
    public function insert()
    {
        if($this->prepare_state)
        {

        }

        $this->sql = 'insert into ';
        if(!empty($this->table)){
            $this->sql = $this->sql.$this->table;
            if(!empty($this->column)){
                $this->sql = $this->sql.'('.$this->column.')';
            }
            if(!empty($this->values)){
                $this->sql = $this->sql.' values('.$this->values.');';
            }else{
                throw new SqException("向表({$this->table})中插入数据,值不可为空",11201);
            }
            $res = $this->query($this->sql);
            if(!$res){
                throw new SqException('向表({$this->table})中插入数据,发生错误:'.$this->mysql->error.'  mysqli错误编号='.$this->mysql->errno);
            }else{
                return $this->get_affected_rows();
            }
        }else{
            throw new SqException('未选择表','120');
        }


    }


    //×××××××××××预编译处理*********************
    //开启预编译以后处理按预编译处理
    public function start_stmt()
    {
        if(empty($this->mysql)){
            throw new SqException('使用预编译需要，初始化一个可有连接');
        }
        if($this->stmt = mysqli_stmt_init($this->mysql)){
            $this->stmt_state = true;
            return true;
        }
       return false;
    }
    //关闭预处理
    public function close_stmt()
    {
        if($this->stmt_state){
            $this->stmt->free_result();
            if($this->stmt->close()){
                return true;
            }
        }
    }
    //预处理语句
    public function prepare()
    {
        $perpare_str = '';
        switch($this->stmt_mark)
        {
            case 1:
                $perpare_str = str_replace('%s', '?', $this->values);
                $perpare_str = str_replace('%d', '?', $perpare_str);
                $perpare_str = str_replace('%l', '?', $perpare_str);
               //处理sql语句
                $this->sql = 'insert into '.$this->table;
                if(!empty($this->column)){
                    $this->sql = $this->sql.'('.$this->column.')';
                }
                $this->sql = $this->sql.' values('.$perpare_str.')';
                //进行绑定
                if(!$this->stmt->prepare($this->sql)){
                    echo $this->sql;
                    throw new SqException('sql预处理失败----类：'.__CLASS__.'函数:'.__FUNCTION__);
                }
                break;
        }
        return $this->this;
    }

    //******************事务支持****************
    //自动提交
    public function autocommit($state=false)
    {
        return $this->mysql->autocommit($state);
    }
    //开始一个事务
    public function start_transaction()
    {
        return $this->mysql->begin_transaction();
    }
    //提交事务
    public function commit()
    {
        return $this->mysql->commit();
    }
    //回滚事务
    public function rollback()
    {
        return $this->mysql->rollback();
    }
    public function query($sql)
    {
        return $this->mysql->query($sql);
    }
}