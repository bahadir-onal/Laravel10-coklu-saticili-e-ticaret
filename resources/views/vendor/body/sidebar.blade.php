@php
	$id = Auth::user()->id;
	$vendorId = App\Models\User::find($id);
	$status = $vendorId->status;
@endphp
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{ asset('adminbackend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Vendor</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="{{ route('vendor.dashboard') }}" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>

					@if($status === 'active')
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-coin-stack"></i>
						</div>
						<div class="menu-title">Product Management</div>
					</a>
					<ul>
						<li> <a href="{{ route('vendor.all.product') }}"><i class="bx bx-right-arrow-alt"></i>All Product</a>
						</li>
						<li> <a href="{{ route('vendor.add.product') }}"><i class="bx bx-right-arrow-alt"></i>Add Product</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-task"></i>
						</div>
						<div class="menu-title">All Order</div>
					</a>
					<ul>
						<li> <a href="{{ route('vendor.order') }}"><i class="bx bx-right-arrow-alt"></i>Vendor Order</a>
						</li>
					</ul>
				</li>

				@else
				
				@endif
				
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->