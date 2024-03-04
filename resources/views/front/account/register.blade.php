@extends('front.layouts.app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Register</h1>
                        <form action="" method="post" name="registerForm" id="registerForm">
                            <div class="mb-3">
                                <label for="name" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                                <span class="invalid-feedback" role="alert" id="name-error"></span>
                            </div> 
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                                <span class="invalid-feedback" role="alert" id="email-error"></span>
                            </div> 
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                                <span class="invalid-feedback" role="alert" id="password-error"></span>
                            </div> 
                            <div class="mb-3">
                                <label for="cpassword" class="mb-2">Confirm Password*</label>
                                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Enter Confirm Password">
                                <span class="invalid-feedback" role="alert" id="cpassword-error"></span>
                            </div> 
                            <button type="submit" class="btn btn-primary mt-2">Register</button>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a href="{{ route('login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $("#registerForm").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: '{{ route("register") }}',
                type: 'post',
                data: $("#registerForm").serialize(),
                dataType: 'json',
                success: function(response){
                    if(response.status == false){
                        var errors = response.errors;

                        // Clear previous error messages
                        $('.invalid-feedback').text('');
                        $('.form-control').removeClass('is-invalid');

                        // Display errors below input fields
                        $.each(errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key + "-error").text(value);
                        });
                    } else {
                        window.location.href = '{{ route("login") }}';
                    }
                }
            });
        });
    </script>
@endsection
