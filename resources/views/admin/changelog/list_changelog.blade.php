@section('title')
    List Posts
@endsection

@extends('admin.layout.index')

@section('content')
    <div class="main-content px-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-title py-4 mb-5">
                    <div class="row align-items-end">
                        <div class="col-sm mb-2 mb-sm-0">

                            <h3 class="page-title">List Post</h3>
                        </div>

                        <div class="col-sm-auto">
                            <a class="btn btn-addPost" href="{{ route('changelog.get_add_posts')}}">
                                <i class="fas fa-user-plus"></i> Add new changelog
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
                            <form action="{{route('changelog.bulkAction_posts')}}" id="bulkActions" class="d-flex"method="POST">
                                @csrf
                                <div class="form-group">
                                        <select class="form-control" name="select" id="actions">
                                            <option value="none">Bulk Actions</option>
                                            <option value="public" <?php if(isset($_POST['ftStatus']) && $_POST['ftStatus']=='public'){ echo 'selected';}?>>Public</option>
                                            <option value="verified" <?php if(isset($_POST['ftStatus']) && $_POST['ftStatus']=='verified'){ echo 'selected';}?>>Verified</option>
                                            <option value="private" <?php if(isset($_POST['ftStatus']) && $_POST['ftStatus']=='private'){ echo 'selected';}?>>Private</option>
                                            <option value="delete" <?php if(isset($_POST['ftStatus']) && $_POST['ftStatus']=='delete'){ echo 'selected';}?>>Delete</option>
                                        </select>
                                </div>
                                <button id="buttonActions" class="btn btn-post-apply mx-2" type="submit" name="submit" style="height: calc(1.5em + .75rem + 2px);"> Apply</button>
                            </form>
                            <form action="{{route('changelog.limit_posts')}}" method="GET" class="d-flex">
                                <div class="form-group mb-0 mr-2">
                                    <select class="form-control " id="sel1" name="showData" onchange="this.form.submit()">
                                        <option value="10" @if (session()->has('limit')&& session('limit')==10) {{'selected'}}@endif>10</option>
                                        <option value="20" @if (session()->has('limit')&& session('limit')==20) {{'selected'}}@endif>20</option>
                                        <option value="50" @if (session()->has('limit')&& session('limit')==50) {{'selected'}}@endif>50</option>
                                    </select>
                                </div>
                            </form>
                            <form action="{{route('changelog.sort_posts')}}" method="GET" >
                                <div class="form-group mr-2">
                                    <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
                                        <option value="">Any sort</option>
                                        <option value="asc" @if (session()->has('sort')&& session('sort')=="asc") {{'selected'}}@endif>Name A-Z</option>
                                        <option value="desc" @if (session()->has('sort')&& session('sort')=="desc") {{'selected'}}@endif>Name Z-A</option>
                                    </select>
                                </div>
                            </form>
                            <form action="{{route('changelog.status_posts')}}" class="d-flex" method="GET">
                                <div class="form-group">
                                    <select class="form-control" id="sel1" name="status" onchange="this.form.submit()">
                                        <option value="">Any Status</option>
                                        <option value="public" @if (session()->has('status')&& session('status')=="public") {{'selected'}}@endif>public</option>
                                        <option value="verified" @if (session()->has('status')&& session('status')=="verified") {{'selected'}}@endif>verified</option>
                                        <option value="private" @if (session()->has('status')&& session('status')=="private") {{'selected'}}@endif>private</option>
                                    </select>
                                </div>
                             </form>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-3">
                            <form method="GET" action="{{route('changelog.search_posts')}}">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="search" class="form-control" name="search" placeholder="Search Posts" value="">
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
                                    <th style="width: 30%;">title</th>
                                    <th>image</th>
                                    <th >author</th>
                                    <th>status</th>
                                    <th >created at</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($changelog as $post)
                                <tr>
                                    <td>
                                        <input type="checkbox" id="{{$post->id}}" name="check[]" form="bulkActions" value="{{$post->id}}"
                                        @if (Auth::User()->id==$post->author || Auth::User()->role==2)
                                        @else
                                            disabled
                                        @endif>
                                    </td>

                                    <td>
                                        <a href="{{ route('changelog.get_edit_posts',['id'=>$post->id]) }}" class="title-info"
                                            @if (Auth::User()->id==$post->author || Auth::User()->role==2)
                                            @else
                                                onclick="return errorRole()"
                                                style="background-color: rgb(179, 179, 179)"
                                            @endif>{{$post->title}}</a>
                                    </td>
                                    <td>
                                        <div class="">
                                            <img class="imagePost" src=@if(!$post->postmeta->isEmpty())
                                                @foreach ($post->postmeta as $postmeta)
                                                    @if($postmeta->meta_key== "meta_image" && $postmeta->meta_value !== null)
                                                        {!!asset('admin_asset/image/upload/'.$postmeta->meta_value)!!}
                                                    @else
                                                        {{asset('admin_asset/image/upload/defaultimage.jpg')}}
                                                    @endif
                                                @endforeach
                                            @else
                                                {{asset('admin_asset/image/upload/defaultimage.jpg')}}
                                            @endif
                                                alt="avatar">
                                        </div>
                                    </td>
                                    <td>
                                        @if ($post->users->role=2)
                                            {!!"Supper admin"!!}

                                        @else
                                            {!!"Admin"!!}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($post->status =="public")
                                            <span class="badge badge-primary">{{$post->status}}</span>
                                        @elseif($post->status =="private")
                                            <span class="badge badge-secondary">{{$post->status}}</span>
                                        @else
                                            <span class="badge badge-dark">{{$post->status}}</span>
                                        @endif
                                    </td>
                                    <td>{{$post->created_at}}</td>
                                    <td>
                                        <a href="{{ route('changelog.get_edit_posts',['id'=>$post->id]) }}" class="btn btn-white btn-edit"
                                            @if (Auth::User()->id==$post->author || Auth::User()->role==2)
                                            @else
                                                onclick="return errorRole()"
                                                style="background-color: rgb(179, 179, 179)"
                                            @endif
                                        ><i class="fas fa-pen"></i> Edit</a>
                                        <a href="{{ route('changelog.delete_posts',['id'=>$post->id]) }}"  class="btn btn-white btn-edit"
                                            @if (Auth::User()->id==$post->author || Auth::User()->role==2)
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
                            {{ $changelog->links() }}

                        </div>
                    </div>
                    <!-- End Pagination -->
                </div>
            </div>
        </div>
    </div>
@endsection
