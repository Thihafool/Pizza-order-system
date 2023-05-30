@extends('admin.layout.master')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">
                        <h3>Total -{{$contacts->total()}} </h3>

                        <table class="table table-data2 text-center">

                            <thead>
                                <tr class="">
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">

                            <tr>
                             @foreach ($contacts as $contact)
                                <td>{{$contact->name}}</td>
                                <td>{{$contact->email}}</td>
                                <td>{{$contact->message}}</td>

                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$contacts->links()}}
                        </div>
                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>

        </div>
    </div>

@endsection
