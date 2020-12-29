@section('title')
List image
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-title py-4 mb-5">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h3 class="page-title">Images</h3>
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
                <div class="row justify-content-between align-items-center flex-grow-1 px-3">
                    <div class="filter mr-5 d-flex" d-flex>
                        <form action="{{route('bulkActionImages')}}" class="d-flex" method="POST" id="bulkActions">
                            @csrf
                            <div class="form-group">
                                    <select class="form-control" name="select" id="actions">
                                        <option value="none">Bulk Actions</option>
                                        <option value="delete">Delete</option>
                                    </select>
                            </div>
                                <button type="submit" class="btn btn-post-apply mx-2" name="action" style="height: calc(1.5em + .75rem + 2px);"> Apply</button>
                        </form>
                        <form action="{{route('limitImages')}}" method="GET" class="d-flex">
                            <div class="form-group mb-0 mr-2">
                                <select class="form-control " id="sel1" name="showData" onchange="this.form.submit()">
                                    <option value="10" @if (session()->has('limit')&& session('limit')==10) {{'selected'}}@endif>10</option>
                                    <option value="20" @if (session()->has('limit')&& session('limit')==20) {{'selected'}}@endif>20</option>
                                    <option value="50" @if (session()->has('limit')&& session('limit')==50) {{'selected'}}@endif>50</option>
                                </select>
                            </div>
                        </form>
                        <form action="{{route('sortImages')}}" method="GET" >
                            <div class="form-group mr-2">

                                <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
                                    <option value="none">Any</option>
                                    <option value="asc" @if (session()->has('sort')&& session('sort')=="asc") {{'selected'}}@endif>Name A-Z</option>
                                    <option value="desc" @if (session()->has('sort')&& session('sort')=="desc") {{'selected'}}@endif>Name Z-A</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <form method="get" action="{{route('searchImages')}}">
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control" name="search" placeholder="Search Categories" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];}?>">
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
                                <th style="width: 30%;">File</th>
                                <th style="width: 20%;">Type</th>
                                <th style="width: 25%;" >Created at</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($imagesCategories as $imgCategory)
                            <tr>
                                <td>
                                    <input type="checkbox" id="vehicle1" name="check[]" form="bulkActions" value="{{$imgCategory->id}}"
                                    @if (Auth::User()->role!==2 || $imgCategory->id==99)
                                        disabled
                                    @endif>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="">
                                            <img class="imagePost" src="{{asset('admin_asset/image/upload/'.$imgCategory->image)}}" alt="avatar">
                                        </div>
                                        <div class="ml-3">
                                            {{substr($imgCategory->image,8)}}<p>
                                                @if ($imgCategory->type == "category")
                                                    <small class="badge badge-info">Category-{{$imgCategory->id}}</small>
                                                @else
                                                    <small class="badge badge-warning">tag-{{$imgCategory->id}}</small>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($imgCategory->type == "category")
                                        <p class="badge badge-info"> Category</p>
                                    @else
                                        <p class="badge badge-warning"> tag</p>
                                    @endif

                                </td>
                                <td>{{ $imgCategory->created_at}}</td>
                                <td>
                                    <a href="{{ route('getEditImgCategory',['id'=>$imgCategory->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->role==2 && $imgCategory->id!==99)
                                        @else
                                            onclick="return errorRole()"
                                            style="background-color: rgb(179, 179, 179)"
                                        @endif
                                    ><i class="fas fa-pen"></i> Edit</a>
                                    <a href="{{ route('deleteImgCategory',['id'=>$imgCategory->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->role==2 && $imgCategory->id!==99)
                                            onclick="return removeItem()"
                                        @else
                                            onclick="return errorRole()"
                                            style="background-color: rgb(179, 179, 179)"
                                        @endif
                                    ><i class="fas fa-trash-alt"></i> Remove</a>
                                </td>
                            </tr>
                            @endforeach
                            @foreach ($imagesPosts as $imgPost)
                            <tr>
                                <td>
                                    <input type="checkbox" id="vehicle1" name="check2[]" form="bulkActions" value="{{$imgPost->id}}"
                                    @if (Auth::User()->id==$imgPost->posts->author || Auth::User()->role==2)
                                    @else
                                        disabled
                                    @endif>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="">
                                            <img class="imagePost" src="{{asset('admin_asset/image/upload/'.$imgPost->meta_value)}}" alt="avatar">
                                        </div>
                                        <div class="ml-3">
                                            {{substr($imgPost->meta_value,8)}}<p><small class="badge badge-secondary">Post-{{$imgPost->posts->id}}</small></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="badge badge-secondary"> Post</p>
                                </td>
                                <td>{{ $imgPost->posts->created_at}}</td>
                                <td>
                                    <a href="{{ route('getEditImgPost',['id'=>$imgPost->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->id==$imgPost->posts->author || Auth::User()->role==2)
                                        @else
                                            onclick="return errorRole()"
                                            style="background-color: rgb(179, 179, 179)"
                                        @endif
                                    ><i class="fas fa-pen"></i> Edit</a>
                                    <a href="{{ route('deleteImgPost',['id'=>$imgPost->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->id==$imgPost->posts->author || Auth::User()->role==2)
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
                        <span id="datatableWithPaginationInfoTotalQty">{{$imagesPosts->count()+$imagesCategories->count()}}</span>
                        <span class="text-secondary mx-2">entries</span>
                        </div>

                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">

                        </div>
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
    CountSelectedCB = [];
    $("input:checkbox").change(function() {
        selectedCB = [];
        notSelectedCB = [];

        CountSelectedCB.length = 0; // clear selected cb count
        $("input[name=check2]").each(function() {
            if ($(this).is(":checked")) {
                CountSelectedCB.push($(this).attr("value"));
            }
        });

        $('input[name=selectedCB2]').val(CountSelectedCB);

    });
});
</script>
@endsection

