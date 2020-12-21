<?php


class Cart
{
    private array $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    /*
     * Add Product $product into cart. If product already exists inside cart
     * it must update quantity.
     * This must create CartItem and return CartItem from method
     */
    public function addProduct(Product $product, int $quantity)
    {
        // find product in cart
        $cartItem = $this->findCartItem($product->getId());
        if ($cartItem === null){
            $cartItem = new CartItem($product, 0);
            $this->items[$product->getId()] = $cartItem;
        }
        $cartItem->increaseQuantity($quantity);
        return $cartItem;
    }

    private function findCartItem(int $productId)
    {
        return $this->items[$productId] ?? null;
    }

    /*
     * Remove product from cart
     */
    public function removeProduct(Product $product)
    {
        unset($this->items[$product->getId()]);
    }

    /*
     * This returns total number of products added in cart
     */
    public function getTotalQuantity()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getQuantity();
        }
        return $sum;
    }

    /*
     * This returns total price of products added in cart
     */
    public function getTotalSum()
    {
        $totalSum = 0;
        foreach ($this->items as $item) {
            $totalSum += $item->getQuantity() * $item->getProduct()->getPrice();
        }

        return $totalSum;
    }
}
