<?php 

class Image extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->db_connection();
    }

    public function add_img($product_id, $img) {
        try {
            $query = "INSERT IGNORE INTO `images`(product_item_id, image_url) VALUES(:product_id, :img)";
            
            $data = array(
                'product_id'=>$product_id,
                'img'=>$img
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function get_img($img_id) {
        try {
            $query = "SELECT image_url FROM `images` WHERE image_id = :id";
            
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $img_id);
            $statement->execute();

            $res = $statement->fetch();
            if(!empty($res)) return true;
            return false;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function edit_img($img_id, $img) {
        try {
            $query = "UPDATE IGNORE `images` SET image_url = :img WHERE image_id = :id";

            $data = array(
                'img'=>$img,
                'id'=>$img_id
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);
            
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete_img($img_id) {
        try{
            $query = "DELETE FROM `images` WHERE image_id = :id";

            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $img_id);
            $statement->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}