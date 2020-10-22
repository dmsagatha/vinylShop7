<?php

namespace App\Helpers;

class Cart
{
  private $cart = [
    'records'    => [],
    'totalQty'   => 0,
    'totalPrice' => 0
  ];

  // Cart constructor
  public function __construct()
  {
    if (session()->get('cart')){
      $this->cart = session()->get('cart');
    }
  }

  // Add a record to the cart
  public function add($item)
  {
    // Extraer el id y el precio
    $id = $item->id;
    $singlePrice = $item->price;

    // Verificar si hay un elemento con la clave $id dentro 
    // del arreglo records
    /* Si NO hay un elemento con esa clave:
      Agregar un nuevo elemento con clave $ida la records matriz
      Se extrae la id, title, artist, cover(que puede ser null en el momento) y pricede la colección
      Establecer la cantidad qty en 1
    */
    if (!array_key_exists($id, $this->cart['records'])) {
        $this->cart['records'][$id] = [
            'id' => $item->id,
            'title' => $item->title,
            'artist' => $item->artist,
            'cover' => $item->cover,
            'qty' => 1,
            'price' => $item->price
        ];
    }
    /* De lo contrario, si el elemento ya existe
      Incrementar la cantidad en 1
      Calcular el precio multiplicando la nueva cantidad por el precio de un solo artículo $singlePrice
    */
      else {
        $this->cart['records'][$id]['qty']++;
        $this->cart['records'][$id]['price'] = $singlePrice * $this->cart['records'][$id]['qty'];
    }
    
    session()->put('cart', $this->cart);  // save the session
  }

  // Delete a record from the cart
  public function delete($item)
  {
    $id = $item->id;
    $singlePrice = $item->price;

    if (array_key_exists($id, $this->cart['records'])) {
        $this->cart['records'][$id]['qty']--;
        if ($this->cart['records'][$id]['qty'] != 0) {
            $this->cart['records'][$id]['price'] = $singlePrice * $this->cart['records'][$id]['qty'];
        } else {
            unset($this->cart['records'][$id]);
        }
        $this->updateTotal();
    }
    
    session()->put('cart', $this->cart);  // save the session
  }

  // Empty the cart 
  public function empty()
  {
    session()->forget('cart');
  }

  // Get the complete cart
  public function getCart()
  {
    return $this->cart;
  }

  // Get all the records from the cart
  public function getRecords()
  {
    return $this->cart['records'];
  }

  // Get one record from the cart
  public function getOneRecord($key)
  {
    if (array_key_exists($key, $this->cart['records'])) {
      return $this->cart['records'][$key];
    }
  }

  // Get all the record keys
  public function getKeys()
  {
    return array_keys($this->cart['records']);
  }
  
  // Get the number of items 
  public function getTotalQty()
  {
    return $this->cart['totalQty'];
  }

  // Get the total price
  public function getTotalPrice()
  {
    return $this->cart['totalPrice'];
  }

  // Calculate the number of items and total price
  private function updateTotal()
  {
    // Recorrer cada registro dentro del carrito y actualizar $totalQtyy$totalPrice
    $totalQty   = 0;
    $totalPrice = 0;
    
    foreach ($this->cart['records'] as $record) {
        $totalQty += $record['qty'];
        $totalPrice += $record['price'];
    }

    // Actualiza el carrito con los nuevos valores
    $this->cart['totalQty'] = $totalQty;
    $this->cart['totalPrice'] = round($totalPrice, 2);
  }
}