@section('title')
List Comments
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-title py-4 mb-5">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h3 class="page-title">List Tags</h3>
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
                        <form action="{{route('bulkActionComments')}}" id="bulkActions" class="d-flex" method="POST">
                            @csrf
                            <div class="form-group">
                                    <select class="form-control" name="select" id="actions">
                                        <option value="none">Bulk Actions</option>
                                        <option value="delete" <?php if(isset($_POST['ftStatus']) && $_POST['ftStatus']=='delete'){ echo 'selected';}?>>Delete</option>
                                    </select>
                            </div>
                                <button id="buttonActions" type="submit" class="btn btn-post-apply mx-2" name="action" style="height: calc(1.5em + .75rem + 2px);"> Apply</button>
                        </form>
                        <form action="{{route('limitComments')}}" method="GET" class="d-flex">
                            <div class="form-group mb-0 mr-2">
                                <select class="form-control " id="sel1" name="showData" onchange="this.form.submit()">
                                    <option value="10" @if (session()->has('limit')&& session('limit')==10) {{'selected'}}@endif>10</option>
                                    <option value="20" @if (session()->has('limit')&& session('limit')==20) {{'selected'}}@endif>20</option>
                                    <option value="50" @if (session()->has('limit')&& session('limit')==50) {{'selected'}}@endif>50</option>
                                </select>
                            </div>
                        </form>
                        <form action="{{route('sortComments')}}" method="GET" >
                            <div class="form-group mr-2">
                                <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
                                    <option value="">Any</option>
                                    <option value="asc" @if (session()->has('sort')&& session('sort')=="asc") {{'selected'}}@endif>Name A-Z</option>
                                    <option value="desc" @if (session()->has('sort')&& session('sort')=="desc") {{'selected'}}@endif>Name Z-A</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3 ml-0">
                        <form method="GET" action="{{route('searchComments')}}">
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
                                <th style="width: 20%;">Name</th>
                                <th>Content</th>
                                <th>Comment parent</th>
                                <th>Status</th>
                                <th style="width: 15%;">Created at</th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    <input type="checkbox" id="vehicle1" name="check[]" form="bulkActions" value="{{$comment->id}}" @if (Auth::User()->role!==2) disabled @endif>
                                </td>
                                <td>
                                    {!!$comment->users->name!!}
                                    <p><small>{!!"(".$comment->users->email.")"!!}</small></p>
                                </td>
                                <td>{!!$comment->comment_content!!}</td>
                                <td>
                                    @foreach ($allComments as $item)
                                        @if ($comment->comment_parent == $item->id)
                                            {!!$item->id." - ".Str::substr($item->comment_content, 0, 40)!!}
                                        @endif

                                    @endforeach
                                </td>
                                <td>
                                    @if($comment->comment_status ==1)
                                        <p class='badge badge-success'>active</p>
                                    @else
                                        <p class='badge badge-danger'>Deactive</p>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at}}</td>
                                <td>
                                    <a href="{{ route('deleteComment',['id'=>$comment->id]) }}" class="btn btn-white btn-edit"
                                        @if (Auth::User()->role==2)
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
                        {{ $comments->links() }}
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
        </div>
    </div>
</div>
@endsection

