<?php 

class Reviews extends Database {
    private $db;
    private $cur_page;

    public function __construct() {
        $this->db = $this->db_connection();
        $this->cur_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
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
            </div>
            </li>';
        }

        return $res;
    }
}
