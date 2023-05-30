@extends('admin.layout.master')
@section('title','Create Category')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                         <a class="text-dark" href="{{route('product#list')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        <div class="card-title">
                            <h3 class="text-center title-2">Update Pizza</h3>
                        </div>
                        <hr>
                      <form action="{{route('product#update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 offset-1 ">
                                <input type='hidden' name = 'pizzaId' value = '{{$pizza->id}}'>
                                <img src="{{asset('storage/'.$pizza->image)}}" class="img-thumbnail shadow-sm " alt="">

                                <div class="mt-3 ">
                                    <input type="file" class=" form-control @error('pizzaImage') is-invalid @enderror" name="pizzaImage" id="">
                                    @error('pizzaImage')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="mt-3">
                                    <button class="btn bg-dark text-white col-12 " type="submit">Update</button>
                                </div>
                            </div>

                         <div class="col-6">

                            <div class=" ">
                                <div class="form-group">
                                    <label  class="control-label mb-1">Name</label>

                                    <input id="cc-pament" name="pizzaName" type="text" value="{{old('pizzaName',$pizza->name)}}"  class="form-control  @error('pizzaName') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Admin pizzaName">
                                    @error('pizzaName')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">Description</label>

                                    <textarea cols="30" rows="10" id="cc-pament" name="pizzaDescription" value=""  class="form-control  @error('pizzaDescription') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Admin pizzaDescription">{{old('pizzaDescription',$pizza->description)}}</textarea>
                                    @error('pizzaDescription')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>

                                <div class="form-group" >
                                    <label for="">Category</label>
                                    <select name="pizzaCategory" class="form-control  @error('pizzaCategory') is-invalid @enderror">
                                        <option value="">Choose category</option>
                                        @foreach ($category as $c)
                                        <option value="{{$c->id}}" @if ($pizza->category_id == $c->id) selected @endif>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">Price</label>

                                    <input id="cc-pament" name="pizzaPrice" type="number" value="{{old('pizzaPrice',$pizza->price)}}"  class="form-control  @error('pizzaPrice') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter pizzaPrice">
                                    @error('pizzaPrice')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">Waiting Time</label>

                                    <input id="cc-pament" name="pizzaWaitingTime" type="number" value="{{old('pizzaWaitingTime',$pizza->waiting_time)}}"  class="form-control  @error('pizzaWaitingTime') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter  pizzaWaitingTime">
                                    @error('pizzaWaitingTime')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">View Count</label>
                                    <input id="cc-pament" name="viewCount" type="text" disabled value="{{old('viewCount',$pizza->view_count)}}"  class="form-control " aria-required="true" aria-invalid="false" placeholder="Enter Admin viewCount">
                                </div>

                                <div class="form-group">
                                    <label  class="control-label mb-1">Created Date</label>
                                    <input id="cc-pament" name="created_at" type="text" value="{{$pizza->created_at->format('j-F-Y')}}"  class="form-control " aria-required="true" aria-invalid="false" placeholder="" disabled>
                                </div>

                            </div>
                         </div>
                        </div>
                      </form>

                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
