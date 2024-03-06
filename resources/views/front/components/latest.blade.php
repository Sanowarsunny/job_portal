
    {{-- latest job --}}
    <section class="section-3 bg-2 py-5">
        <div class="container">
            <h2>Latest Jobs</h2>
            <div class="row pt-5">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                        <div class="row">

                            @if ($latestJob->isNotEmpty())

                                @foreach ( $latestJob as $item )
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
                            @endif
                                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>