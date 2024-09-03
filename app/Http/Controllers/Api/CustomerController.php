<?php

namespace App\Http\Controllers\Api;

use App\Services\CustomerService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @api {get} /api/customers Get all customers
     * @apiName GetCustomers
     * @apiGroup Customer
     *
     * @apiSuccess {Object[]} data List of customers.
     * @apiSuccess {Number} data.id Customer's unique ID.
     * @apiSuccess {String} data.first_name Customer's first name.
     * @apiSuccess {String} data.last_name Customer's last name.
     * @apiSuccess {Number} data.age Customer's age.
     * @apiSuccess {String} data.dob Customer's date of birth.
     * @apiSuccess {String} data.email Customer's email.
     *
     * @apiError (Error 500) InternalServerError Internal server error.
     */

    public function index()
    {
        $customers = $this->customerService->getAllCustomers();
        return success('Customers retrieved successfully', $customers);
    }

    public function store(StoreCustomerRequest $request)
    {
        $validatedData = $request->validated();
        $this->customerService->createCustomer($validatedData);

        return success('Customer created successfully');
    }

    /**
     * @api {get} /api/customers/:id Get customer by ID
     * @apiName GetCustomerById
     * @apiGroup Customer
     *
     * @apiParam {Number} id Customer's unique ID.
     *
     * @apiSuccess {Object} data Customer details.
     * @apiSuccess {Number} data.id Customer's unique ID.
     * @apiSuccess {String} data.first_name Customer's first name.
     * @apiSuccess {String} data.last_name Customer's last name.
     * @apiSuccess {Number} data.age Customer's age.
     * @apiSuccess {String} data.dob Customer's date of birth.
     * @apiSuccess {String} data.email Customer's email.
     *
     * @apiError (Error 404) NotFound Customer not found.
     */
    public function show($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            return notFound('Customer not found');
        }

        return success('Customer retrieved successfully', $customer->toArray());
    }

    /**
     * @api {put} /api/customers/:id Update customer details
     * @apiName UpdateCustomer
     * @apiGroup Customer
     *
     * @apiParam {Number} id Customer's unique ID.
     *
     * @apiSuccess {String} message Success message.
     *
     * @apiError (Error 404) NotFound Customer not found.
     * @apiError (Error 400) BadRequest Validation error.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $validatedData = $request->validated();
        $customer = $this->customerService->updateCustomer($id, $validatedData);

        if (!$customer) {
            return notFound('Customer not found');
        }

        return success('Customer updated successfully');
    }

    /**
     * @api {delete} /api/customers/:id Delete a customer
     * @apiName DeleteCustomer
     * @apiGroup Customer
     *
     * @apiParam {Number} id Customer's unique ID.
     *
     * @apiSuccess {String} message Success message.
     *
     * @apiError (Error 404) NotFound Customer not found.
     */
    public function destroy($id)
    {
        $customerDeleted = $this->customerService->deleteCustomer($id);

        if (!$customerDeleted) {
            return notFound('Customer not found');
        }

        return success('Customer deleted successfully', null, 204);
    }
}
