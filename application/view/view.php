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
          $shoppingCart = $this->model->getCart();

    header('Location: /Coop-Online/application/view/checkout.php');
  }
}

?>
