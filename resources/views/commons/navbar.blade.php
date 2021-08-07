<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="/">Task Management</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if(Auth::check())
                    <li>{!! link_to_route('members_schedule', 'メンバースケジュール', [], ['class'=>'nav-link']) !!}</li>
                    <li>{!! link_to_route('logout.get', 'ログアウト', [], ['class'=>'nav-link']) !!}</li>
                @else
                    <li>{!! link_to_route('signup.get', 'ユーザー登録', [], ['class'=>'nav-link']) !!}</li>
                    <li>{!! link_to_route('login', 'ログイン', [], ['class'=>'nav-link']) !!}</li>
                @endif
            </ul>
        </div>
    </nav>
</header>