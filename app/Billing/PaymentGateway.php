<?php
/**
 * Created by PhpStorm.
 * User: dimak
 * Date: 23.03.17
 * Time: 10:36
 */

namespace App\Billing;


interface PaymentGateway
{
    public function charge($amount, $token);
}