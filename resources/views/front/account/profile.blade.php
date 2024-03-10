@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                @include('front.components.profile_sidenav')

                <div class="col-lg-9">
                    
                    @include("front.components.message")
                    
                    <div class="card border-0 shadow mb-4">
                            
                        <form action="{{ route('updateProfile') }}" method="post" name="userForm" id="userForm" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Name*</label>
                                    <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                                    @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" name="email" id="email" placeholder="Enter Email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation</label>
                                    <input type="text" name="designation" id="designation" placeholder="Designation" class="form-control" value="{{ $user->designation }}">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile</label>
                                    <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" value="{{ $user->mobile }}">
                                </div> 

                                @if(Auth::check() && Auth::user()->role == 'user')
                                <div class="mb-4">
                                    <label for="cv" class="mb-2">Upload CV</label><br>
                                    <input type="file" name="cv" id="cv" class="form-control-file @error('cv') is-invalid @enderror">
                                        @if ($user->cv)
                                        @php
                                        $filename = basename($user->cv);
                                        $displayFilename = preg_replace('/^\d+/', '', $filename); // Remove leading numeric digits
                                        @endphp
                                    <small>Current CV: {{ $displayFilename }}</small>
                                        @endif
                                        @error('cv')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif        
                                </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                        
                    {{-- update page  --}}

                    @include("front.components.updatePasswordPage")

                </div>
            </div>
        </div>
    </section>
@endsection


@section('customJs')
<script type="text/javascript">
   

    $("#changePasswordForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: '{{ route("updatePassword") }}',
            type: 'post',
            dataType: 'json',
            data: $("#changePasswordForm").serializeArray(),
            success: function(response) {

                if(response.status == true) {

                    $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')

                    $("#email").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')

                    window.location.href="{{ route('profilePage') }}";

                } else {
                    var errors = response.errors;

                    if (errors.old_password) {
                        $("#old_password").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.old_password)
                    } else {
                        $("#old_password").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if (errors.new_password) {
                        $("#new_password").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.new_password)
                    } else {
                        $("#new_password").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }

                    if (errors.confirm_password) {
                        $("#confirm_password").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.confirm_password)
                    } else {
                        $("#confirm_password").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')
                    }
                }

            }
        });
    });
</script>
@endsection