<?php

class Product extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->db_connection();
    }

    public function add($brand, $name, $code, $category, $colour, $size, $qty, $image, $price) {
        try {
            $query = "INSERT IGNORE INTO `category`(category_name) VALUES(:category);
            INSERT IGNORE INTO `colour_var`(colour) VALUES(:colour);
            INSERT IGNORE INTO `product`(brand, product_name, code, category) VALUES(:brand, :product_name, :code, (
                SELECT category_id FROM `category` WHERE category_name = :category
            ));
            INSERT IGNORE INTO `product_item`(product_id, colour_id, size, qty, price, image) VALUES((
                SELECT product_id FROM `product` WHERE brand = :brand
                AND product_name = :product_name
                AND code = :code
            ), (
                SELECT colour_id FROM `colour_var` WHERE colour = :colour
            ), :size, :qty, :price, :image);
            INSERT IGNORE INTO `images`(product_item_id, image_url) VALUES((
                SELECT id FROM `product_item` WHERE image = :image
            ), :image);";

            $data = array(
                'category'=>$category,
                'colour'=>$colour,
                'size'=>$size,
                'brand'=>$brand,
                'product_name'=>$name,
                'code'=>$code,
                'qty'=>$qty,
                'price'=>$price,
                'image'=>$image,
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function get_product() {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $query = "SELECT * FROM product_item pi
                JOIN product p ON(p.product_id = pi.product_id)
                JOIN colour_var cv ON(cv.colour_id = pi.colour_id)
                JOIN category c ON(c.category_id = p.category)
                WHERE pi.id = :id";

                $statement = $this->db->prepare($query);
                $statement->bindParam('id', $id, PDO::PARAM_INT);
                $statement->execute();
                $res = $statement->fetch();
    
                if ($res) { 
                    return $res;
                } else {
                    header('Location: error.php');
                    die();
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            header('Location: error.php');
            die();
        }
    }

    public function product_construct(array $query, $i) {
        $res = '<div class="product">
        <div class="product-img" style="background-image: url(\'' .$query[$i]->image .'\');"></div>
        <div class="product-body">
            <p class="product-category">' .$query[$i]->category_name .'</p>
            <h3 class="product-name"><a href="../templates/product.php?id=' .$query[$i]->id .'">' .$query[$i]->brand. ' ' .$query[$i]->product_name .'</a></h3>
            <h4 class="product-price">' .$query[$i]->price .'</h4>
            <div class="product-rating">';
                
        $rating_obj = new Rating();
        $res .= $rating_obj->avg_rating($query[$i]->id, true);

        $res .= '</div>
            <div class="product-btns">
                <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
            </div>
        </div>
        <div class="add-to-cart">
            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
        </div>
        </div>';

        return $res;
    }

    public function get_item_colors($product_id) {
        try {
            $query = "SELECT DISTINCT c.* FROM colour_var c
            JOIN product_item pi ON(pi.colour_id = c.colour_id)
            WHERE product_id = :product_id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('product_id', $product_id);
            $statement->execute();
            $res = $statement->fetchAll();

            return $res;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_item_imgs($product_id) {
        try {
            $query = "SELECT * FROM images WHERE product_item_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $product_id, PDO::PARAM_INT);
            $statement->execute();
            $fetch = $statement->fetchAll();

            return $fetch;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}