<?php
class Veritabani {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "adys_proje";
    public $conn;

    public function baglan() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
            $this->conn->set_charset("utf8");
        } catch(Exception $e) {
            echo "Bağlantı Hatası: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>