@extends('layouts.homepage')
@section('content')
<style>
    .pop-out {
        /* width: 60px; */
        height: 40px;
        background-color: #4CAF50; Green background
        color: white; /* White text color */
        display: flex;
        justify-content: left;
        align-items: left;
        /* font-size: 24px; */
        border-radius: 5px;
        transition: transform 0.3s ease; /* Smooth transition */
        /* margin: 10px; */
    }

    .pop-out:hover {
        transform: scale(1.1); /* Scale up the element */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Add shadow for depth */
    }
</style>
  <section class="features">
        <div class="container">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow zoomIn">
                                <h2>AGENCY LISTING</h2>
                                <span></span>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">				
                        <div class="col-md-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                @foreach ($agencies as $ministry)
                                    <div class="panel panel-default">
                                    <div class="panel-heading pop-out" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="/login" aria-expanded="true" aria-controls="collapseOne">
                                                {{$ministry->code.' | '.$ministry->name}} 
                                            </a>
                                        </h4>
                                    </div>
                                   
                                </div>    
                                @endforeach
                            </div>
                            {{ $agencies->links('pagination::bootstrap-4') }}
                        </div><!--- END COL -->		
                    </div><!--- END ROW -->			
                </div>
            </div>
        </div>
    </section> 
@endsection
