@section('title')
    List User
@endsection

@extends('admin.layout.index')

@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-title py-4 mb-5">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">

                        <h1 class="page-title">Users</h1>
                    </div>

                    <div class="col-sm-auto">
                        <a class="btn btn-primary" href="{{ route('getAddUser')}}">
                        <i class="fas fa-user-plus"></i> Add user
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            @if (session('messageWarning'))
            <div class="alert alert-warning">
                    {{session('messageWarning')}}
            </div>
            @endif
            @if (session('message'))
            <div class="alert alert-success">
                    {{session('message')}}
            </div>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="search mb-1">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-sm-8 mt-4">
                        <div class="row">
                            <div class="col-md-5">
                                <form action="{{route('bulkActionUsers')}}" id="bulkActions" class="d-flex" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <select class="form-control" name="select" id="actions">
                                            <option value="none">Bulk Actions</option>
                                            <option value="1" >Active</option>
                                            <option value="0" >Deactive</option>
                                            <option value="delete" >Delete</option>
                                        </select>
                                    </div>
                                        <button id="buttonActions" type="submit" class="btn btn-post-apply mx-2" name="action" style="height: calc(1.5em + .75rem + 2px);"> Apply</button>
                                </form>
                            </div>
                            <div class="col-md-7">
                                <form method="GET" action="{{route('searchUsers')}}">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch" type="search" class="form-control" name="search" placeholder="Search users" value="">
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 d-flex" d-flex>
                        <form action="{{route('sortUsers')}}" method="get" >
                            <div class="form-group mr-2">
                                <label for="sort">sort:</label>
                                <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
                                    <option value="">Any</option>
                                    <option value="asc" @if (session()->has('sort')&& session('sort')=="asc") {{'selected'}}@endif>ASC</option>
                                    <option value="desc" @if (session()->has('sort')&& session('sort')=="desc") {{'selected'}}@endif>DESC</option>
                                </select>
                            </div>
                        </form>
                        <form action="{{route('statusUsers')}}" class="d-flex" method="GET">
                            <div class="form-group">
                                <label for="sel3">Status:</label>
                                    <select class="form-control" id="sel3" name="status" onchange="this.form.submit()">
                                        <option value="">Any Status</option>
                                        <option value="1" @if (session()->has('status')&& session('status')=="1") {{'selected'}}@endif>active</option>
                                        <option value="0" @if (session()->has('status')&& session('status')=="0") {{'selected'}}@endif>deactive</option>
                                    </select>
                            </div>
                         </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-12">
            <div class="content-data justify-content-center table-responsive">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 5%;"><input type="checkbox" id="select-all"></th>
                                <th>FULLNAME</th>
                                <th>CONTACT</th>
                                <th>role</th>
                                <th>STATUS</th>
                                <th>CREATED AT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    <input type="checkbox" name="check[]" form="bulkActions" value="{{$user->id}}">
                                </td>
                                <td>
                                    <div class="d-flex">
                                    <div class="avatar avatar-circle">
                                        <img class="avatar-img" src=@if($user->avatar !== "" && isset($user->avatar))
                                            {!!asset('admin_asset/image/upload/'.$user->avatar)!!}

                                        @else
                                            {{Avatar::create($user->name)->toBase64()}}
                                        @endif
                                        alt="avatar">
                                    </div>
                                    <div class="ml-3">
                                        {{$user->name}} <p><small>{{$user->email}}</small></p>
                                    </div>

                                    </div>

                                </td>

                                <td>{{$user->address}} <p>{{$user->phone}}</p></td>
                                <td>
                                    @if($user->role ==2)
                                        <p class='badge badge-danger'>Super admin</p>
                                    @elseif($user->role ==1)
                                        <p class='badge badge-primary'>Admin</p>
                                    @else
                                        <p>User</p>
                                    @endif
                                </td>
                                <td>
                                    @if($user->status ==1)
                                        <a href="{{ route('change-status',['id'=>$user->id]) }}" class="btn badge badge-success"
                                            @if (Auth::User()->role==2 || Auth::User()->id==$user->id)
                                            @else
                                                onclick="return errorRole()"
                                                style="background-color: rgb(179, 179, 179)"
                                            @endif
                                        >Active</a>
                                    @else
                                    <a href="{{ route('change-status',['id'=>$user->id]) }}" class="btn badge badge-danger"
                                        @if (Auth::User()->role==2 || Auth::User()->id==$user->id)
                                        @else
                                            onclick="return errorRole()"
                                            style="background-color: rgb(179, 179, 179)"
                                        @endif
                                    >Deactive</a>
                                    @endif
                                </td>
                                <td>
                                    {{$user->created_at}}
                                </td>
                                <td>
                                    <a href="{{ route('getEditUser',['id'=>$user->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->id==$user->id || Auth::User()->role==2)
                                        @else
                                            onclick="return errorRole()"
                                            style="background-color: rgb(179, 179, 179)"
                                        @endif
                                    ><i class="fas fa-pen"></i> Edit</a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-end justify-content-sm-end align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                        <span class="mr-2">Showing:</span>
                        <form action="{{route('limitUsers')}}" method="GET" class="d-flex">
                            <div class="form-group mb-0">
                                <select class="form-control" id="sel1" name="showData" onchange="this.form.submit()">
                                    <option value="10" @if (session()->has('limit')&& session('limit')==10) {{'selected'}}@endif>10</option>
                                    <option value="20" @if (session()->has('limit')&& session('limit')==20) {{'selected'}}@endif>20</option>
                                    <option value="50" @if (session()->has('limit')&& session('limit')==50) {{'selected'}}@endif>50</option>
                                </select>
                            </div>
                        </form>
                        <span class="text-secondary mx-2">of</span>
                        <span id="datatableWithPaginationInfoTotalQty">{{ $users->count() }}</span>
                        </div>

                    </div>
                    <div class="col-sm-auto">

                        <!-- Pagination -->
                        {{ $users->links() }}
                    </div>
                </div>

                <!-- End Pagination -->

            </div>
        </div>
    </div>
</div>
@endsection
