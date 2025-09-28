@extends('layouts.app')
@section('title', $user->name.'个人中心')
@section('content')

    <div class="row">
       <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
           <div class="card">
                <img class="card-img-top"
                src="https://img2.woyaogexing.com/2025/04/21/b3d8a772ff7b255e3cb3cda9edbbe3d0.jpg"
                alt="{{ $user->name }}">
                <div class="card-body">
                    <h5><strong>个人简介</strong></h5>
                    <p>暂无简介</p>
                    <hr>
                    <h5><strong>注册于</strong></h5>
                    <p>{{ $user->created_at->diffForHumans() }}</p>

                </div>
           </div>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
           <div class="card">
               <div class="card-body">
                <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email}}</small></h1>
               </div>
            </div>
            <hr>

            <div class="card">
                <div class="card-body">
                    这里是用户个人中心
                </div>
            </div>
        </div>
    </div>


@stop
