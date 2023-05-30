@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <form action="{{ route('admin#changeStatus') }}" class="col-4" method="get">

                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <h5 class="text-dark input-group-text">Total - {{ count($order) }}</h5>
                            </div>
                            <select name="orderStatus" class="form-select " id="inputGroupSelect02">
                                <option value="">All</option>
                                <option value="0"@if (request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1"@if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2"@if (request('orderStatus') == '2') selected @endif>Reject</option>

                            </select>
                            <div class="input-group-append">
                                <button type="submit"class="input-group-text" for="inputGroupSelect02">Search</button>
                            </div>
                        </div>
                    </form>
                    {{-- @if (count($pizzas) != 0) --}}
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr class="">
                                    <th>User Id</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($order as $o)
                                    <tr class="tr-shadow ">
                                        <input type="hidden" class="orderId" value="{{ $o->id }}">

                                        <td class="col-2">{{ $o->user_id }}</td>
                                        <td class="col-2">{{ $o->user_name }}</td>
                                        <td class="col-2">{{ $o->created_at->format('j-F-Y') }}</td>
                                        <td class="col-2">
                                            <a href="{{ route('admin#listInfo', $o->order_code) }}">{{ $o->order_code }}</a>
                                        </td>
                                        <td class="col-2">{{ $o->total_price }} Kyats</td>
                                        <td class="col-2">
                                            <select name="status" class="form-control statusChange">
                                                <option value="0" @if ($o->status == 0) selected @endif>
                                                    Pending</option>
                                                <option value="1" @if ($o->status == 1) selected @endif>
                                                    Success</option>
                                                <option value="2" @if ($o->status == 2) selected @endif>
                                                    Reject</option>

                                            </select>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{-- {{$order->appends(request()->query())->links()}} --}}
                        </div>

                    </div>
                    {{-- @else
                <h3 class="text-center text-secondary mt-5">There is no Pizza here</h3>
                @endif --}}
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            changeStatus
            $('.statusChange').change(function() {

                $currentStatus = $(this).val()
                $parentNode = $(this).parents("tr");

                $orderId = $parentNode.find('.orderId').val()
                console.log($orderId)
                console.log($parentNode.find('#amount').html());

                $data = {
                    'status': $currentStatus,
                    'orderId': $orderId
                };


                $.ajax({
                    type: 'get',
                    url: '/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',
                })
            })
        })
    </script>
@endsection
