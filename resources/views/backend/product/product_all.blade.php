@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Product</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Product</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{ route('add.product') }}" class="btn btn-primary">Add Product</a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>S1</th>
										<th>Image </th>
										<th>Product Name </th>
										<th>Price </th>
										<th>QTY </th>
										<th>Discount </th>
										<th>Status </th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($products as $key => $item)
									<tr>
										<td>{{ $key+1 }}</td>
										<td><img src="{{ asset($item->product_thumbnail) }}" style="width: 70px; height:40px;"></td>
										<td>{{ $item->product_name }}</td>
										<td>{{ $item->selling_price }}</td>
										<td>{{ $item->product_qty }}</td>

										<td>
											@if($item->discount_price == NULL)
												<div class="badge rounded-pill bg-light-info text-info w-100">No Discount</div>
											@else

												@php
													$amount = $item->selling_price - $item->discount_price;
													$discount = ($amount/$item->selling_price) * 100;
												@endphp

											<div class="badge rounded-pill bg-light-primary text-primary w-100">{{ round($discount) }}%</div>

											@endif
										</td>

										<td>
											@if($item->status == 1)
												<div class="badge rounded-pill bg-light-success text-success w-100">Active</div>
											@else
												<div class="badge rounded-pill bg-light-danger text-danger w-100">InActive</div>
											@endif 
									    </td>

										<td>
											<a href="{{ route('edit.product', $item->id) }}" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-pencil"></i></a>
											<a href="{{ route('delete.product', $item->id) }}" class="btn btn-danger btn-sm" id="delete"title="Delete Data"><i class="fa fa-trash"></i></a>							
											<a href="{{ route('edit.category', $item->id) }}" class="btn btn-info btn-sm" title="Details Page"><i class="fa fa-eye"></i></a>
											@if($item->status == 1)
												<a href="{{ route('product.inactive', $item->id) }}" class="btn btn-primary btn-sm" title="Inactive"><i class="fa-solid fa-thumbs-down"></i></a>
											@else
												<a href="{{ route('product.active', $item->id) }}" class="btn btn-primary btn-sm" title="Active"><i class="fa-solid fa-thumbs-up"></i></a>
											@endif 
										</td>

									</tr>
									@endforeach
								</tbody>
								<tfoot>
                                    <tr>
										<th>S1</th>
										<th>Image </th>
										<th>Product Name </th>
										<th>Price </th>
										<th>QTY </th>
										<th>Discount </th>
										<th>Status </th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>

@endsection