@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Contact us</h6>
        </div>
        @include('backend.contact_us.filter.filter')
        <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($message as $mes)
                    <tr>
                        <td>{{ $mes->name }}</td>
                        <td>{{ $mes->email }}</td>
                        <td>{{ $mes->mobile }}</td>
                        <td><a href="{{ route('admin.contact_us.show', $mes->id) }}">{{ $mes->title }}</a></td>
                        <td>{{ Str::limit($mes->message, 20, '...') }}</td>
                        <td>{{ $mes->status() }}</td>
                        <td>{{ $mes->created_at->format('Y m d h:i a') }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete this Message?')) { document.getElementById('contact-us-delete-{{ $mes->id }}').submit(); } else { return false; }"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.contact_us.destroy', $mes->id) }}" method="post" id="contact-us-delete-{{ $mes->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Messages found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="8">
                            <div class="float-right">
                                {{ $message->appends(request()->input())->links() }}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
    </div>
@endsection
