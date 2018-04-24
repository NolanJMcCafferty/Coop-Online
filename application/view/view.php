<?php

class View {

	public function __construct($model)  {  
      $this->model = $model;
  } 

	public function renderCart()
 	{
 		  $shoppingCart = $this->model->getCart();
      
      include_once("viewcart.php");
 	}

  public function renderOrderForm()
  {
      include_once("orderForm.php");
  }

  public function checkout() {
    header('Location: Coop-Online-masterv7/application/view/checkout.php');
  }
}

?>
