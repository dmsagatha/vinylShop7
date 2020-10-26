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

  // Adicionar un registro al carro de compras
  public function add($item)
  {
    $id = $item->id;
    $singlePrice = $item->price;

    if (!array_key_exists($id, $this->cart['records'])) {
        $this->cart['records'][$id] = [
            'id' => $item->id,
            'title' => $item->title,
            'artist' => $item->artist,
            'cover' => $item->cover,
            'qty' => 1,
            'price' => $item->price
        ];
    } else {
        $this->cart['records'][$id]['qty']++;
        $this->cart['records'][$id]['price'] = $singlePrice * $this->cart['records'][$id]['qty'];
    }

    $this->updateTotal();   // Actualizar totalQty y totalPrice

    session()->put('cart', $this->cart);  // Guardar la sesión
  }

  // Eliminar un registro del carro de compras
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

  // Vaciar el carro de compras 
  public function empty()
  {
    session()->forget('cart');
  }

  // Obtener el carro de compras completo
  public function getCart()
  {
    return $this->cart;
  }

  // Obtener todos los regiostros del carro de compras
  public function getRecords()
  {
    return $this->cart['records'];
  }

  // Obtener un registro del carro de compras
  public function getOneRecord($key)
  {
    if (array_key_exists($key, $this->cart['records'])) {
      return $this->cart['records'][$key];
    }
  }

  // Obtener todas las claves de registro
  public function getKeys()
  {
    return array_keys($this->cart['records']);
  }
  
  // Obtener el número de ítems 
  public function getTotalQty()
  {
    return $this->cart['totalQty'];
  }

  // Obtener el precio total
  public function getTotalPrice()
  {
    return $this->cart['totalPrice'];
  }

  // Calcular el número de ítems y el precio total
  private function updateTotal()
  {
    $totalQty = 0;
    $totalPrice = 0;

    foreach ($this->cart['records'] as $record) {
        $totalQty += $record['qty'];
        $totalPrice += $record['price'];
    }

    $this->cart['totalQty'] = $totalQty;
    $this->cart['totalPrice'] = round($totalPrice, 2);
  }
}