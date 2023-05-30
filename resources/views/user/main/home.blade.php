@extends('user.layouts.master')
@section('content')

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter By
                        Category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class=" d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="mt-2" for="price-all">Categories</label>
                            <span class="badge border font-weight-normal ">{{ count($category) }}</span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{ route('user#home') }}" class="text-dark "> <label class=""
                                    for="price-1">all</label>
                            </a>
                        </div>

                        @foreach ($category as $c)
                            <div class=" d-flex align-items-center justify-content-between mb-3 pt-1">
                                <a href="{{ route('user#filter', $c->id) }}" class="text-dark"> <label class=""
                                        for="price-1">{{ $c->name }}</label> {{-- $c->id --}}
                                </a>
                            </div>
                        @endforeach

                    </form>
                </div>
                <!-- Price End -->



            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route('user#cartList') }}">
                                    <button type="button" class="btn btn-primary position-relative">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($cart) }}
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </button>
                                </a>
                                <a href="{{ route('user#history') }} " class="ms-3">
                                    <button type="button" class="btn btn-primary position-relative">
                                        <i class="fa-solid fa-clock-rotate-left me-1"></i>History
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($cart) }}
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </button>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="sorting" class="form-control bg-dark text-white " id="sortingOption">
                                        <option value="" class="text-center ">Sort By</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>

                                    </select>
                                </div>
                                {{-- <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row" id="dataList">
                        @if (count($pizza) != 0)
                            @foreach ($pizza as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div id="myForm" class="product-item bg-light mb-4 "id="myForm">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style='height: 210px;'
                                                src="{{ asset('storage/' . $p->image) }}" alt="">
                                            <div class="product-action">
                                                {{-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a> --}}
                                                <a class="btn btn-outline-dark btn-square"
                                                    href="{{ route('user#pizzaDetails', $p->id) }}"><i
                                                        class="fa fa-shopping-cart"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="">{{ $p->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $p->price }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="p-3 text-center shadow-sm fs-4 col-6 offset-3">There is no pizza<i
                                    class="fa fa-solid fa-pizza-slice ms-3"></i></a></p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection
@section('scriptSource')
    <Script>
        $(document).ready(function() {

            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val()
                // console.log($eventOption);

                if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://localhost:8000/user/ajax/pizza/list',
                        data: {
                            'status': 'asc'
                        },
                        dataType: 'json',
                        success: function(data) {
                            $list = '';
                            for ($i = 0; $i < data.length; $i++) {
                                $list += `
                                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
                                        <div  id="myForm" class="product-item bg-light mb-4 ">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100" style = 'height: 210px;' src="{{ asset('storage/${data[$i].image}') }}" alt="">
                                                <div class="product-action">
                                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                    <a class="btn btn-outline-dark btn-square" href="{{ route('user#pizzaDetails', $p->id) }}"><i class="fa-solid fa-circle-info"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center py-4">
                                                <a class="h6 text-decoration-none text-truncate" href="">${data[$i].name}</a>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>${data[$i].price}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            }
                            $('#dataList').html($list)
                        }
                    })
                } else if ($eventOption == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://localhost:8000/user/ajax/pizza/list',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(data) {
                            $list = '';
                            for ($i = 0; $i < data.length; $i++) {
                                $list += `
                              <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div id="myForm" class="product-item bg-light mb-4 "id="myForm">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style='height: 210px;'
                                            src="{{ asset('storage/${data[$i].image}') }}" alt="">
                                        <div class="product-action">
                                            {{-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a> --}}
                                            <a class="btn btn-outline-dark btn-square"
                                                href="{{ route('user#pizzaDetails', $p->id) }}"><i
                                                    class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="">${data[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${data[$i].price}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                            }
                            $('#dataList').html($list)
                        }
                    })
                }

            })
        });


        // $(document).ready(function() {
        //     $('#sortingOption').change(function() {
        //         $eventOption = $('#sortingOption').val()

        //         if ($eventOption == 'asc') {
        //             $.ajax({
        //                 type: 'get',
        //                 url: 'http://localhost:8000/user/ajax/pizza/list',
        //                 data: {
        //                     'status': 'asc'
        //                 },
        //                 dataType: 'json',
        //                 success: function(data) {
        //                     // console.log(data[0].name)
        //                     $list = '';
        //                     for ($i = 0; $i < data.length; $i++) {
        //                         $list += `
    //         <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
    //             <div  id="myForm" class="product-item bg-light mb-4 ">
    //                 <div class="product-img position-relative overflow-hidden">
    //                     <img class="img-fluid w-100" style = 'height: 210px;' src="{{ asset('storage/${data[$i].image}') }}" alt="">
    //                     <div class="product-action">
    //                         <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
    //                         <a class="btn btn-outline-dark btn-square" href="{{ route('user#pizzaDetails', $p->id) }}"><i class="fa-solid fa-circle-info"></i></a>
    //                     </div>
    //                 </div>
    //                 <div class="text-center py-4">
    //                     <a class="h6 text-decoration-none text-truncate" href="">${data[$i].name}</a>
    //                     <div class="d-flex align-items-center justify-content-center mt-2">
    //                         <h5>${data[$i].price}</h5>
    //                     </div>
    //                 </div>
    //             </div>
    //         </div>`;
        //                     }
        //                     // console.log($list);
        //                     $('#dataList').html($list);
        //                 }
        //             })
        //         } else if ($eventOption == 'desc') {
        //             $.ajax({
        //                 type: 'get',
        //                 url: 'http://localhost:8000/user/ajax/pizza/list',
        //                 data: {
        //                     'status': 'desc'
        //                 },
        //                 dataType: 'json',
        //                 success: function(data) {
        //                     $list = '';
        //                     for ($i = 0; $i < data.length; $i++) {
        //                         $list += `
    //         <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
    //             <div  id="myForm" class="product-item bg-light mb-4 ">
    //                 <div class="product-img position-relative overflow-hidden">
    //                     <img class="img-fluid w-100" style = 'height: 210px;' src="{{ asset('storage/${data[$i].image}') }}" alt="">
    //                     <div class="product-action">
    //                         <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
    //                         <a class="btn btn-outline-dark btn-square" href="{{ route('user#pizzaDetails', $p->id) }}"><i class="fa-solid fa-circle-info"></i></a>
    //                     </div>
    //                 </div>
    //                 <div class="text-center py-4">
    //                     <a class="h6 text-decoration-none text-truncate" href="">${data[$i].name}</a>
    //                     <div class="d-flex align-items-center justify-content-center mt-2">
    //                         <h5>${data[$i].price}</h5>
    //                     </div>
    //                 </div>
    //             </div>
    //         </div>`;
        //                     }
        //                     // console.log($list);
        //                     $('#dataList').html($list);
        //                 }
        //             })
        //         }


        //     })
        // });
    </Script>
@endsection
