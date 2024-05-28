<?php
class Store extends Database {

    private $db;
    private $cur_page;

    public function __construct() {
        $this->db = $this->db_connection();
        $this->cur_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    }

    public function select() {
        try {
            $query = "SELECT * FROM product_item pi 
            JOIN product p ON(p.product_id = pi.product_id) 
            JOIN category c ON(c.category_id = p.category)
            LEFT JOIN (SELECT product_item_id, avg(rate) rating FROM review GROUP BY product_item_id) r ON(r.product_item_id = pi.id)";

            if (isset($_GET['action']) && $_GET['action'] == 'filter') {
                $query .= $this->get_filtered_items();
                $query .= $this->get_sorted_items();
            }

            $pagination_obj = new Pagination(20);
            return $pagination_obj->limit_query($query, $this->cur_page);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function get_filtered_items() {
        $query = '';
        if (isset($_GET['minimum'], $_GET['maximum']) && !empty($_GET['minimum']) && !empty($_GET['maximum'])) {
            $query .= " WHERE price BETWEEN " .$_GET['minimum'] ." AND " .$_GET['maximum'];
        }
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $categories = implode("','", $_GET['category']);
            $query .= " AND c.category_name IN ('" .$categories ."')";
        }
        if (isset($_GET['brand']) && !empty($_GET['brand'])) {
            $brands = implode("','", $_GET['brand']);
            $query .= " AND brand IN ('" .$brands ."')";
        }
        return $query;
    }

    private function get_sorted_items() {
        $query = '';
        if(isset($_GET['sortby'])) {
            switch($_GET['sortby']) {
                case 'price-low':
                    $query .= " ORDER BY pi.price";
                    break;
                case 'price-high':
                    $query .= " ORDER BY pi.price DESC";
                    break;
                default:
                    $query .= " ORDER BY r.rating DESC";
            }
        }
        return $query;
    }

    public function get_store() {
        $store = $this->select();
        $product_obj = new Product();
        $res = '';
        foreach ($store as $line) {
            $res .= '<div class="col-md-4 col-xs-6">';
            
            $res .=  $product_obj->product_construct($line);

            $res .= '</div>';
        }

        return $res;
    }
    
    public function category_filter() {
        try {
            $query = $this->db->query("SELECT c.*, count(pi.id) amount FROM category c 
            LEFT JOIN product p ON(c.category_id = p.category)
            LEFT JOIN product_item pi ON(p.product_id = pi.product_id)
            GROUP BY c.category_name");

            $query_run = $query->fetchAll();

            $res = '';
            for ($i = 0; $i < count($query_run); $i++) {
                $res .= '<div class="input-checkbox">
                <input type="checkbox" id="category-' .$i .'" class="check-filter category-filter" value="' .$query_run[$i]->category_name .'"';

                if(isset($_GET['category']) && $_GET['category'] == $query_run[$i]->category_name) {
                    $res .= ' checked="checked"';
                    unset($_GET['category']);
                }

                $res .= '><label for="category-' .$i .'">
                    <span></span>'. $query_run[$i]->category_name .'<small>(' .$query_run[$i]->amount .')</small>
                </label>
                </div>';
            }
            return $res;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }   
    }

    public function brand_filter() {
        try {
            $query = "SELECT DISTINCT p.brand, count(pi.id) amount FROM product p
            JOIN product_item pi ON (p.product_id = pi.product_id)
            GROUP BY p.brand";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $res = $statement->fetchAll();

            for ($i = 0; $i < count($res); $i++) {
                echo '<div class="input-checkbox">
                <input type="checkbox" id="brand-' .$i .'" class="check-filter brand-filter" value="'. $res[$i]->brand .'">
                <label for="brand-'. $i .'">
                    <span></span>'.  strtoupper($res[$i]->brand) .'<small>('. $res[$i]->amount .')</small>
                </label>
                </div>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function slider_getPrice(string $value) {
        try{
            $query = "SELECT " .$value ."(price) " .$value ." FROM product_item";
            $run = $this->db->prepare($query);
            $run->execute();
            $res = $run->fetch();
            return $res->$value;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
