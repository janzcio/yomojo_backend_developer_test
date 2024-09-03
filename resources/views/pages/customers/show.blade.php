@extends('layouts.app')

@section('title', 'View Customer')

@section('content')
    <div class="container mt-5">
        <h1>View Customer</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Customer Details</h5>
                <div class="mb-3">
                    <label class="form-label"><strong>First Name</strong></label>
                    <p class="form-control-plaintext">{{ $customer->first_name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Last Name</strong></label>
                    <p class="form-control-plaintext">{{ $customer->last_name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Age</strong></label>
                    <p class="form-control-plaintext">{{ $customer->age }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Date of Birth</strong></label>
                    <p class="form-control-plaintext">{{ $customer->dob }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Email</strong></label>
                    <p class="form-control-plaintext">{{ $customer->email }}</p>
                </div>
                <a href="{{ url('customers') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
