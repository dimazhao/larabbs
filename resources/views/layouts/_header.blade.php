<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand" href=" '/') }}">
            LaraBBS
        </a >

        <!-- 移动端折叠按钮 -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 导航栏折叠内容 -->
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <!-- 左侧导航（示例：可添加菜单） -->
            <ul class="navbar-nav">
                <!-- 这里可添加左侧导航项，如 <li class="nav-item"><a class="nav-link" href="#">首页</a ></li> -->
            </ul>

            <!-- 右侧导航（认证链接） -->
            <ul class="navbar-nav ms-auto"> <!-- ms-auto 实现右对齐 -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">登录</a >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">注册</a >
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           id="navbarDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <img src="https://img2.woyaogexing.com/2025/04/21/b3d8a772ff7b255e3cb3cda9edbbe3d0.jpg"
                                 class="img-fluid img-circle"
                                 width="30"
                                 height="30">
                            {{ Auth::user()->name }}
                        </a >
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">个人中心</a ></li>
                            <li><a class="dropdown-item" href="#">编辑资料</a ></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-block btn-danger w-100" type="submit">退出</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
