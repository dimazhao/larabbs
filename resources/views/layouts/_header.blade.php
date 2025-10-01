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
              <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
              <li class="nav-item"><a class="nav-link {{ active_class(if_route('topics.index')) }}" href="{{ route('topics.index') }}">话题</a></li>
              <li class="nav-item"><a class="nav-link {{ category_nav_active(1) }}" href="{{ route('categories.show', 1) }}">分享</a></li>
              <li class="nav-item"><a class="nav-link {{ category_nav_active(2) }}" href="{{ route('categories.show', 2) }}">教程</a></li>
              <li class="nav-item"><a class="nav-link {{ category_nav_active(3) }}" href="{{ route('categories.show', 3) }}">问答</a></li>
              <li class="nav-item"><a class="nav-link {{ category_nav_active(4) }}" href="{{ route('categories.show', 4) }}">公告</a></li>
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
                           <!-- Authentication Links -->


                       <li class="nav-item">
            <a class="nav-link mt-1 mr-3 font-weight-bold" href="{{ route('topics.create') }}">
              <i class="fa-solid fa-plus"></i>➕
            </a>
          </li>


          <li class="nav-item notification-badge">
            <a class="nav-link ms-3 me-3 badge bg-secondary rounded-pill badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white" href="{{ route('notifications.index') }}">
              {{ Auth::user()->notification_count }}
            </a>
          </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           id="navbarDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px" alt="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}
                        </a >

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">个人中心</a ></li>
                            <li><a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">编辑资料</a ></li>
                           <div class="dropdown-divider"></div>
                              <a class="dropdown-item" id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('您确定要退出吗？');">
                                  {{ csrf_field() }}
                                  <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                </form>
                              </a>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
