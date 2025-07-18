@extends('guest.guestPage')
@section('body')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        h1 span {
            font-family: 'Montserrat', Tahoma, Geneva, Verdana, sans-serif;
            letter-spacing: 1px;
        }

        /* Dimmed and blurred background behind content */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('template/img/kalaw1.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;

            /* softer, less dark, with blur */
            z-index: -1;
        }

        /* Main content wrapper styling */
        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.2);
            /* light transparency */

            /* adds modern glass effect */
            -webkit-backdrop-filter: blur(3px);
            /* Safari support */
            padding: 30px;

            transition: background-color 0.3s ease;
        }


        .search-bar {
            background: #fff;
            border-radius: 40px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .search-bar input {
            border: none;
            border-radius: 0;
            height: 50px;
            box-shadow: none !important;
        }

        .search-bar button {
            border: none;
            background: #1f5036;
            color: white;
            padding: 0 30px;
            border-top-right-radius: 40px;
            border-bottom-right-radius: 40px;
        }

        .table thead th {
            /* background-color: #1f5036; */

            text-align: center;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
            font-size: 12px;
        }

        .table a {
            color: #007bff;
            text-decoration: none;
        }

        .table a:hover {
            text-decoration: underline;
        }

        .highlighted-title {
            color: #1f5036;
            font-weight: bold;
        }

        .no-results {
            padding: 20px;
            text-align: center;
            color: #999;
            font-style: italic;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .card-hover img {
            transition: transform 0.3s ease;
        }

        .card-hover:hover img {
            transform: scale(1.05);
        }
    </style>
    <div class="content">


        <div class="container-fluid">
            <!-- Header -->
            <div class="text-center mb-4">

                <!-- Title with animation -->
                <h1 class="animate__animated animate__fadeInDown"
                    style="font-size: 3rem; font-weight: 700; color: #ffffff; text-shadow: 2px 2px 4px rgba(0,0,0,0.4);">
                    Welcome to <span class="text-warning" style="text-shadow: 2px 1px 1px black;">CPSU – DARE</span>
                </h1>

                <!-- Subtitle with animation -->
                <p class="lead text-white mt-2 animate__animated animate__fadeInUp"
                    style="font-size: 1rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                    “Dare to Search. Dare to Succeed”
                </p>

                <!-- Accent line (no animation) -->
                <div class="bg-warning" style="width: 80px; height: 4px; margin: 20px auto 0; border-radius: 10px;">
                </div>
            </div>


            <!-- Search Box -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <form action="{{ route('indexGuest') }}" method="GET">
                        <div class="input-group search-bar">
                            <input type="text" name="query" class="form-control"
                                placeholder="Search by title, researcher, or category..." value="{{ request('query') }}">
                            <div class="input-group-append">
                                <button type="submit">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Table -->
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-outline card-success shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">

                            @if (request('query'))
                                <span class="badge badge-light text-dark">
                                    Showing results for: <strong>{{ request('query') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Authors</th>
                                            <th>Date</th>
                                            <th>Action</th> {{-- This is your new column --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($searchResults as $result)
                                            <tr>
                                                <td>
                                                    <i class="fas fa-file-pdf text-danger mr-1"></i>
                                                    <a href="{{ route('viewPdfGuest', ['file_name' => urlencode($result->file_name)]) }}"
                                                        target="_blank">
                                                        {{ pathinfo($result->file_name, PATHINFO_FILENAME) }}
                                                    </a>
                                                </td>
                                                <td>{{ $result->description ?? 'Uncategorized' }}</td>
                                                <td>
                                                    {{ $result->researcher }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($result->created_at)->format('F d, Y') }}</td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle"
                                                            type="button" id="actionDropdown{{ $result->id }}"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                            aria-labelledby="actionDropdown{{ $result->id }}">

                                                            <a class="dropdown-item"
                                                                href="{{ route('viewPdfGuest', ['file_name' => urlencode($result->file_name)]) }}"
                                                                target="_blank" style="text-decoration: none;">
                                                                <i class="fas fa-eye text-info mr-2"></i> View
                                                            </a>

                                                            <a class="dropdown-item" href="{{ route('downloadPdfGuest', ['file_name' => urlencode($result->file_name)]) }}" style="text-decoration: none;">
                                                                <i class="fas fa-download text-success mr-2"></i> Download
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>



                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">No results found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row align-items-stretch mt-2 g-3">
                        @php $cardImage = asset('template/img/sample_bg.jpg'); @endphp

                        <!-- Card 1 - Background Image Overlay -->
                        <div class="col-md-3">
                            <div class="card card-hover h-100 text-white position-relative overflow-hidden"
                                style="min-height: 320px;">
                                <img src="{{ $cardImage }}" class="card-img h-100"
                                    style="object-fit: cover; filter: brightness(0.7);" alt="Card image">
                                <a href="#" target="_blank">
                                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                                        <h5 class="card-title text-warning">Featured Research</h5>
                                        <p class="card-text text-white pb-2 pt-1">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmod tempor.
                                        </p>
                                        <a href="#" class="text-white">Last update 2 mins ago</a>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-md-3">
                            <div class="card card-hover h-100 text-white position-relative overflow-hidden"
                                style="min-height: 320px;">
                                <img src="{{ asset('template/img/digital_book2.jpg') }}" class="card-img h-100"
                                    style="object-fit: cover; filter: brightness(0.7);" alt="Research Count">
                                <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                                    <h5 class="fw-bold text-warning">Total Number of Research</h5>
                                    <p class="display-4 mb-0">{{ $docCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-md-3">
                            <div class="card card-hover h-100 text-white position-relative overflow-hidden"
                                style="min-height: 320px;">
                                <img src="{{ asset('template/img/download_number.jpg') }}" class="card-img h-100"
                                    style="object-fit: cover; filter: brightness(0.7);" alt="Download Icon">
                                <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                                    <h5 class="fw-bold text-warning">Total Number of Downloads</h5>
                                   <p class="display-4 mb-0">{{ $totalDownloads }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="col-md-3">
                            <div class="card card-hover h-100 text-white position-relative overflow-hidden"
                                style="min-height: 320px;">
                                <img src="{{ asset('template/img/faqs.jpg') }}" class="card-img h-100"
                                    style="object-fit: cover; filter: brightness(0.9);" alt="FAQ Icon">
                                <a href="#" target="_blank">
                                    <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                                        {{-- <h5 class="fw-bold"></h5>
                                    <p class="small mb-3"></p>
                                    <a href="#" class="btn btn-sm btn-outline-light">View FAQs</a> --}}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>





        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "search": "Filter results:",
                    "emptyTable": "No research found."
                }
            });
        });
    </script>
@endsection
