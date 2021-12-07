<?php
/*
 * This file is part of JusWishlist module for OC3.x
 * (c) 2021 jigius@gmail.com
 */
class FakeLoggedCustomer {
    public function __construct()
    {
    }

    public function login($email, $password, $override = false) {
        throw new LogicException();
    }

    public function logout() {
        throw new LogicException();
    }

    public function isLogged() {
        return true;
    }

    public function getId() {
        return -1;
    }

    public function getFirstName() {
        return "";
    }

    public function getLastName() {
        return "";
    }

    public function getGroupId() {
        throw new LogicException();
    }

    public function getEmail() {
        return "";
    }

    public function getTelephone() {
        throw new LogicException();
    }

    public function getNewsletter() {
        throw new LogicException();
    }

    public function getAddressId() {
        throw new LogicException();
    }

    public function getBalance() {
        return 0;
    }

    public function getRewardPoints() {
        throw new LogicException();
    }
}
