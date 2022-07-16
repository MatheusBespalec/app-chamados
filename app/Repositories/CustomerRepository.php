<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function create(string $name): Customer
    {
        return Customer::create(compact('name'));
    }
}
