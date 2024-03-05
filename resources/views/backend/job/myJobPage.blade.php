@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                @include('front.components.profile_sidenav')

                <div class="col-lg-9">

                    @include("front.components.message")
                    
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">My Jobs</h3>
                                </div>
                                <div style="margin-top: -10px;">
                                    <a href="{{ route('createJobPage') }}" class="btn btn-primary">Post a Job</a>
                                </div>
                                
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Job Created</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($jobs->isNotEmpty())
                                            @foreach ($jobs as $item )
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{ $item->title }}</div>
                                                    <div class="info1">{{ $item->jobType->name }}.{{ $item->location }}</div>
                                                </td>
                                                <td> {{ $item->created_at }}</td>
                                                <td>0 Applications</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <div class="job-status text-capitalize">Active</div>
                                                        
                                                    @else
                                                        <div class="job-status text-capitalize">Block</div>
                                                        
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-dots float-end">
                                                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('editJobPage',$item->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('deleteJob',$item->id) }}"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        
                                    </tbody>
                                    
                                </table>
                            </div>

                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section>
@endsection
