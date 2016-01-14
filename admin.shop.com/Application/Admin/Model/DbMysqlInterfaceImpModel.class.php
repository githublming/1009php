<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2016/1/14
 * Time: 20:04
 */

namespace Admin\Model;


class DbMysqlInterfaceImpModel implements DbMysqlInterfaceModel
{
    public function connect()
    {
        // TODO: Implement connect() method.
        echo 'connect..';
    }

    public function disconnect()
    {
        // TODO: Implement disconnect() method.
        echo 'disconnect..';
    }

    public function free($result)
    {
        // TODO: Implement free() method.
        echo 'free..';
    }

    public function query($sql, array $args = array())
    {
        $sql=$this->buildSql(func_get_args());
        return  M()->execute($sql);

    }

    public function insert($sql, array $args = array())
    {
        $params=func_get_args();
        $sql=array_shift($params);
        $table_name=array_shift($params);
        $sql = str_replace('?T',$table_name,$sql);
        $value=array_shift($params);
        $values='';;
        foreach($value as $k=>$v){
            $values.=("$k='$v',");
        }
        $values=rtrim($values,',');
        $sql=str_replace('?%',$values,$sql);
        $model=M();
        $result=$model->execute($sql);
        if($result===false){
            return false;
        }else{
            return $model->getLastInsID();
        }

    }

    public function update($sql, array $args = array())
    {
        // TODO: Implement update() method.
        echo 'update..';
    }

    public function getAll($sql, array $args = array())
    {
        // TODO: Implement getAll() method.
        echo 'getAll..';
    }

    public function getAssoc($sql, array $args = array())
    {
        // TODO: Implement getAssoc() method.
        echo 'getAssoc..';
    }

    public function getRow($sql, array $args = array())
    {
        $sql=$this->buildSql(func_get_args());
        $row=M()->query($sql);
        return empty($row)?false:$row[0];
    }

    public function getCol($sql, array $args = array())
    {
        // TODO: Implement getCol() method.
        echo 'getCol..';
    }

    public function getOne($sql, array $args = array())
    {
        $sql=$this->buildSql(func_get_args());
        $row=M()->query($sql);
        $values=array_values($row[0]);
        return $value=$values[0];
    }

    private function buildSql($params){
        $sql=array_shift($params);
        $sqls=preg_split('/\?[FTN]/',$sql);
        $sql='';
        foreach($sqls as $k=>$v){
            $sql.=($v.$params[$k]);
        }
        return $sql;
    }
}