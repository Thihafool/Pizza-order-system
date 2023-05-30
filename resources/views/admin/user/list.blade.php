@extends('admin.layout.master')
@section('title', 'User List')
@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">
                        <h3>Total - {{ $users->total() }}</h3>

                        <table class="table table-data2 text-center">
                            <thead>
                                <tr class="">
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                <tr>
                                    @foreach ($users as $user)
                                        <td class="col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/defaultUserImg.png') }} "
                                                        class="img-thumbnail shadow-sm" alt="">
                                                @else
                                                    <img src="{{ asset('image/images.jpg') }} "
                                                        class="img-thumbnail shadow-sm" alt="">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}" alt="">
                                            @endif
                                        </td>
                                        <input type="hidden" value="{{ $user->id }}" name="" id="userId">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            <select class="form-control statusChange" name="" id="">
                                                <option value="user" @if ($user->role == 'user') selected @endif>
                                                    User</option>
                                                <option value="admin" @if ($user->role == 'admin') selected @endif>
                                                    Admin</option>
                                            </select>
                                        </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>

                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.statusChange').change(function() {

                $currentStatus = $(this).val()
                $parentNode = $(this).parents("tr");

                $userId = $parentNode.find('#userId').val()
                $data = {
                    'userId': $userId,
                    'role': $currentStatus
                };

                $.ajax({
                    type: 'get',
                    url: '/user/change/role',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
