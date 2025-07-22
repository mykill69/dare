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






        .chatbot-container {
            position: relative;
            display: inline-block;
        }

        .thought-cloud {
            position: absolute;
            top: -45px;
            right: 0;
            background: white;
            color: #333;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transform: scale(0.8);
            animation: bubbleFade 4s infinite;
            white-space: nowrap;
        }

        .thought-cloud::before,
        .thought-cloud::after {
            content: '';
            position: absolute;
            background: white;
            border-radius: 50%;
        }

        .thought-cloud::before {
            width: 10px;
            height: 10px;
            bottom: -10px;
            right: 12px;
        }

        .thought-cloud::after {
            width: 6px;
            height: 6px;
            bottom: -16px;
            right: 16px;
        }

        @keyframes bubbleFade {

            0%,
            100% {
                opacity: 0;
                transform: scale(0.8);
            }

            10% {
                opacity: 1;
                transform: scale(1);
            }

            30% {
                opacity: 1;
            }

            40% {
                opacity: 0;
                transform: scale(0.8);
            }
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
                                            {{-- <th>Views</th> --}}
                                            <th>Action</th> {{-- This is your new column --}}

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($searchResults as $result)
                                            <tr>
                                                @php
                                                    $avgRating = round($result->ratings->avg('rating'), 1);
                                                @endphp

                                                <td style="text-align: justify;">
                                                    <a href="{{ route('viewPdfGuest', ['file_name' => urlencode($result->file_name)]) }}"
                                                        target="_blank">
                                                        {{ pathinfo($result->file_name, PATHINFO_FILENAME) }}
                                                    </a>

                                                    {{-- Star Display --}}
                                                    <div class="rating" data-doc-id="{{ $result->id }}">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fa-star {{ $i <= $avgRating ? 'fas' : 'far' }} fa-lg text-warning"
                                                                data-index="{{ $i }}"
                                                                style="cursor:pointer;"></i>
                                                        @endfor
                                                        <small
                                                            class="text-muted ms-1">({{ number_format($avgRating, 1) }}/5)</small>
                                                    </div>

                                                    {{-- Hidden Rating Form --}}
                                                    <form id="rating-form-{{ $result->id }}"
                                                        action="{{ route('rateDocument') }}" method="POST"
                                                        style="display:none;">
                                                        @csrf
                                                        <input type="hidden" name="document_id"
                                                            value="{{ $result->id }}">
                                                        <input type="hidden" name="rating" class="rating-value">
                                                    </form>
                                                </td>
                                                <td>{{ $result->description ?? 'Uncategorized' }}</td>
                                                <td class="text-center">
                                                    {{ $result->researcher }}
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($result->created_at)->format('F d, Y') }}
                                                </td>
                                                {{-- <td>{{ $result->view_count }}</td> --}}
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-warning dropdown-toggle"
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

                                                            <a class="dropdown-item"
                                                                href="{{ route('downloadPdfGuest', ['file_name' => urlencode($result->file_name)]) }}"
                                                                style="text-decoration: none;">
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
                <div class="col-md-10 p-3">
                    <div class="row justify-content-center rounded shadow-sm"
                        style="background-color: rgba(14, 60, 17, 0.7);">

                        <!-- Total Research -->
                        <div class="col-md-3 col-sm-6 text-center">
                            <h1 class="display-3 text-white font-weight-bold mb-1">
                                <small>+</small>{{ $docCount }}
                            </h1>
                            <p class="text-warning font-weight-bold">Number of Research</p>
                        </div>

                        <!-- Total Views -->
                        <div class="col-md-3 col-sm-6 text-center">
                            <h1 class="display-3 text-white font-weight-bold mb-1">
                                <small>+</small>{{ $totalViews }}
                            </h1>
                            <p class="text-warning font-weight-bold">Number of Views</p>
                        </div>

                        <!-- Total Downloads -->
                        <div class="col-md-3 col-sm-6 text-center">
                            <h1 class="display-3 text-white font-weight-bold mb-1">
                                <small>+</small>{{ $totalDownloads }}
                            </h1>
                            <p class="text-warning font-weight-bold">Number of Downloads</p>
                        </div>
                        <!-- Average Rating -->
                        <div class="col-md-3 col-sm-6 text-center">
                            <h1 class="display-3 text-white font-weight-bold mb-1">
                                {{ number_format($averageRating, 1) }}
                            </h1>

                            <div class="rating d-flex justify-content-center align-items-center mt-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($averageRating >= $i)
                                        <i class="fas fa-star fa-1x text-warning" style="cursor: default;"></i>
                                    @elseif($averageRating >= $i - 0.5)
                                        <i class="fas fa-star-half-alt fa-1x text-warning" style="cursor: default;"></i>
                                    @else
                                        <i class="far fa-star fa-1x text-warning" style="cursor: default;"></i>
                                    @endif
                                @endfor
                                <small class="text-light ms-2">&nbsp; (average rating)</small>
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
                        @if ($featuredResearch)
                            <div class="col-md-3">
                                <div class="card card-hover h-100 text-white position-relative overflow-hidden"
                                    style="min-height: 320px;">
                                    <img src="{{ $cardImage }}" class="card-img h-100"
                                        style="object-fit: cover; filter: brightness(0.7);" alt="Card image">
                                    <a href="#" target="_blank">
                                        <div class="card-img-overlay d-flex flex-column justify-content-end text-start">
                                            <h1 class="card-title text-warning mb-1" style="font-size: 1.5rem;">Featured Research</h1>

                                            <h6 class="text-white fw-bold mb-1" style="font-size: 1rem;">
                                                {{ Str::beforeLast($featuredResearch->file_name, '.') }}
                                            </h6>

                                            <p class="card-text text-white mb-2">
                                                {{ Str::limit($featuredResearch->description, 100) }}
                                            </p>

                                            <small class="text-white-50">
                                                Last updated: {{ $featuredResearch->updated_at->diffForHumans() }}
                                            </small>
                                        </div>

                                    </a>
                                </div>
                            </div>
                        @endif


                        <!-- Card 2 -->
                        @if ($mostViewedResearch)
                            <div class="col-md-3">
                                <div class="card card-hover h-100 text-white position-relative overflow-hidden"
                                    style="min-height: 320px;">
                                    <img src="{{ asset('template/img/digital_book2.jpg') }}" class="card-img h-100"
                                        style="object-fit: cover; filter: brightness(0.7);" alt="Card image">
                                    <a href="#" target="_blank">
                                        <div class="card-img-overlay d-flex flex-column justify-content-end text-start">
                                            <h1 class="card-title text-warning" style="font-size: 1.5rem;">Most Viewed Research</h1>

                                            <h6 class="text-white fw-bold mb-1" style="font-size: 1rem;">
                                                {{ Str::beforeLast($mostViewedResearch->file_name, '.') }}
                                            </h6>

                                            <p class="card-text text-white mb-2">
                                                {{ Str::limit($mostViewedResearch->description, 100) }}
                                            </p>

                                            <small class="text-white-50">
                                                Views: {{ $mostViewedResearch->view_count }} ·
                                                Last updated: {{ $mostViewedResearch->updated_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif


                        <!-- Card 3 -->
                        @if ($mostDownloadedResearch)
                            <div class="col-md-3">
                                <div class="card card-hover h-100 text-white position-relative overflow-hidden"
                                    style="min-height: 320px;">
                                    <img src="{{ asset('template/img/download_number.jpg') }}" class="card-img h-100"
                                        style="object-fit: cover; filter: brightness(0.7);" alt="Card image">
                                    <a href="#" target="_blank">
                                        <div class="card-img-overlay d-flex flex-column justify-content-end text-start">
                                            <h1 class="card-title text-warning" style="font-size: 1.5rem;">Most Downloaded Research</h1>

                                            <h6 class="text-white fw-bold mb-1" style="font-size: 1rem;">
                                                {{ Str::beforeLast($mostDownloadedResearch->file_name, '.') }}
                                            </h6>

                                            <p class="card-text text-white mb-2">
                                                {{ Str::limit($mostDownloadedResearch->description, 100) }}
                                            </p>

                                            <small class="text-white-50">
                                                Downloads: {{ $mostDownloadedResearch->download_count }} ·
                                                Last updated: {{ $mostDownloadedResearch->updated_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif


                        <!-- Card 4 -->
                        <div class="col-md-3">
                            <div class="card card-hover h-100 position-relative overflow-hidden bg-dark text-white"
                                style="min-height: 320px;">


                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                    <h1 class="text-warning">Related Studies</h1>
                                    <table class="table table-borderless text-white">
                                        <tbody>
                                            <tr>
                                                <td>Lorem ipsum dolor sit amet</td>
                                            </tr>
                                            <tr>
                                                <td>John Doe</td>
                                            </tr>
                                            <tr>
                                                <td>John Doe</td>
                                            </tr>
                                            <tr>
                                                <td>1,234</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>


            <!-- Chatbot Trigger Button with Thought Cloud -->
            <div style="position: fixed; bottom: 30px; right: 30px; z-index: 9999;">
                <button type="button" class="btn p-0 border-0" style="background: transparent;" data-toggle="modal"
                    data-target="#chatbotModal">
                    <div class="chatbot-container position-relative">
                        <img src="{{ asset('template/img/chat_kalaw.png') }}" alt="Chat Icon"
                            style="width: 60px; height: 100px;" class="rounded-circle shadow-lg">
                        <div class="thought-cloud">View FAQs</div>
                    </div>
                </button>
            </div>




            <!-- Chatbot Modal -->
            <div class="modal fade" id="chatbotModal" tabindex="-1" role="dialog" aria-labelledby="chatbotModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="chatbotModalLabel">CPSU Chat Assistant</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="height: 400px; overflow-y: auto;">
                            <p class="text-muted text-center">Hello! How can I help you today?</p>
                            <!-- Add your chatbot iframe, widget, or static content here -->
                            <div class="alert alert-light">
                                <strong>Tip:</strong> This is a placeholder for chatbot UI. Integrate your bot (e.g.,
                                Dialogflow, Botpress, or manual script).
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" class="form-control" placeholder="Type your message..." />
                            <button type="button" class="btn btn-success">Send</button>
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

    <script>
        document.querySelectorAll('.rating').forEach(function(container) {
            const stars = container.querySelectorAll('.fa-star');
            const docId = container.getAttribute('data-doc-id');
            const form = document.querySelector(`#rating-form-${docId}`);
            const ratingInput = form.querySelector('.rating-value');

            stars.forEach((star, index) => {
                star.addEventListener('mouseover', () => {
                    stars.forEach((s, i) => {
                        s.classList.toggle('fas', i <= index);
                        s.classList.toggle('far', i > index);
                    });
                });

                star.addEventListener('mouseout', () => {
                    const avg = parseFloat(container.querySelector('small').innerText.split('/')[
                        0]);
                    stars.forEach((s, i) => {
                        s.classList.toggle('fas', i < avg);
                        s.classList.toggle('far', i >= avg);
                    });
                });

                star.addEventListener('click', () => {
                    ratingInput.value = index + 1;
                    form.submit();
                });
            });
        });
    </script>

@endsection
