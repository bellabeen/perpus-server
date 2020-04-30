<?php
include_once (__DIR__ . "/DB.php");
class Buku{
    private $table_name='peminjaman';
    private $db = null;

    public $id_peminjaman;
    public $id_buku;
    public $id_peminjam = null;
    private $tanggal_pesan = null;
    private $jam_pesan = null;
    private $expired_date = null;
    private $tanggal_pinjam = null;
    private $batas_kembali = null;
    private $tanggal_pengembalian = null;
    private $status = null;
    private $pp = null;



    function __construct(){
        if ($this->db ==  null){
            $conn = new DB();
            $this->db = $conn->db;
        }
    }

    function setValue($id_buku, $id_peminjam, $tanggal_pesan, $jam_pesan, $expired_date,
    $tanggal_pinjam, $batas_kembali, $tanggal_pengembalian, $status, $pp){
        // $this();
        // $this->id = $id;
        $this->id_buku = $id_buku;
        $this->id_peminjam = $id_peminjam;
        $this->tanggal_pesan = $tanggal_pesan;
        $this->jam_pesan = $jam_pesan;
        $this->expired_date = $expired_date;
        $this->tanggal_pinjam = $tanggal_pinjam;
        $this->batas_kembali = $batas_kembali;
        $this->tanggal_pengembalian = $tanggal_pengembalian;
        $this->status = $status;
        $this->pp = $pp;

    }


    ///fungsi pennyimpanan data berhasil atau tidak
    function createPeminjaman(){
        // $count = count($this->getBukuPilihan($this->kode_buku));
        $bk= $this->getPeminjamanPilihan($this->id_peminjaman);
        $count = count($bk["data"]);
        if ($count>0) {
            http_response_code(503);
            return array('msg' => "Data sudah ada, tidak berhasil disimpan");
        } 

        else{
            $kueri = "INSERT INTO ".$this->table_name." SET ";
            $kueri .= "id_buku='".$this->id_buku ."',";
            $kueri .= "id_peminjam='".$this->id_peminjam ."',";
            $kueri .= "tanggal_pesan='".$this->tanggal_pesan ."',";
            $kueri .= "jam_pesan='".$this->jam_pesan ."',";
            $kueri .= "expired_date='".$this->expired_date ."',";
            $kueri .= "tanggal_pinjam='".$this->tanggal_pinjam ."',";
            $kueri .= "batas_kembali='".$this->batas_kembali ."',";
            $kueri .= "tanggal_pengembalian='".$this->tanggal_pengembalian ."',";
            $kueri .= "status='".$this->status ."',";
            $kueri .= "pp='".$this->pp."'";
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
    function update($id, $suhu, $kelembapan_udara, $kelembapan_tanah, $ph){
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
            $this->setValue($hasil["data"][0]["suhu"],
            $hasil["data"][0]["kelembapan_udara"],
            $hasil["data"][0]["kelembapan_tanah"],
            $hasil["data"][0]["ph"]
                    );

            if ($suhu!=null) $this->suhu=$suhu;
            if ($kelembapan_udara!=null) $this->kelembapan_udara=$kelembapan_udara;
            if ($kelembapan_tanah!=null) $this->kelembapan_tanah=$kelembapan_tanah;
            if ($ph!=null) $this->ph=$ph;

            $kueri .= "suhu='".$this->suhu ."',";
            $kueri .= "kelembapan_udara='".$this->kelembapan_udara ."',";
            $kueri .= "kelembapan_tanah='".$this->kelembapan_tanah ."',";
            $kueri .= "ph='".$this->ph."'";


            $kueri = "UPDATE ".$this->table_name." SET ";
            $kueri .= "suhu='".$this->suhu ."',";
            $kueri .= "kelembapan_udara='".$this->kelembapan_udara."',";
            $kueri .= "kelembapan_tanah='".$this->kelembapan_tanah."',";
            $kueri .= "ph='".$this->ph ."'";
            
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
    
    function getPeminjaman(){
        // return "test";
        // $kueri = "SELECT id, suhu, kelembapan_tanah, kelembapan_udara, ph, DATE_FORMAT(waktu, '%d-%m-%Y' ) AS waktu FROM ".$this->table_name." ORDER BY waktu";
        // $kueri = "SELECT * FROM ".$this->table_name." WHERE waktu = '$tgl'";
        $kueri = "SELECT * FROM ".$this->table_name."";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);
        http_response_code(200);
        $data = array();
        while ($row = $hasil->fetch_assoc()){
            $data[]=$row;
        }
        if(count($data)==0)
            return array("msg"=>"Data Tidak Ada", "data"=>array());
        
        return array("data"=>$data);
    }




    function getAllWaktu($tglawal,$tglakhir){
        // return "test";
        //$kueri = "SELECT id, suhu, kelembapan_tanah, kelembapan_udara, ph, DATE_FORMAT(waktu, '%Y-%m-%d' ) AS waktu FROM ".$this->table_name." WHERE waktu='".$tgl."'";
        $kueri = "SELECT * FROM ".$this->table_name." WHERE waktu BETWEEN '$tglawal 00:00:00' AND '$tglakhir 23:59:59'";
		
		// $kueri = "SELECT * FROM ".$this->table_name." WHERE waktu = '$tgl'";
        // $kueri = "SELECT * FROM ".$this->table_name." ORDER BY waktu";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);
        http_response_code(200);
        $data = array();
        while ($row = $hasil->fetch_assoc()){
            $data[]=$row;
        }
        if(count($data)==0)
            return array("msg"=>"Data Tidak Ada", "data"=>array());
        
        return array("data"=>$data);
    }

    function getAllDate($tgl){
        $kueri = "SELECT id, suhu, kelembapan_tanah, kelembapan_udara, ph, DATE_FORMAT(waktu, '%d-%m-%Y' ) AS waktu FROM ".$this->table_name." ORDER BY waktu";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);
        http_response_code(200);
        $data = array();
        while ($row = $hasil->fetch_assoc()){
            $data[]=$row;
        }
        if(count($data)==0)
            return array("msg"=>"Data Tidak Ada", "data"=>array());
        
        return array("data"=>$data);
    }

    function getAllFilter(){
        // return "test";
        $kueri = "SELECT * FROM ".$this->table_name." ORDER BY waktu DESC LIMIT 1";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);
        http_response_code(200);
        $data = array();
        while ($row = $hasil->fetch_assoc()){
            $data[]=$row;
        }
        if(count($data)==0)
            return array("msg"=>"Data Tidak Ada", "data"=>array());
        
        return array("data"=>$data);
    }

    function getnData(){
                // return "test";
                $kueri = "SELECT COUNT(*) AS jumlah FROM ".$this->table_name."";
                $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);
                http_response_code(200);
                $data = array();
                while ($row = $hasil->fetch_assoc()){
                    $data[]=$row;
                }
                if(count($data)==0)
                    return array("msg"=>"Data Tidak Ada", "data"=>array());
                return array("data"=>$data);
    }

    ///fungsi delete data Peminjaman
    function deletePeminjaman($id_peminjaman){
        // return "test";
        $data="";
        $row = $this->getPeminjamanPilihan($id_peminjaman);
        if (count($row["data"])==0) {
            http_response_code(304);
            return array("msg"=>$row["msg"]."id_peminjaman ".$id_peminjaman);
            return array('msg'=>$kueri);
        }

        $kueri = "DELETE FROM ".$this->table_name;
        $kueri .=" WHERE id_peminjaman='".$id_peminjaman."'";
        $hasil = $this->db->query($kueri) or die ("Error ".$this->db->connect_error);

        http_response_code(200);
        return array("msg"=>"success");
    }

    function getPeminjamanPilihan($id_peminjaman){
        // return "test";
        $kueri = "SELECT * FROM ".$this->table_name;
        $kueri .=" WHERE id_peminjaman='".$id_peminjaman."'";
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

}