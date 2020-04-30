<?php
include_once (__DIR__ . "/DB.php");
class SensorPilihan{
    private $table_name='log';
    private $db = null;
    public  $timestamp=null;
    private $temperature=null;
    private $humidity=null;

    function __construct(){
        if ($this->db ==  null){
            $conn = new DB();
            $this->db = $conn->db;
        }
    }

    function setValue($timestamp, $temperature, $humidity){
        // $this();
        $this->timestamp = $timestamp;
        $this->temperature = $temperature;
        $this->humidity = $humidity;

    }


    ///fungsi pennyimpanan data berhasil atau tidak
    function create(){
        // $count = count($this->getBukuPilihan($this->kode_buku));
        $bk= $this->getSensorPilihan($this->timestamp);
        $count = count($bk["data"]);
        if ($count>0) {
            http_response_code(503);
            return array('msg' => "Data sudah ada, tidak berhasil disimpan");
        } 
        else if ($this->timestamp == null){
            http_response_code(503);
            return array('msg' => "KOde tidak boleh kosong");
        } 
        else{
            $kueri = "INSERT INTO ".$this->table_name." SET ";
            $kueri .= "timeStamp='".$this->timestamp ."',";
            $kueri .= "temperature='".$this->temperature ."',";
            $kueri .= "humidity='".$this->humidity."'";
            $hasil = $this->db->query($kueri);
            if ($hasil) {
                http_response_code(200);
                return array('msg' => 'success');
            } else {
                http_response_code(503);
                return array('msg' => 'Data Gagal disimpan '.$this->db->error);
            }

        }
    }

    //fungsi update data
    function update($timestamp,$temperature=null, $humidity=null){
        $hasil= $this->getSensorPilihan($timestamp);
        $count=count($hasil["data"]);
        if ($count==0){ 
            http_response_code(503);
            return array('msg' => "Data tidak  ada, tidak dapat disimpan" );
        }
        else if ($timestamp  == null){
            http_response_code(503);
            return array('msg' => "Kode tidak boleh kosong, tidak berhasil disimpan" );
        } else {
            $this->setValue($hasil["data"][0]["timeStamp"],
            $hasil["data"][0]["temperature"],
                    $hasil["data"][0]["humidity"]
                    );

            if ($temperature!=null) $this->temperature=$temperature;
            if ($humidity!=null) $this->humidity=$humidity;


            $kueri = "UPDATE ".$this->table_name." SET ";
            $kueri .= "temperature='".$this->temperature."',";
            $kueri .= "humidity='".$this->humidity."'";
            $kueri .= " WHERE timeStamp='".$this->timestamp."'";
            $hasil = $this->db->query($kueri);
            if ($hasil){
                http_response_code(201);
                return array('msg'=>'success');
            } else {
                http_response_code(503);
                return array('msg'=>'Data Gagal Disimpan '.$this->db->error." ".$kueri); 
            }
            // return array('msg'=>$kueri);
        }
    }
    

    function getAll(){
        // return "test";
        $kueri = "SELECT * FROM ".$this->table_name." ORDER BY timeStamp";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);
        http_response_code(200);
        $data = array();
        while ($row = $hasil->fetch_assoc()){
            $data[]=$row;
        }
        if(count($data)==0)
            return array("msg"=>"Data Tidak Ada", "data"=>array());
        
        return array("msg"=>"success", "data"=>$data);
    }

    function getSensorPilihan($timestamp){
        // return "test";
        $kueri = "SELECT * FROM ".$this->table_name;
        $kueri .=" WHERE timeStamp='".$timestamp."'";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);
        http_response_code(200);
        $data = array();
        while ($row = $hasil->fetch_assoc()){
            $data[]=$row;
        }
        if (count($data)==0)
            return array("msg"=>"Data tidak ada ", "data"=>array());
        return array("msg"=>"success", "data"=>$data);
    }

    ///fungsi delete data
    function delete($timestamp){
        // return "test";
        $data="";
        $row = $this->getSensorPilihan($timestamp);
        if (count($row["data"])==0) {
            http_response_code(304);
            return array("msg"=>$row["msg"]."timeStamp ".$timestamp);
            return array('msg'=>$kueri);
        }

        $kueri = "DELETE FROM ".$this->table_name;
        $kueri .=" WHERE timeStamp='".$timestamp."'";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);

        http_response_code(200);
        return array("msg"=>"success");
    }

}