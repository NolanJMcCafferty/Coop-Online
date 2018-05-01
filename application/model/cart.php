<?php
// Represents the shopping cart for a single session.

class ShoppingCart {
	

    // List of products that is used to generate the HTML menu.
    public static $foodTypes = Array("fountainburger" => "Fountain Burger",
                                       "burrito" => "Breakfast Burrito",
                                       "quesadilla" => "Quesadilla",
                                       "blt" => "BLT",
                                       "caesarsalad" => "Caesar Salad",
                                       "icecream" => "Ice Cream",
                                       "float" => "Float",
                                       "shake" => "Shake"
                                       );
	

    // list of prices for the food items
    public static $prices = Array("fountainburger" => 7,
                                       "burrito" => 6,
                                       "quesadilla" => 5,
                                       "blt" => 6,
                                       "caesarsalad" => 5,
                                       "icecream" => 3,
                                       "float" => 4,
                                       "shake" => 3
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
