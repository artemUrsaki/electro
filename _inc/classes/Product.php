<?php

class Product extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->db_connection();
    }

    public function add($brand, $name, $category, $colour, $size, $qty, $image, $price) {
        try {
            $query = "INSERT IGNORE INTO `category`(category_name) VALUES(:category);
            INSERT IGNORE INTO `colour_var`(colour) VALUES(:colour);
            INSERT IGNORE INTO `product`(brand, product_name, category) VALUES(:brand, :product_name, (
                SELECT category_id FROM `category` WHERE category_name = :category
            ));
            INSERT IGNORE INTO `product_item`(product_id, colour_id, size, qty, price, image) VALUES((
                SELECT product_id FROM `product` WHERE brand = :brand
                AND product_name = :product_name
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

    public function edit($brand, $name, $category, $colour, $size, $qty, $image, $price, $product_item_id) {
        try{
            $query = "INSERT IGNORE INTO `category`(category_name) VALUES(:category);
            INSERT IGNORE INTO `colour_var`(colour) VALUES(:colour);
            UPDATE `product` SET brand = :brand, product_name = :product_name, category = (
                SELECT category_id FROM `category` WHERE category_name = :category
            ) WHERE product_id = (
                SELECT product_id FROM `product_item` WHERE id = :product_item_id
            );
            UPDATE `product_item` SET product_id = (
                SELECT id FROM `product` WHERE product_name = :product_name AND brand = :brand
            ), colour_id = (
                SELECT colour_id FROM `colour_var` WHERE colour = :colour
            ), size = :size, qty = :qty, price = :price, image = :image WHERE id = :product_item_id;
            INSERT IGNORE INTO `images`(product_item_id, image_url) VALUES(:product_item_id, :image);";

            $data = array(
                'category'=>$category,
                'colour'=>$colour,
                'size'=>$size,
                'brand'=>$brand,
                'product_name'=>$name,
                'qty'=>$qty,
                'price'=>$price,
                'image'=>$image,
                'product_item_id'=>$product_item_id,
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($product_id) {
        try{
            $query = "DELETE FROM `images` WHERE product_item_id = :id;
            DELETE FROM `product_item` WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $product_id);
            $statement->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_product($product_id) {
        if (is_numeric($product_id)) {
            try {
                $query = "SELECT * FROM product_item pi
                JOIN product p ON(p.product_id = pi.product_id)
                JOIN colour_var cv ON(cv.colour_id = pi.colour_id)
                JOIN category c ON(c.category_id = p.category)
                WHERE pi.id = :id";

                $statement = $this->db->prepare($query);
                $statement->bindParam('id', $product_id, PDO::PARAM_INT);
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

    public function product_construct($line) {
        $res = '<div class="product">
        <div class="product-img" style="background-image: url(\'' .$line->image .'\');"></div>
        <div class="product-body">
            <p class="product-category">' .$line->category_name .'</p>
            <h3 class="product-name"><a href="../templates/product.php?id=' .$line->id .'">' .$line->brand. ' ' .$line->product_name .'</a></h3>
            <h4 class="product-price">' .$line->price .' €</h4>
            <div class="product-rating">';
                
        $rating_obj = new Rating();
        $res .= $rating_obj->avg_rating($line->id, true);

        $res .= '</div>
        </div>
        <div class="add-to-cart">
            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
        </div>';

        if(isset($_SESSION['is-admin']) && $_SESSION['is-admin'] == 1) {
            $res .= '<div class="product-edits">
            <form action="edit-product.php" method="POST">
            <button class="admin-btn" type="submit" name="product_id" value="'. $line->id .'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            </form>
            <form method="POST">
            <button class="admin-btn" type="submit" name="product_id" value="'. $line->id .'"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </form>
            </div>';
        }

        $res .= '</div>';

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

    public function edit_product_desc($desc, $product_id) {
        try {
            $query = "UPDATE `product_item` SET `description` = :desc WHERE id = :id";

            $data = array(
                'desc'=>$desc,
                'id'=>$product_id
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);
            
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}