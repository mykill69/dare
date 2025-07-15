@extends('guest.guestPage')
@section('body')
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<h2 class="text-center text-xlg" style="font-family: Helvetica;">Welcome to CPSU - RIMS! <br>Feel free to search for your research references.</h2>
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<form action="{{ route('searchGuest') }}" method="GET">
						<div class="input-group">
							<input type="search" name="query" class="form-control form-control-lg" placeholder="Type your keywords here">
							<div class="input-group-append">
								<button type="submit" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- Search Results Table -->
			@if(request()->has('query') && isset($searchResults) && count($searchResults) > 0)
			<div class="row" style="padding-top: 1%;">
				<div class="col-md-10 offset-md-1">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example2" class="table table-hover table-sm text-sm">
									<thead>
										<tr>
											{{-- <th>#</th> --}}
											<th>Research Title</th>
											<th>Researchers</th>
											<th>Category</th>
											<th>Date Submitted</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($searchResults as $index => $result)
										<tr>
											<td>
												<i class="fas fa-file-pdf text-danger"></i>
												<a href="{{ route('viewPdfGuest', $result->id) }}" target="_blank">
													{{ pathinfo($result->file_name, PATHINFO_FILENAME) }}
												</a>
											</td>
											<td>{{ $result->user_id }}</td>
											<td>{{ $result->file_category ?? 'No Category' }}</td>
											<td>{{ $result->created_at }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			@elseif(request()->has('query') && count($searchResults) == 0) <!-- No results found -->
			<div class="row" style="padding-top: 1%;">
				<div class="col-md-10 offset-md-1">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example1" class="table table-hover table-sm text-sm">
									<thead>
										<tr>
											<th>#</th>
											<th>Research Title</th>
											<th>Researchers</th>
											<th>Category</th>
											<th>Date Submitted</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="5" class="text-center">No data available in table</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
		</section>
	</div>
	@endsection