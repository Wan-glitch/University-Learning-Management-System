
@extends('layout.app')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">User Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 text-center">
                                <img src="{{ $user->profile_photo_url ?? 'default_profile_photo_url' }}" alt="user" class="rounded-circle" width="150" height="150">
                            </div>
                            <div class="col-md-8">
                                <h3>{{ $user->name }}</h3>
                                <p>Email: {{ $user->email }}</p>
                                <p>Phone Number: {{ $user->phone_no ?? 'No phone number' }}</p>
                                <p>Role: {{ Str::ucfirst($user->role ? $user->GotRole->name : 'No Role Assigned') }}</p>
                                <p>Faculty: {{ $user->faculty ? $user->HasFaculty->title : 'No Faculty Assigned' }}</p>
                                <p>Status: {{ $user->user_status == 1 ? 'Active' : 'Inactive' }}</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete User</button>
                            </form>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to User List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
