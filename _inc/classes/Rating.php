<?php 

class Rating extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->db_connection();
    }

    public function select_rating($review_id) {
        try {
            $query = "SELECT rate FROM review WHERE review_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $review_id);
            $statement->execute();
            $res = $statement->fetch();

            return $this->show_rating($res->rate);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function avg_rating($product_id, bool $show=false) {
        try {
            $query = "SELECT avg(rate) avgr FROM review WHERE product_item_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $product_id);
            $statement->execute();
            $res = $statement->fetch();

            if ($show) return $this->show_rating($res->avgr);
            else return number_format($res->avgr, 1);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function show_rating($rating) {
        $res = '';
        for ($i = 0; $i < $rating; $i++) {
            $res .= '<i class="fa fa-star"></i> ';
        }
        for ($i = 0; $i < 5 - $rating; $i++) {
            $res .= '<i class="fa fa-star-o empty"></i> ';
        }

        return $res;
    }

    public function count_reviews($product_id) {
        try {
            $query = "SELECT count(review_id) amount FROM review WHERE product_item_id = :product_id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('product_id', $product_id);
            $statement->execute();
            $res = $statement->fetch();

            return $res->amount;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function count_rating($product_id, $rating) {
        try {
            $query = "SELECT count(review_id) amount FROM review WHERE rate = :rating AND product_item_id = :product_id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('rating', $rating);
            $statement->bindParam('product_id', $product_id);
            $statement->execute();
            $res = $statement->fetch();

            return $res->amount;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>