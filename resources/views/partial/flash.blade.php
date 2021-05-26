@if(session('message'))
    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert" id="alert-message">
        <strong>{{ session('message') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- from verify.blade.php--}}
@if (session('resent'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-message">
        <strong>{{ __('A fresh verification link has been sent to your email address.') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{--from email.blade.php (Reset Password Notification & Verify Email Address)--}}
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-message">
        <strong>{{ session('status') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
