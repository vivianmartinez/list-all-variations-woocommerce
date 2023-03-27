<?php

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

// Se conecta con Woocommerce API
$woocommerce = new Client(
  'http://localhost/wp',
  'ck_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
  'cs_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
  [
    'version' => 'wc/v3',
    'timeout' => 400,
  ]
);

set_time_limit(0);

//Obtenemos la primera página de productos
$next_page = 1;
$products = $woocommerce->get('products',['page'=> $next_page, 'per_page' => 99]); // per_page - el valor por defecto es 10

//Recorremos cada página de productos
while(!empty($products)){	
	foreach($products as $product){
		$product_id = $product->id; // Devuelve el id del producto
		$next_variation_page = 1;
		//Obtenemos las variaciones de un producto por página
		do{
		    $variations_product = $woocommerce->get('products/'.$product_id.'/variations',['page'=> $next_variation_page,'per_page' => 99]);
		    if(!empty($variations_product)){
			foreach($variations_product as $variation){
			    print_r($variation);
			}
		    }
		    $next_variation_page++;
		}while(!empty($variations_product));
	}	
	$next_page++;
    	//Obtenemos la siguiente página de productos
	$products = $woocommerce->get('products',['page' => $next_page, 'per_page' => 99]);
}