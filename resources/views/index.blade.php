<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" media="all" href="{{ asset('css/bootstrap.css') }}">

    <title>イイさむねいる CMS</title>
</head>

<body>
    @include('layouts.header')
    @if(session('message'))
    <div class="alert alert-{{session('type')}}">{{session('message')}}</div>
    @endif
    <main class="container-xxl">
        <div class="d-flex flex-row">
            <div>
                <h3>ユーザ関連</h3>
                <ul class="list-group list-group-flush" style="max-width: 400px;">
                    <li class="list-group-item"><a href="/admin_users">管理者ユーザー一覧</a></li>
                </ul>
            </div>
        </div>
    </main>

</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>

</html>