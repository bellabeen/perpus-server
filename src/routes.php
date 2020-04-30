<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    //function select peminjaman all
    $app->get("/peminjaman/", function (Request $request, Response $response){
        $sql = "SELECT * FROM peminjaman";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });
    
    //function select peminjaman by id
    $app->get("/peminjaman/{id}", function (Request $request, Response $response, $args){
        $id = $args["id"];
        $sql = "SELECT * FROM peminjaman WHERE id_peminjaman=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });
    
    // $app->get("/books/search/", function (Request $request, Response $response, $args){
    //     $keyword = $request->getQueryParam("keyword");
    //     $sql = "SELECT * FROM books WHERE title LIKE '%$keyword%' OR sinopsis LIKE '%$keyword%' OR author LIKE '%$keyword%'";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute([":id" => $id]);
    //     $result = $stmt->fetchAll();
    //     return $response->withJson(["status" => "success", "data" => $result], 200);
    // });
    
    //function add peminjaman
    $app->post("/peminjaman/", function (Request $request, Response $response){
    
        $new_peminjaman = $request->getParsedBody();
    
        $sql = "INSERT INTO peminjaman (id_buku, id_peminjam, tanggal_pesan, jam_pesan, expired_date,
        tanggal_pinjam, batas_kembali, tanggal_pengembalian, status, PP ) VALUE (:id_buku, :id_peminjam, :tanggal_pesan,
        :jam_pesan, :expired_date, :tanggal_pinjam, :batas_kembali, :tanggal_pengembalian, :status, :PP)";
        $stmt = $this->db->prepare($sql);
    
        $data = [
            ":id_buku" => $new_peminjaman["id_buku"],
            ":id_peminjam" => $new_peminjaman["id_peminjam"],
            ":tanggal_pesan" => $new_peminjaman["tanggal_pesan"],
            ":jam_pesan" => $new_peminjaman["jam_pesan"],
            ":expired_date" => $new_peminjaman["expired_date"],
            ":tanggal_pinjam" => $new_peminjaman["tanggal_pinjam"],
            ":batas_kembali" => $new_peminjaman["batas_kembali"],
            ":tanggal_pengembalian" => $new_peminjaman["tanggal_pengembalian"],
            ":status" => $new_peminjaman["status"],
            ":PP" => $new_peminjaman["PP"]

        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });
    
    //function edit peminjaman by id
    $app->put("/peminjaman/{id}", function (Request $request, Response $response, $args){
        $id = $args["id"];
        $new_peminjaman = $request->getParsedBody();
        $sql = "UPDATE peminjaman SET id_buku=:id_buku, id_peminjam=:id_peminjam, tanggal_pesan=:tanggal_pesan,
        jam_pesan=:jam_pesan, expired_date=:expired_date, tanggal_pinjam=:tanggal_pinjam, batas_kembali=:batas_kembali,
        tanggal_pengembalian=:tanggal_pengembalian, status=:status, PP=:PP WHERE id_peminjaman=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id,
            ":id_buku" => $new_peminjaman["id_buku"],
            ":id_peminjam" => $new_peminjaman["id_peminjam"],
            ":tanggal_pesan" => $new_peminjaman["tanggal_pesan"],
            ":jam_pesan" => $new_peminjaman["jam_pesan"],
            ":expired_date" => $new_peminjaman["expired_date"],
            ":tanggal_pinjam" => $new_peminjaman["tanggal_pinjam"],
            ":batas_kembali" => $new_peminjaman["batas_kembali"],
            ":tanggal_pengembalian" => $new_peminjaman["tanggal_pengembalian"],
            ":status" => $new_peminjaman["status"],
            ":PP" => $new_peminjaman["PP"]
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });
    
    //function delete peminjaman by id
    $app->delete("/peminjaman/{id}", function (Request $request, Response $response, $args){
        $id = $args["id"];
        $sql = "DELETE FROM peminjaman WHERE id_peminjaman=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });
    
};
