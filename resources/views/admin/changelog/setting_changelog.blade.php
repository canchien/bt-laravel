@section('title')
    Setting changelog
@endsection
@extends('admin.layout.index')
@section('content')
<div class="main-content">
    <div class="row justify-content-lg-center">
                    <div class="col-lg-8 col-md-12 mt-5">
                        @if (session('message'))
                        <div class="alert alert-success">
                                {{session('message')}}
                        </div>
                        @endif
                        <div id="addUserProfile" class="card card-lg">
                        <!-- Body -->
                        <form action="{{route('update_setting_changelog')}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="card-header">
                                <h3>Setting changelog</h3>
                            </div>
                            <div class="card-body">
                                <!-- status -->
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label input-label">Access type</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-md-down-break">
                                                <div class="form-control">
                                                    <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="status" id="public" value="public" @if($changelog->status=="public") checked @endif>

                                                    <label class="custom-control-label" for="public">Public</label>
                                                    </div>
                                                </div>

                                                <div class="form-control">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="status" id="verified" value="verified" @if($changelog->status=="verified") checked @endif>

                                                        <label class="custom-control-label" for="verified">Verified</label>
                                                    </div>
                                                </div>
                                                <div class="form-control">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" name="status" id="private" value="private" @if($changelog->status=="private") checked @endif>
                                                        <label class="custom-control-label" for="private">Private</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div>This is privacy level to entire changelog. You always can tighten security for particular post.</div>
                            </div>

                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary"> Update </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
</div>
@endsection

