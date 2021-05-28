@if(session('message'))
    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert" id="alert-message">
        <strong>{{ session('message') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- from verify.blade.php, (Verify Email Address)--}}
@if (session('resent'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-message">
        <strong>{{ __('A fresh verification link has been sent to your email address.') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{--
    from email.blade.php, (Reset Password Notification)
    https://my-blog.test/password/reset show Message
    :We have emailed your password reset link!

    https://my-blog.test/password/reset/279d4e02b230a79be14244e4b78af2ecfc9e0e9daf969b8cee9d09a55add8db6?email=ali%40my-blog.com
    after redirect to https://my-blog.test/dashboard show Message
    :Your password has been reset!
--}}
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-message">
        <strong>:{{ session('status') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
