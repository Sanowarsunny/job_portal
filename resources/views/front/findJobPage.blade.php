@extends('front.layouts.app')

@section('main')

<section class="section-3 py-5 bg-2 ">
    <div class="container">     
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>  
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="1" {{ (Request::get('sort') == '1') ? 'selected' : '' }}>Latest</option>
                        <option value="0" {{ (Request::get('sort') == '0') ? 'selected' : '' }}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input type="text" value="{{ Request::get('keyword') }}" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input value="{{ Request::get('location') }}" type="text" name="location" id="location" placeholder="Location" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if ($categories->isNotEmpty())
                                @foreach ($categories->unique('name') as $item )
                                 <option {{ (Request::get('category') == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>                   

                    <div class="mb-4">
                        <h2>Job Type</h2>
                        @if ($jobType->isNotEmpty())
                            @foreach ($jobType->unique('name') as $item)
                                <div class="form-check mb-2"> 
                                    <input class="form-check-input" name="job_type" type="checkbox" {{ (in_array($item->id,$jobTypeArray)) ? 'checked' : ''}} value="{{ $item->id }}" id="job_type-{{ $item->id }}">    
                                    <label class="form-check-label" for="job_type-{{ $item->id }}">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <label for="experience" class="mb-2">Experience</label>
                        <select class="form-select" name="experience" id="experience">
                            <option value="">Select Experience</option>
                            @php
                                $experiences = collect(range(0, 10))->concat(['10+'])->unique();
                            @endphp
                            @foreach ($experiences as $experience)
                                <option value="{{ $experience }}">{{ $experience === '10+' ? '10+ years' : $experience . ' years' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route("findJobPage") }}" class="btn btn-secondary mt-3">Reset</a>
                </div>
            </form>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                        <div class="row">

                            @if ($jobs->isNotEmpty())

                                @foreach ( $jobs as $item )
                                    <div class="col-md-4">
                                        <div class="card border-0 p-3 shadow mb-4">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ ucwords($item->title) }}</h3>
                                                <p>{{ Str::words($item->description, 5) }}</p>
                                                <div class="bg-light p-3 border">
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{ ucwords($item->location) }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">{{ $item->jobType->name }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">Category: {{ $item->category->name }}</span>
                                                    </p><p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">Experience: {{ $item->experience }}</span>
                                                    </p><p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">Keyword:{{ $item->keywords }}</span>
                                                    </p>
                                                    @if (!$item->salary == 0)
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                            <span class="ps-1">{{ $item->salary }}</span>
                                                        </p>
                                                    @endif
                                                    
                                                </div>
            
                                                <div class="d-grid mt-3">
                                                    <a href="{{ route('detailJobPage',$item->id) }}" class="btn btn-primary btn-lg">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @else
                                    <div class="col-md-12">Jobs Not Found</div>
                            @endif
                                       
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
  
@endsection


@section('customJs')
<script>
    $("#searchForm").submit(function(e){
        e.preventDefault();

        var url = '{{ route("findJobPage") }}?';

        var keyword = $("#keyword").val();
        var location = $("#location").val();
        var category = $("#category").val();
        var experience = $("#experience").val();
        var sort = $("#sort").val();

        var checkedJobTypes = $("input:checkbox[name='job_type']:checked").map(function(){
            return $(this).val();
        }).get();

        // If keyword has a value
        if (keyword != "") {
            url += '&keyword='+keyword;
        }

        // If location has a value
        if (location != "") {
            url += '&location='+location;
        }

        // If category has a value
        if (category != "") {
            url += '&category='+category;
        }

        // If experience has a value
        if (experience != "") {
            url += '&experience='+experience;
        }

        // If user has checked job types
        if (checkedJobTypes.length > 0) {
            url += '&jobType='+checkedJobTypes;
        }

        url += '&sort='+sort;

        window.location.href=url;
        
    });

    $("#sort").change(function(){
        $("#searchForm").submit();
    });

</script>
@endsection