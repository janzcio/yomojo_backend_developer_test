<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAllCustomers();

        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {

        return view('pages.customers.create');
    }

    public function show($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            return redirect()->route('web.customers.index')->with('error', 'Customer not found.');
        }

        return view('pages.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            return redirect()->route('web.customers.index')->with('error', 'Customer not found.');
        }

        return view('pages.customers.edit', compact('customer'));
    }
}
