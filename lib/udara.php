<?php
include_once (__DIR__ . "/DB.php");
class Sensor{
    private $table_name='log';
    private $db = null;
    public  $id;
    private $humidity=null;
    private $temperature=null;
    private $gas_dan_asap=null;
    private $co=null;
    private $amonia=null;
    private $hidrogen_sulfida=null;
    private $konsentrasi_debu=null;
    function __construct(){
        if ($this->db ==  null){
            $conn = new DB();
            $this->db = $conn->db;
        }
    }

    function setValue($humidity, $temperature, $gas_dan_asap, $co, $amonia, $hidrogen_sulfida, $konsentrasi_debu){
        // $this();
        $this->id = $id;
        $this->humidity = $humidity;
        $this->temperature= $temperature;
        $this->gas_dan_asap = $gas_dan_asap;
        $this->co = $co;
        $this->amonia = $amonia;
        $this->hidrogen_sulfida = $hidrogen_sulfida;
        $this->konsentrasi_debu = $konsentrasi_debu;

    }


    ///fungsi pennyimpanan data berhasil atau tidak
    function create(){
        // $count = count($this->getBukuPilihan($this->kode_buku));
        $bk= $this->getSensorPilihan($this->id);
        $count = count($bk["data"]);
        if ($count>0) {
            http_response_code(503);
            return array('msg' => "Data sudah ada, tidak berhasil disimpan");
        } 

        else{
            $kueri = "INSERT INTO ".$this->table_name." SET ";
            $kueri .= "humidity='".$this->humidity ."',";
            $kueri .= "temperature='".$this->temperature ."',";
            $kueri .= "gas_dan_asap='".$this->gas_dan_asap ."',";
            $kueri .= "co='".$this->co ."',";
			$kueri .= "amonia='".$this->amonia ."',";
            $kueri .= "hidrogen_sulfida='".$this->hidrogen_sulfida ."',";
            $kueri .= "konsentrasi_debu='".$this->konsentrasi_debu."'";
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
    function update($id,$humidity=null, $temperature=null, $gas_dan_asap=null, $co=null, $amonia=null,
	$hidrogen_sulfida=null, $konsentrasi_debu=null){
        $hasil= $this->getSensorPilihan($id);
        $count=count($hasil["data"]);
        if ($count==0){ 
            http_response_code(503);
            return array('msg' => "Data tidak  ada, tidak dapat disimpan" );
        }
        else if ($id  == null){
            http_response_code(503);
            return array('msg' => "Kode tidak boleh kosong, tidak berhasil disimpan" );
        } else {
            $this->setValue($hasil["data"][0]["humidity"],
            $hasil["data"][0]["temperature"],
            $hasil["data"][0]["gas_dan_asap"],
            $hasil["data"][0]["co"],
            $hasil["data"][0]["amonia"],
            $hasil["data"][0]["hidrogen_sulfida"],
            $hasil["data"][0]["konsentrasi_debu"]
                    );

            if ($humidity!=null) $this->humidity=$humidity;
            if ($temperature!=null) $this->temperature=$temperature;
            if ($gas_dan_asap!=null) $this->gas_dan_asap=$gas_dan_asap;
            if ($co!=null) $this->co=$co;
            if ($amonia!=null) $this->amonia=$amonia;
            if ($hidrogen_sulfida!=null) $this->hidrogen_sulfida=$hidrogen_sulfida;
            if ($konsentrasi_debu!=null) $this->konsentrasi_debu=$konsentrasi_debu;


            $kueri .= "humidity='".$this->humidity ."',";
            $kueri .= "temperature='".$this->temperature ."',";
            $kueri .= "gas_dan_asap='".$this->gas_dan_asap ."',";
            $kueri .= "co='".$this->co ."',";
            $kueri .= "amonia='".$this->amonia ."',";
            $kueri .= "hidrogen_sulfida='".$this->hidrogen_sulfida ."',";
            $kueri .= "konsentrasi_debu='".$this->konsentrasi_debu ."',";



            $kueri = "UPDATE ".$this->table_name." SET ";
            $kueri .= "humidity='".$this->humidity ."',";
            $kueri .= "temperature='".$this->temperature ."',";
            $kueri .= "gas_dan_asap='".$this->gas_dan_asap ."',";
            $kueri .= "co='".$this->co ."',";
            $kueri .= "amonia='".$this->amonia ."',";
            $kueri .= "hidrogen_sulfida='".$this->hidrogen_sulfida ."',";
            $kueri .= "konsentrasi_debu='".$this->konsentrasi_debu ."',";
            $kueri .= " WHERE id='".$this->id."'";
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
        $kueri = "SELECT * FROM ".$this->table_name." ORDER BY id";
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


    function getHumidity(){
        // return "test";
        $kueri = "SELECT HOUR(date) FROM ".$this->table_name." ORDER BY id";
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


    function getSensorPilihan($id){
        // return "test";
        $kueri = "SELECT * FROM ".$this->table_name;
        $kueri .=" WHERE id='".$id."'";
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
    function delete($id){
        // return "test";
        $data="";
        $row = $this->getSensorPilihan($id);
        if (count($row["data"])==0) {
            http_response_code(304);
            return array("msg"=>$row["msg"]."id ".$id);
            return array('msg'=>$kueri);
        }

        $kueri = "DELETE FROM ".$this->table_name;
        $kueri .=" WHERE id='".$id  ."'";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);

        http_response_code(200);
        return array("msg"=>"success");
    }

}