@extends('layouts.app')

@section('title', 'Customer List')

@section('content')
    <div class="container mt-5">
        <h1>Customer List</h1>
        <a href="{{ route('web.customers.create') }}" class="btn btn-primary mb-3">Add New Customer</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Dob</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $customer->first_name }}</td>
                        <td>{{ $customer->last_name }}</td>
                        <td>{{ $customer->age }}</td>
                        <td>{{ $customer->dob }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <a href="{{ route('web.customers.show', $customer->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('web.customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="deleteCustomer({{ $customer->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


@section('scripts')
<script>
    function deleteCustomer(customerId) {
        if (confirm('Are you sure you want to delete this customer?')) {
            const authToken = localStorage.getItem('authToken'); // Retrieve the auth token from local storage

            fetch(`{{ url('api/customers') }}/${customerId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ _method: 'DELETE' }) // Simulate DELETE request
            })
            .then(result => {
                if (result.status === 204) {
                    location.reload(); // Refresh the page on success
                } else {
                    alert('Error: ' + result.message); // Handle errors
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        }
    }
</script>
@endsection
