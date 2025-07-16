@extends('guest.guestPage')
@section('body')
    <style>
        /* Dimmed and blurred background behind content */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('template/img/sample_bg2.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            filter: brightness(0.8) blur(3px);
            /* softer, less dark, with blur */
            z-index: -1;
        }

        /* Main content wrapper styling */
        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.4);
            /* light transparency */
            backdrop-filter: blur(3px);
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
            background-color: #1f5036;
            color: white;
            text-align: center;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
            font-size: 14px;
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
    </style>
    <div class="content pt-4">


        <div class="container-fluid">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2 class="highlighted-title">Welcome to CPSU - DARE</h2>
                <p class="lead text-white" style="font-style: italic;">“Dare to Search. Dare to Succeed”</p>
            </div>

            <!-- Search Box -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
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
                <div class="col-md-8">
                    <div class="card card-outline card-success shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-weight-bold text-success">Research Studies</h5>
                            @if (request('query'))
                                <span class="badge badge-light text-dark">
                                    Showing results for: <strong>{{ request('query') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2" class="table table-hover table-sm text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Research Title</th>
                                            <th>Researchers</th>
                                            <th>Category</th>
                                            <th>Date Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($searchResults as $result)
                                            <tr>
                                                <td>
                                                    <i class="fas fa-file-pdf text-danger mr-1"></i>
                                                    <a href="{{ route('viewPdfGuest', $result->id) }}" target="_blank">
                                                        {{ pathinfo($result->file_name, PATHINFO_FILENAME) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ optional($result->user)->fname ?? 'N/A' }}
                                                    {{ optional($result->user)->lname ?? '' }}
                                                </td>
                                                <td>{{ $result->file_category ?? 'Uncategorized' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($result->created_at)->format('F d, Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No research found.
                                                </td>
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
                <div class="col-md-8">
                    <div class="row align-items-stretch mt-2">
                        <!-- Card 1 -->
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-md text-center h-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <img src="{{ asset('img/research.png') }}" alt="Research Icon" width="50"
                                        class="mb-3 mx-auto">
                                    <h5 class="card-title font-weight-bold">Amplify Your Research</h5>
                                    <p class="card-text text-muted">Make your studies visible and impactful.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-md text-center h-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <img src="{{ asset('img/folder.png') }}" alt="Research Count" width="50"
                                        class="mb-3 mx-auto">
                                    <h5 class="card-title font-weight-bold">Number of Research</h5>
                                    <p class="card-text display-4">{{ $researchCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-md text-center h-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <img src="{{ asset('img/download.png') }}" alt="Download Icon" width="50"
                                        class="mb-3 mx-auto">
                                    <h5 class="card-title font-weight-bold">Number of Downloads</h5>
                                    <p class="card-text display-4">{{ $downloadCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-md text-center h-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <img src="{{ asset('img/faq.png') }}" alt="FAQ Icon" width="50"
                                        class="mb-3 mx-auto">
                                    <h5 class="card-title font-weight-bold">FAQs</h5>
                                    <p class="card-text text-muted">Need help? Find answers to common questions.</p>
                                    <a href="#" class="btn btn-sm btn-outline-success mt-auto">View FAQs</a>
                                </div>
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
