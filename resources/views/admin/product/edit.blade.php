@extends('admin.layout.master')
@section('title','Create Category')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="row">
        <div class="col-4 offset-6 mb-2">
            @if (session('updateSuccess'))
            <div class="">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{session('updateSuccess')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
            </div>
            @endif

        </div>
    </div>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <a class="text-dark" href="{{route('product#list')}}">
                                {{-- <i class="fa-solid fa-arrow-left" onclick="history.back()"></i> --}}
                            </a>
                        </div>
                        <div class="card-title">
                            <h3 class="text-center title-2">Pizza Details</h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3 offset-1 ">

                                <img src="{{asset('storage/'.$pizza->image)}}"  />

                            </div>
                            <div class="col-7 ">
                                <div class="my-3 col-6 btn btn-danger d-block">{{$pizza->name}}</div>
                                <span class="my-3 btn btn-dark"><i class="fa-solid  fa-money-bill-1-wave me-1"></i>{{$pizza->price}}</span>
                                <span class="my-3 btn btn-dark"><i class="fa-solid  fa-clock me-1"></i>{{$pizza->waiting_time}}</span>
                                <span class="my-3 btn btn-dark"> <i class="fa-solid  fa-eye me-1"></i>{{$pizza->view_count}}</span>
                                <span class="my-3 btn btn-dark"> <i class="fa-solid  fa-clone me-1"></i>{{$pizza->category_name}}</span>
                                <span class="my-3 btn btn-dark"> <i class="fa-solid  fa-user-clock me-1"></i>{{$pizza->created_at->format('j-F-Y')}}</span>
                                <div class="my-3 d-inline"><i class="fa-solid fs-5 fa-file-lines me-2 d-block"></i>{{$pizza->description}}</div>
                            </div>
                        </div>
                        <div class="row">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
