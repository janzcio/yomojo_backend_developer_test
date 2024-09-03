<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Models\Customer;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers()
    {
        return $this->customerRepository->getAll();
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->findById($id);
    }

    public function createCustomer(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function updateCustomer($id, array $data)
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            return null;
        }

        $this->customerRepository->update($customer, $data);

        return $customer;
    }

    public function deleteCustomer($id)
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            return null;
        }

        $this->customerRepository->delete($customer);

        return true;
    }
}
