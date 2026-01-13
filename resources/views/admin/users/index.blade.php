@extends('layouts.admin')

@section('title', 'Users — Admin')

@push('styles')
<style>
.users-table { width: 100%; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.users-table th, .users-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
.users-table th { background: #f9fafb; font-weight: 600; color: #666; }
.btn-delete { background: #fee2e2; color: #991b1b; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; }
.btn-delete:hover { background: #fecaca; }
</style>
@endpush

@section('content')
<h2 style="margin-bottom: 25px;">Users</h2>

<table class="users-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Registered</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile ?? '-' }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:30px; color:#888;">No users found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
