@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add New User</span>
                </a>
            </div>
        </div>
        @include('backend.users.filter.filter')
        <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name & U sername</th>
                        <th>Email & Mobile</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            @if($user->user_image != null)
                                <img src="{{ asset('assets/users/' . $user->user_image) }}" class="img-thumbnail" style="width: 50px">
                            @else
                                <img src="{{ asset('assets/users/default.png') }}" class="img-thumbnail" style="width: 50px">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a>
                            <p class="text-gray-400">{{ $user->username }}</p>
                        </td>
                        <td>
                            {{ $user->email }}
                            <p class="text-gray-400">{{ $user->mobile }}</p>
                        </td>
                        <td>{{ $user->status() }}</td>
                        <td>{{ $user->created_at->format('Y m d h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete this user?')) { document.getElementById('user-delete-{{ $user->id }}').submit(); } else { return false; }"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" id="user-delete-{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="6">
                            <div class="float-right">
                                {{ $users->appends(request()->input())->links() }}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
    </div>
@endsection
