@section('title')
    Update Roadmaps
@endsection
@extends('admin.layout.index')
@section('content')
    <div class="main-content">
        <div class="row justify-content-lg-center">
                        <div class="col-lg-12 mt-5">
                            @if (session('message'))
                            <div class="alert alert-success">
                                    {{session('message')}}
                                    <a href="{{route('listRoadmaps')}}">Quay lại list road maps</a>
                            </div>
                            @endif
                            <div id="addUserProfile" class="card card-lg">
                            <!-- Body -->
                            <form action="{{ route('postEditRoadmaps')}}" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="id" value="{{$roadmaps->id}}">
                                <div class="card-header">
                                    <h3>Update roadmaps</h3>
                                </div>
                                <div class="card-body">
                                    <!-- title  -->
                                    <div class="row form-group">
                                        <label for="titleLabel" class="col-sm-2 col-form-label input-label">Title
                                        </label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="title" id="titleLabel" required placeholder="title" value="{{$roadmaps->title}}">
                                            </div>
                                            @error('title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- summary -->
                                    <div class="row form-group">
                                        <label for="summary" class="col-sm-2 col-form-label input-label">Summary
                                        </label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <textarea class="form-control" name="summary" id="summary" rows="5">{{$roadmaps->summary}}</textarea>
                                            </div>
                                            @error('summary')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <!-- statuses  -->
                                        <div class="row form-group">
                                            <label for="categories" class="col-sm-2 col-form-label input-label">Statuses</label>
                                            <div class="col-sm-10">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a class="card-link" data-toggle="collapse" href="#collapseStatus">
                                                            click here to show option status
                                                        </a>
                                                    </div>
                                                    <div id="collapseStatus" class="collapse show" data-parent="#accordion">
                                                        <div class="card-body">
                                                            @foreach ($status as $category)
                                                                <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input" id="statusCheck{{$category->id}}" name="statuses[]" value="{{$category->id}}"
                                                                    @foreach ($roadmaps->categories as $item)
                                                                        @if ($item->id == $category->id)
                                                                            checked
                                                                        @endif
                                                                    @endforeach>
                                                                    <label class="custom-control-label" for="statusCheck{{$category->id}}">{{$category->name}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                            @error('statuses')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                        <!-- thể loại  -->
                                        <div class="row form-group">
                                            <label for="categories" class="col-sm-2 col-form-label input-label">Categories</label>
                                            <div class="col-sm-10">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a class="card-link" data-toggle="collapse" href="#collapseCategories">
                                                            click here to show option categories
                                                        </a>
                                                    </div>
                                                    <div id="collapseCategories" class="collapse" data-parent="#accordion">
                                                        <div class="card-body">
                                                            @foreach ($categories as $category)
                                                                @if ($category->parent != 99)
                                                                <div class="custom-control custom-checkbox mb-3">
                                                                    <input type="checkbox" class="custom-control-input" id="boards{{$category->id}}" name="boards[]" value="{{$category->id}}"
                                                                        @foreach ($roadmaps->categories as $item)
                                                                        @if ($item->id == $category->id)
                                                                            checked
                                                                        @endif
                                                                    @endforeach>
                                                                    <label class="custom-control-label" for="boards{{$category->id}}">{{$category->name}}</label>
                                                                </div>
                                                                @endif

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- author  -->
                                    <input type="hidden" class="form-control" name="author" id="authorLabel" value="" >

                                    <!-- access type -->

                                    <div class="row form-group">
                                        <label class="col-sm-2 col-form-label input-label">Status</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-md-down-break">
                                                <div class="form-control">
                                                    <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="status" id="public" value="public" @if($roadmaps->status=="public") checked @endif>

                                                    <label class="custom-control-label" for="public">Public</label>
                                                    </div>
                                                </div>

                                                <div class="form-control">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="status" id="verified" value="verified" @if($roadmaps->status=="verified") checked @endif>

                                                        <label class="custom-control-label" for="verified">Verified</label>
                                                    </div>
                                                </div>
                                                <div class="form-control">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="status" id="private" value="private" @if($roadmaps->status=="private") checked @endif>

                                                        <label class="custom-control-label" for="private">Private</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <small>User access to this boards.</small>
                                            @error('status')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- showonpage --}}
                                    <div class="row form-group">
                                        <label class="col-sm-2 col-form-label input-label"></label>
                                        <div class="col-sm-10">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="showon" name="showon" @if($roadmaps->show==1) checked @endif>
                                                <label class="custom-control-label" for="showon">Show on homepage</label>
                                                <p><small>Show link to this board on homepage.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary" name="submit"> Update </button>
                                </div>
                            </form>


                            </div>
                        </div>
                    </div>
    </div>
@endsection
