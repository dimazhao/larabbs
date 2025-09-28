@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5>
                    <i class="glyphicon glyphicon-edit"></i>
                    编辑资料
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8">
                   <input type="hidden" name="_method" value="PUT">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @include('shared._error')
                    <div class="mb-3">
                        <label for="name-field" class="form-label">用户名</label>
                        <input class="form-control" name="name" type="text" id="name-field" value="{{ old('name', $user->name) }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="email-field">邮箱</label>
                        <input class="form-control" name="email" type="text" id="email-field" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="mb-3">
                        <label for="introduction-field">个人简介</label>
                        <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
