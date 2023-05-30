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
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Profile</h3>
                        </div>
                        <hr>
                      <form action="{{route('admin#update',Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 offset-1 ">
                                @if (Auth::user()->image == null)
                                    @if (Auth::user()->gender == 'male')
                                    <img src="{{asset('image/defaultUserImg.png')}} " class="img-thumbnail shadow-sm" alt="">
                                    @else
                                    <img src="{{asset('image/images.jpg')}} " class="img-thumbnail shadow-sm" alt="">
                                    @endif
                                @else
                                <img class="img-thumbnail shadow-sm" src="{{asset('storage/'.Auth::user()->image)}}"  />
                                @endif
                                <div class="mt-3 ">
                                    <input type="file" class="@error('image') is-invalid @enderror" name="image" id="">
                                    @error('image')
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

                                    <input id="cc-pament" name="name" type="text" value="{{old('name',Auth::user()->name)}}"  class="form-control  @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Admin Name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">Email</label>

                                    <input id="cc-pament" name="email" type="email" value="{{old('email',Auth::user()->email)}}"  class="form-control  @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Admin Email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">Phone</label>

                                    <input id="cc-pament" name="phone" type="number" value="{{old('phone',Auth::user()->phone)}}"  class="form-control  @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Admin Phone">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group" >
                                    <label for="">Gender</label>
                                    <select name="gender" class="form-control  @error('gender') is-invalid @enderror">
                                        <option value="">Choose gender</option>
                                        <option  value="male" @if (Auth::user()->gender == 'male') selected @endif>Male</option>
                                        <option value="female" @if (Auth::user()->gender == 'female') selected @endif>Female</option>
                                    @error('gender')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">Address</label>
                                    <textarea  placeholder="Enter Admin Address" value="" class="form-control  @error('address') is-invalid @enderror" name="address" id="" cols="30" rows="10">{{old('address',Auth::user()->address)}}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label  class="control-label mb-1">Role</label>

                                    <input id="cc-pament" name="newPassword" type="text" value="{{old('role',Auth::user()->role)}}"  class="form-control " aria-required="true" aria-invalid="false" placeholder="" disabled>

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
