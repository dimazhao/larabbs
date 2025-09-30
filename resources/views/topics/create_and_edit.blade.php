@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2 class="">
            <i class="far fa-edit"></i>
            @if ($topic->id)
              编辑话题
            @else
              新建话题
            @endif
          </h2>

          <hr>

          @if ($topic->id)
            <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
            @else
              <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
          @endif

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          @include('shared._error')

          <div class="mb-3">
            <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title) }}"
              placeholder="请填写标题" required />
          </div>

        <div class="mb-3">
                <select class="form-control" name="category_id" required>
                  <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
                    @foreach ($categories as $value)
                      <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }}>
                        {{ $value->name }}
                      </option>
                    @endforeach
                </select>
              </div>

          <div class="mb-3">
    <textarea
        name="body"
        class="form-control"
        id="editor"
        rows="6"
        placeholder="请填入至少三个字符的内容。"
        required
    >
        {{-- 关键修改：1. 用 ?? 处理 $topic 为空；2. 确保无多余空格 --}}
        {{ old('body', $topic->body ?? '') }}
    </textarea>
</div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('styles')
  {{-- Simditor 样式，保留 --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
  {{-- Simditor 依赖 JS，保留 --}}
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

  {{-- 合并并修复 Simditor 初始化代码：添加 initialValue 配置 --}}
  <script>
    $(document).ready(function() {
      // 1. 获取原文章内容（兼容验证失败的 old 值 + $topic 为空的情况）
      var originalContent = {!! json_encode(old('body', $topic->body ?? '')) !!};

      // 2. 初始化 Simditor（合并原有的2个初始化，保留上传配置）
      var editor = new Simditor({
        textarea: $('#editor'), // 绑定文本域
        initialValue: originalContent, // 关键：传入原内容，解决“不显示原来文章”问题
        upload: { // 保留原有的上传配置
          url: '{{ route('topics.upload_image') }}',
          params: {
            _token: '{{ csrf_token() }}'
          },
          fileKey: 'upload_file',
          connectionCount: 3,
          leaveConfirm: '文件上传中，关闭此页面将取消上传。'
        },
        pasteImage: true // 保留粘贴图片功能
      });
    });
  </script>
@stop
