<?php

// Represents the shopping cart for a single session.

class ShoppingCart {
	
    // List of products that is used to generate the HTML menu.
    public static $foodTypes = Array("fountainburger" => "Fountain Burger",
                                       "burrito" => "Burrito",
                                       "quesadilla" => "Quesadilla",
                                       "blt" => "BLT",
                                       "caesarsalad" => "Caesar Salad",
                                       "icecream" => "Ice Cream",
                                       "float" => "Float",
                                       "shake" => "Shake"
                                       );
	
    // The array that contains the order
    private $order;
	
    // Initially, the cart is empty
    public function __construct() {
        $this->order = Array();
    }
	
    public function getOrder() {
        return $this->order;
    }
    // Adds an order to the shopping cart.  
    public function order($variety, $quantity) {
        $currentQuantity = $this->order[$variety];
        $currentQuantity += $quantity;
        $this->order[$variety] = $currentQuantity;
    }

    public function update($variety, $quantity) {
      $currentQuantity = $this->order[$variety];
      $currentQuantity = $quantity;
      $this->order[$variety] = $currentQuantity;
      
    }
	

}

?>
