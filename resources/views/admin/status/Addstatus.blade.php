@section('title')
    Add Status
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row justify-content-lg-center">
                    <div class="col-lg-8 col-md-12 mt-5">

                        @if (session('message'))
                        <div class="alert alert-success">
                                {{session('message')}}
                                <a href="{{route('listStatus')}}">Quay lại list status</a>
                        </div>
                        @endif
                        <div id="addUserProfile" class="card card-lg">
                        <!-- Body -->
                        <form action="{{route('postAddStatus')}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="card-header">
                                <h3>Add new status</h3>
                            </div>
                            <div class="card-body">
                                <!-- name  -->
                                <div class="row form-group mt-4">
                                    <label for="fullNameLabel" class="col-sm-2 col-form-label input-label">Name
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name" id="fullNameLabel" required placeholder="name status" >
                                        </div>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- color --}}
                                <div class="form-group row">
                                    <label for="example-color-input" class="col-2 col-form-label">Color</label>
                                    <div class="col-10">
                                      <input class="form-control" type="color" value="#563d7c" id="example-color-input" name="color">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary"> Create </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
</div>
@endsection

