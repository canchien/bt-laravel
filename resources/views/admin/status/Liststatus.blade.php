@section('title')
List Status
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-title py-4 mb-5">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">

                        <h3 class="page-title">List Status</h3>
                    </div>

                    <div class="col-sm-auto">
                        <a class="btn btn-addPost" href="{{ route('getAddStatus') }}">
                            <i class="fas fa-user-plus"></i> Add new status
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            @if (session('message'))
            <div class="alert alert-success">
                    {{session('message')}}
            </div>
            @endif
            @if (session('messageWarning'))
            <div class="alert alert-warning">
                    {{session('messageWarning')}}
            </div>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="search mb-1">
                <div class="row justify-content-between align-items-center flex-grow-1 px-3">
                    <div class="filter mr-5 d-flex" d-flex>
                        <form action="{{route('bulkActionStatus')}}" id="bulkActions" class="d-flex" method="POST">
                            @csrf
                            <div class="form-group">
                                    <select class="form-control" name="select" id="actions">
                                        <option value="none">Bulk Actions</option>
                                        <option value="delete" <?php if(isset($_POST['ftStatus']) && $_POST['ftStatus']=='delete'){ echo 'selected';}?>>Delete</option>
                                    </select>
                            </div>
                                <button id="buttonActions" type="submit" class="btn btn-post-apply mx-2" name="action" style="height: calc(1.5em + .75rem + 2px);"> Apply</button>
                        </form>
                        <form action="{{route('limitStatus')}}" method="GET" class="d-flex">
                            <div class="form-group mb-0 mr-2">
                                <select class="form-control " id="sel1" name="showData" onchange="this.form.submit()">
                                    <option value="10" @if (session()->has('limit')&& session('limit')==10) {{'selected'}}@endif>10</option>
                                    <option value="20" @if (session()->has('limit')&& session('limit')==20) {{'selected'}}@endif>20</option>
                                    <option value="50" @if (session()->has('limit')&& session('limit')==50) {{'selected'}}@endif>50</option>
                                </select>
                            </div>
                        </form>
                        <form action="{{route('sortStatus')}}" method="GET" >
                            <div class="form-group mr-2">
                                <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
                                    <option value="none">Any</option>
                                    <option value="asc" @if (session()->has('sort')&& session('sort')=="asc") {{'selected'}}@endif>Name A-Z</option>
                                    <option value="desc" @if (session()->has('sort')&& session('sort')=="desc") {{'selected'}}@endif>Name Z-A</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3 ml-0">
                        <form method="GET" action="{{route('searchStatus')}}">
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control" name="search" placeholder="Search Categories" value="">
                        </div>
                        <!-- End Search -->
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
                                <th style="width: 30%;">Name</th>
                                <th>Status</th>

                                <th >Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($status as $value)
                            <tr>
                                <td>
                                    <input type="checkbox" id="vehicle1" name="check[]" form="bulkActions" value="{{$value->id}}"
                                    @if (Auth::User()->role!==2 || $value->id == 1)
                                        disabled
                                    @endif>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="color-status mr-1" style="background-color: {!!$value->term_description!!};"></div>
                                        {!! $value->name!!}
                                        @if ($value->id ==1)
                                            {!!"(Default)"!!}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {!! $value->status!!}
                                </td>
                                <td>{{ $value->created_at}}</td>
                                <td>
                                    <a href="{{ route('getEditStatus',['id'=>$value->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->role==2 && $value->id !== 1)
                                        @else
                                            onclick="return errorRole()"
                                            style="background-color: rgb(179, 179, 179)"
                                        @endif
                                    ><i class="fas fa-pen"></i> Edit</a>
                                    <a href="{{ route('deleteStatus',['id'=>$value->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->role==2 && $value->id !== 1)
                                            onclick="return removeItem()"
                                        @else
                                            onclick="return errorRole()"
                                            style="background-color: rgb(179, 179, 179)"
                                        @endif
                                    ><i class="fas fa-trash-alt"></i> Remove</a>
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
                        <span id="datatableWithPaginationInfoTotalQty">{{$count}}</span>
                        <span class="text-secondary mx-2">entries</span>
                        </div>

                    </div>
                    <div class="col-sm-auto">

                        <!-- Pagination -->
                        {{ $status->links() }}
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
        </div>
    </div>
</div>
@endsection

