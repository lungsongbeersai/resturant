<?php
    class DBConnection{
        private $db="mysql:host=localhost;dbname=resturant_v2;charset=utf8";
        private $user="root";
        private $pass="";
        public $conn;
        public function __construct(){
            try{
                $this->conn=new PDO($this->db,$this->user,$this->pass);
                // echo "Connection is Successfull";
            }catch(Exception $e){
                echo "Connection is failed".$e->getMessage();
            }
        }

        //==================================== Autonumber =================================
        public function fn_autonumber($field_name,$table){
            $year_1=date("Y");
            $sql ="SELECT MAX($field_name)+1 AS auto_id FROM $table ";
            $result = $this->conn->query($sql);
            $row = $result->fetch();
            if ($row["auto_id"] == '') {
                $auto_id =$year_1."00001";
            } else {
                $auto_id = $row["auto_id"];
            }
            return $auto_id;
        }

        //==================================== Create =================================
        public function fn_insert($table,$field){
            $sql="INSERT INTO $table value($field)";
            $this->conn->query($sql);
            return true;
        }
        //====================================Update=================================
        public function fn_edit($table,$field){
            $sql="UPDATE $table SET $field";
            $this->conn->query($sql);
            return true;
        }
        //====================================Delete=================================
        public function fn_delete($table){
            $sql="DELETE FROM $table";
            $this->conn->query($sql);
            return true;
        }
        //====================================Read All=================================
        public function fn_read_all($table){
            $data=array();
            $sql="SELECT * FROM $table";
            $result=$this->conn->query($sql);
            foreach($result as $row){
                $data[]=$row;
            }
            return $data;
        }

        public function fn_read_single($field,$table){
            $data=array();
            $sql="SELECT $field FROM $table";
            $result=$this->conn->query($sql);
            foreach($result as $row){
                $data[]=$row;
            }
            return $data;
        }


        //===================================Fetch single===================================

        public function fn_fetch_single_all($table){
            $sql="SELECT * FROM $table";
            $result = $this->conn->query($sql);
            $row = $result->fetch();
            return $row;
        }

        public function fn_fetch_single_field($field,$table){
            $sql="SELECT $field FROM $table";
            $result = $this->conn->query($sql);
            $row = $result->fetch();
            return $row;
        }

        public function fn_fetch_rowcount($table){
            $sql="SELECT * FROM $table";
            $result=$this->conn->query($sql);
            $num=$result->rowCount();
            return $num;
        }


        

    }

?>