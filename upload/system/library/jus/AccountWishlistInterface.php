<?php
/*
 * This file is part of JusWishlist module for OC3.x
 * (c) 2021 jigius@gmail.com
 */
interface AccountWishlistInterface
{
    /**
     * Adds a product into Wish list
     * @param int $product_id
     * @return void
     */
    public function addWishlist($product_id);

    /**
     * Deletes a product from Wish List
     * @param int $product_id
     * @return void
     */
    public function deleteWishlist($product_id);

    /**
     * Retrieves products have added into Wish List
     * @return array
     */
    public function getWishlist();

    /**
     * Returns a quantity of products have been added into Wish List
     * @return int
     */
    public function getTotalWishlist();
}
