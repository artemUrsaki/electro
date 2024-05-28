<?php 
class Slider extends Database {
    private $db;
    
    public function __construct() {
        $this->db = $this->db_connection();
    }

    public function select_date() {
        try {
            $query = "SELECT * FROM product_item pi 
            JOIN product p ON(p.product_id = pi.product_id) 
            JOIN category c ON(c.category_id = p.category) 
            ORDER BY pi.create_date DESC 
            LIMIT 10";

            $statement = $this->db->prepare($query);
            $statement->execute();
            $res = $statement->fetchAll();
            return $res;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select_rating() {
        try {
            $query = "SELECT pi.*, p.*, c.*  FROM product_item pi
            JOIN product p ON(p.product_id = pi.product_id)
            JOIN category c ON(c.category_id = p.category)
            JOIN (SELECT product_item_id, avg(rate) rating FROM review GROUP BY product_item_id HAVING rating > 3) r ON(r.product_item_id = pi.id)";

            $statement = $this->db->prepare($query);
            $statement->execute();
            $res = $statement->fetchAll();
            return $res;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select_category($category, $product_id=0) {
        try {
            $query = "SELECT * FROM product_item pi
            JOIN product p ON(p.product_id = pi.product_id)
            JOIN category c ON(c.category_id = p.category)
            WHERE c.category_name = :category";

            if($product_id > 0) {
                $query .= " AND pi.id <> :product_id";
            }

            $statement = $this->db->prepare($query);
            $statement->bindParam('category', $category);

            if($product_id > 0) {
                $statement->bindParam('product_id', $product_id);
            }

            $statement->execute();
            $res = $statement->fetchAll();
            return $res;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function slider_category($category) {
        $statement = $this->select_category($category);
        $res = '';
        for($i = 0; $i < count($statement); $i++) {
            if($i % 3 == 0) {
                $res .= '<div>';
            }

            $res .= '<div class="product-widget">
            <div class="product-img">
                <img src="' .$statement[$i]->image .'" alt="">
            </div>
            <div class="product-body">
                <p class="product-category">' .$statement[$i]->category_name .'</p>
                <h3 class="product-name"><a href="/electro/templates/product.php?id='. $statement[$i]->id .'">' . $statement[$i]->product_name .'</a></h3>
                <h4 class="product-price">'. $statement[$i]->price .'</h4>
            </div>
            </div>';

            if($i % 3 == 2) {
                $res .= '</div>';
            }
        }
        if(count($statement) % 3 > 0) {
            $res .= '</div>';
        }
        return $res;
    }

    public function get_slider_items($type, $product_id=0) {
        $query = array();

        switch($type) {
            case 'date':
                $query = $this->select_date();
                break;
            case 'rating':
                $query = $this->select_rating();
                break;
            default:
                $this->select_category($type, $product_id);
        }
        
        $product_obj = new Product();
        
        $res = '';
        foreach($query as $line) {
            $res .= $product_obj->product_construct($line);
        }

        return $res;
    }

    
}