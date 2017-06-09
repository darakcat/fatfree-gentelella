<?php

class CRUD extends DB\SQL\Mapper{

    public function __construct(DB\SQL $db, $table) {
        parent::__construct($db, $table);
    }

    public function all($key=null) {
        $data = array();

        for ($this->load(); !$this->dry(); $this->next())
            $data[] = $this->cast();

        if(!is_null($key)) {
            $dataKey = array();
            foreach ($data as $k => $v) {
                $dataKey[$v[$key]] = $v;
            }

            $data = $dataKey;
        }

        return $data;

    }

    public function getByName($params) {
        $this->load($params);
    }

    public function getById($id) {
        $data = array();

        for ($this->load(array('id=?',$id)); !$this->dry(); $this->next())
            $data[] = $this->cast();

        return $data;
    }

    public function getByParams($params, $options = null) {
        $data = array();

        for ($this->load($params, $options); !$this->dry(); $this->next())
            $data[] = $this->cast();

        return $data;
    }

    public function add($params=null) {
        if( is_null($params) ){
            $this->copyFrom('POST');
        } else {
            $this->copyFrom($params);
        }
        $this->save();
    }

    public function addAfterSearch($search, $params=null) {
        $this->load($search);
        if($this->dry()){
            if( is_null($params) ){
                $this->copyFrom('POST');
            } else {
                $this->copyFrom($params);
            }
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    public function edit($param, $option=null) {

        if( is_array($param) ){
            $this->load($param);
        } else {
            $this->load(array('id=?',$param));

        }

        if( is_array($option) ){
            $this->copyFrom($option);
        } else {
            $this->copyFrom('POST');

        }
        $this->update();
    }

    public function delete($param) {
        if( is_array($param) ){
            $this->erase($param);
        } else {
            $this->load(array('id=?', $param));
            $this->erase();
        }
    }
}