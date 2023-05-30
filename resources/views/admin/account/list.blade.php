@extends('admin.layout.master')
@section('title','Category List')
@section('content')

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Admin List</h2>

                        </div>
                    </div>

                </div>

                @if (session('deleteSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{session('deleteSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-secondary">Search Key: <span class="text-danger">{{request('key')}}</span></h4>
                    </div>
                    <div class="col-3 offset-6">
                        <form action="{{route('admin#list')}} " method="get">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="key" id="" class="form-control" placeholder="Search" value="{{request('key')}}">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                        </div>
                </div>
                <div class="row mt-3 m-0">
                    <div class="col-2 offset-10 btn btn-dark ">
                        <h4 class="text-white">Total -  {{$admin->total()}}</h4>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr class="">
                                <th>Image</th>
                                <th  > Name</th>
                                <th > Email</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin as $a )
                            <tr class="tr-shadow ">
                                <td class="col-2">
                                    @if ($a->image == null)
                                        @if ($a->gender == 'male')
                                        <img src="{{asset('image/defaultUserImg.png')}} " class="img-thumbnail shadow-sm" alt="">
                                        @else
                                        <img src="{{asset('image/images.jpg')}} " class="img-thumbnail shadow-sm" alt="">
                                        @endif
                                    @else
                                    <img src="{{asset('storage/'.$a->image)}}" class="img-thumbnail shadow-sm" alt="">
                                    @endif
                                </td>
                                <td>{{$a->name}}</td>
                                <td>{{$a->email}}</td>
                                <td>{{$a->gender}}</td>
                                <td>{{$a->address}}</td>
                                <td>{{$a->phone}}</td>
                                <td>
                                    <input type="hidden" id="userId" value="{{$a->id}} ">
                                    <div class="table-data-feature">
                                        {{-- <a href=" @if (Auth::user()->id == $a->id) # @else {{route('admin#delete')}} @endif" onclick="return confirm('Are you sure you want to Delete?');"> --}}
                                                @if (Auth::user()->id == $a->id)
                                                @else
                                            <select name="" id="role" class="form-control me-2">
                                                <option value="user" @if (Auth::user()->role == 'user') selected @endif>User</option>
                                                <option value="admin" @if (Auth::user()->role == 'admin') selected @endif>Admin</option>
                                            </select>
                                            <a href="{{route('admin#delete',$a->id)}}" onclick="return confirm('Are you sure you want to Delete?');">
                                                <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </a>
                                            @endif
                                    </div>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{$admin->appends(request()->query())->links()}}
                    </div>

                </div>

                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection

@section('scriptSource')
    <script>
        $('document').ready(function(){


            $('#role').change(function(){

                $currentStatus = $(this).val();
                // console.log($currentStatus);

                $parentNode = $(this).parents('tr');
                // console.log($parentNode.html())
                 $userId = $parentNode.find('#userId').val();
                //  console.log($userId);
                $data = {
                    'userId' : $userId,
                    'role' : $currentStatus
                }
                // console.log($data);


                $.ajax({
                    type: 'get',
                    url: '/admin/change/role',
                    data: $data,
                    dataType: 'json',
            })
            location.reload();

            })
        })
    </script>


@endsection
