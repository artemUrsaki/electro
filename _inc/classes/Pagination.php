<?php 

class Pagination extends Database {
    private $db;
    private $cur_page;
    private $items_per_page;

    public function __construct($items_per_page) {
        $this->db = $this->db_connection();
        $this->cur_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $this->items_per_page = $items_per_page;
    }

    public function limit_query($query, $cur_page, array $params = []) {
        try {
            $query .= " LIMIT ?, ?";

            $calc_page = ($cur_page-1)*$this->items_per_page;
            array_push($params, $calc_page, $this->items_per_page);

            $statement = $this->db->prepare($query);
            for ($i = 1; $i <= count($params); $i++) {
                $statement->bindParam($i, $params[$i-1], PDO::PARAM_INT);
            }
            $statement->execute();
            $res = $statement->fetchAll();

            return $res;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function pagination() {
        $query = "SELECT count(id) amount FROM product_item";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $all_items = $statement->fetch()->amount;

        $pages = ceil($all_items / $this->items_per_page);

        if ($pages > 1) {
            if ($this->cur_page > 1) {
                echo '<li><a href="store.php?page='. $this->cur_page+1 .'"><</a></li>';
            }
            if ($this->cur_page - 1 > 0) {
                echo '<li><a href="store.php?page='. $this->cur_page-1 .'">' .$this->cur_page-1 .'</a></li>';
            }

            echo '<li class="active">' .$this->cur_page .'</li>';
            
            if ($this->cur_page < $pages) {
                echo '<li><a href="store.php?page='. $this->cur_page+1 .'">' .$this->cur_page+1 .'</a></li>';
                echo '<li><a href="store.php?page='. $this->cur_page+1 .'"><i class="fa fa-angle-right"></i></a></li>';
            }
        }
    }
}