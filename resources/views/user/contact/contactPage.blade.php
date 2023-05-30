@extends('user.layouts.master')
@section('title','Create Category')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Send Message</h3>
                        </div>
                        @if (session('message'))
                        <div class="col-12 ">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i>{{session('message')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                        </div>
                        @endif
                        <hr>
                        <form action="{{route('user#contact')}}" method="post" novalidate="novalidate">
                            @csrf
                            <div class="form-group ">
                                <label  class="control-label mb-1">Name</label>
                                <input type="hidden" value="" name="userName">
                                <input id="cc-pament" name="userName" type="text" value="" class="form-control @error('userName') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Name">
                                @error('userName')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>
                            <div class="form-group">
                                <label  class="control-label mb-1">Email</label>
                                <input type="hidden" value="" name="userEmail">
                                <input id="cc-pament" name="userEmail" type="text" value="" class="form-control @error('userEmail') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Email">
                                @error('userEmail')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label  class="control-label mb-1">Description</label>

                                <textarea cols="30" rows="10" id="cc-pament" name="message" value=""  class="form-control @error('message') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Message"></textarea>
                                @error('message')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Send</span>
                                    <i class="fa-solid fa-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
