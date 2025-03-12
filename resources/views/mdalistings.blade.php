@extends('layouts.homepage')
@section('content')
    <style>
        .pagination {
            justify-content: center;
        }

        /* Custom Styles */
        .pop-out {
            height: auto;
            background-color: #0C4F24;
            /* Green background */
            color: white;
            /* White text color */
            display: flex;
            justify-content: left;
            align-items: center;
            border-radius: 5px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 5px 0;
            padding: 10px 15px;
        }

        .pop-out:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .ministry-listing {
            margin-top: 20px;
        }

        .ministry-listing .panel-title a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
        }

        .ministry-listing .panel-title a:hover {
            text-decoration: underline;
        }

        .section-title {
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 3rem;
        }
        .section-title span {
            display: block;
            width: 50px;
            height: 3px;
            background-color: #007bff;
            margin: 0.5rem auto;
        }

        .panel-group {
            margin-bottom: 20px;
        }

        .panel {
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            margin-bottom: 5px;
        }

        .panel-heading {
            padding: 0;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        .panel-title {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 16px;
        }

        .panel-title>a {
            color: inherit;
            text-decoration: none;
        }
    </style>
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow zoomIn">
                                <h2>MINISTRY LISTING</h2>
                                <span></span>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ministry-listing">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                @foreach ($ministries as $ministry)
                                    <div class="panel panel-default">
                                        <div class="panel-heading pop-out" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-parent="#accordion" href="{{ route('login') }}">
                                                    {{ $ministry->code . ' | ' . $ministry->name }}
                                                </a>
                                            </h4>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!--- END COL -->
                        {{-- <nav>
                        <ul class="pagination">

                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&laquo; Previous</span>
                            </li>


                            <li class="page-item">
                                <a class="page-link" href="http://dms.test/ministries?page=2" rel="next">Next
                                    &raquo;</a>
                            </li>
                        </ul>
                    </nav> --}}
                        <div class="pt-3">
                            {{ $ministries->links('pagination::simple-bootstrap-4') }}
                        </div>

                    </div>
                    <!--- END ROW -->
                </div>
            </div>
        </div>
    </section>
@endsection
