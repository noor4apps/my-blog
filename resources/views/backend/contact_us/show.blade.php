@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Message ({{ $message->title }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.contact_us.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Contact us</span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>From</th>
                        <td>{{ $message->name }}</td>
                    </tr>
                    <tr>
                        <th>Titlt</th>
                        <td>{{ $message->title }}</td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <td>{{ $message->message }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

@endsection
