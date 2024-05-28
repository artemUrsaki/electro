<?php 

class Reviews extends Database {
    private $db;
    private $cur_page;

    public function __construct() {
        $this->db = $this->db_connection();
        $this->cur_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    }

    public function add_review($user_id, $product_id, $text, $rating) {
        try {
            $query = "INSERT INTO `review`(user_id, product_item_id, review_text, rate) VALUES(:user_id, :product_id, :text, :rating)";
            
            $data = array(
                'user_id'=>$user_id,
                'product_id'=>$product_id,
                'text'=>$text,
                'rating'=>$rating,
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function edit_review($review_id, $text, $rating) {
        try {
            $query = "UPDATE `review` SET review_text = :text, rate = :rate WHERE review_id = :id";

            $data = array(
                'text'=>$text,
                'rate'=>$rating,
                'id'=>$review_id
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete_review($review_id) {
        try {
            $query = "DELETE FROM `review` WHERE review_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $review_id);
            $statement->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select($product_id) {
        try {
            $query = "SELECT * FROM user u
            JOIN review r ON(r.user_id = u.user_id)
            WHERE product_item_id = ?";

            $pagination_obj = new Pagination(5);
            return $pagination_obj->limit_query($query, $this->cur_page, [$product_id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select_single($review_id) {
        try {
            $query = "SELECT * FROM `review` WHERE review_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $review_id);
            $statement->execute();

            $res = $statement->fetch();
            return $res;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_reviews($product_id) {
        $reviews = $this->select($product_id);

        $rating_obj = new Rating();

        $res = '';
        foreach ($reviews as $review) {
            $date = date_create($review->review_date);
            $date_format = strtoupper(date_format($date, 'j F Y, g:i a'));

            $res .= '<li>
            <div class="review-heading">
                <h5 class="name">'. $review->first_name .'</h5>
                <p class="date">'. $date_format .'</p>
                <div class="review-rating">';

            $res .= $rating_obj->show_rating($review->rate);

            $res .= '</div>
            </div>
            <div class="review-body">
                <p>'. $review->review_text .'</p>
            </div>';

            if(isset($_SESSION['logged-in']) && ($_SESSION['is-admin'] == 1 || $_SESSION['user-id'] == $review->user_id)) {
                $res .= '<div class="product-edits">
                <form action="edit-review.php" method="POST">
                <button class="admin-btn" type="submit" name="review_id" value="'. $review->review_id .'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </form>
                <form method="POST">
                <button class="admin-btn" type="submit" name="review_id" value="'. $review->review_id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>
                </div>';
            }

            $res .= '</li>';
        }

        return $res;
    }
}
