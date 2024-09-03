@extends('layouts.app')

@section('title', 'Create Customer')
@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h1>Create New Customer</h1>
                <form id="create-customer-form">
                    <!-- Include CSRF token for security -->
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{ url('customers') }}" class="btn btn-secondary">Back to List</a>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.getElementById('create-customer-form').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this);
            const authToken = localStorage.getItem('authToken'); // Retrieve the auth token from local storage

            try {
                const response = await fetch('{{ url('api/customers') }}', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(formData).toString()
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                console.log(result, "result");
                if (result.status === 200) {
                    window.location.href = '{{ url('customers') }}'; // Redirect on success
                } else {
                    alert('Error: ' + result.message); // Handle errors
                }
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        });
    </script>
@endsection
