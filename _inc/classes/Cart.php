<?php

class Cart extends Database {
    private $db;
    private $user_id;

    public function __construct($user_id) {
        $this->db = $this->db_connection();
        $this->user_id = $user_id;
    }

    public function add_cart($product_id, $qty) {
        try {
            $query = "INSERT IGNORE INTO `cart`(user_id) VALUES(:user_id);
            INSERT INTO `cart_item`(cart_id, product_item_id, qty) VALUES((
                SELECT cart_id FROM `cart` WHERE user_id = :user_id
            ), :product_item_id, :qty)";

            $data = array(
                'user_id'=>$this->user_id,
                'product_item_id'=>$product_id,
                'qty'=>$qty,
            );

            $statement = $this->db->prepare($query);
            $statement->execute($data);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete_cart($cart_item) {
        try {
            $query = "DELETE FROM `cart_item` WHERE cart_item_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('id', $cart_item);
            $statement->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select() {
        try{
            $query = "SELECT c.*, ci.*, pi.image, pi.price, p.product_name FROM `cart` c
            JOIN `cart_item` ci ON(ci.cart_id = c.cart_id)
            JOIN `product_item` pi ON(pi.id = ci.product_item_id)
            JOIN `product` p ON(p.product_id = pi.product_id)
            WHERE c.user_id = :user_id";

            $statement = $this->db->prepare($query);
            $statement->bindParam('user_id', $this->user_id);
            $statement->execute();

            $res = $statement->fetchAll();
            return $res;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_cart() {
        $fetch = $this->select();
        $qty = 0;
        $price = 0;

        $res = '<div class="cart-list">';
        foreach ($fetch as $line) {
            $res .=  '<div class="product-widget">';
            $res .=  '<div class="product-img"><img src="' .$line->image.'" alt=""></div>';
            $res .=  '<div class="product-body">';
            $res .=  '<h3 class="product-name"><a href="product.php?id='. $line->product_item_id .'">'. $line->product_name .'</a></h3>';
            $res .=  '<h4 class="product-price"><span class="qty">'. $line->qty .'x</span>' .$line->qty * $line->price .'€</h4>';
            $res .=  '</div>';
            $res .=  '<form method="POST"><button class="delete" name="del_cart_item" value="'. $line->cart_item_id .'"><i class="fa fa-close"></i></button></form>';
            $res .=  '</div>';

            $qty += $line->qty;
            $price += $line->price * $line->qty;
        }
        $res .= '</div>
        <div class="cart-summary">
            <small>'. $qty .' Item(s) selected</small>
            <h5>SUBTOTAL: €'. $price .'</h5>
        </div>';
        return $res;
    }
}