@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<div class="page-content"> 
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit Blog Category</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Blog Category</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-10">
								<div class="card">
									<div class="card-body">
                                        <form id="myForm" method="post" action="{{ route('update.blog.category') }}">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $blogCategories->id }}" />

                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Blog Category Name</h6>
                                                </div>
                                                <div class="form-group col-sm-9 text-secondary">
                                                    <input type="text" name="blog_category_name" value="{{ $blogCategories->blog_category_name }}" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                                </div>
                                            </div>
                                        </form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

            <script type="text/javascript">
                $(document).ready(function (){
                    $('#myForm').validate({
                        rules: {
                            blog_category_name: {
                                required : true,
                            }, 
                        },
                        messages :{
                            blog_category_name: {
                                required : 'Please enter blog category name',
                            },
                        },
                        errorElement : 'span', 
                        errorPlacement: function (error,element) {
                            error.addClass('invalid-feedback');
                            element.closest('.form-group').append(error);
                        },
                        highlight : function(element, errorClass, validClass){
                            $(element).addClass('is-invalid');
                        },
                        unhighlight : function(element, errorClass, validClass){
                            $(element).removeClass('is-invalid');
                        },
                    });
                });
                
            </script>
@endsection