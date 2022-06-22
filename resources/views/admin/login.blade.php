<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" media="all" href="{{ asset('css/bootstrap.css') }}">

    <title>DOUGO CMS</title>
</head>

<body>
    @include('layouts.login_header')
    @if(session('message'))
    <div class="alert alert-{{session('type')}}">{{session('message')}}</div>
@endif
    <main class="container-xxl">
        <h3>ログイン</h3>
        <form method="POST" action="login" accept-charset="UTF-8">
            @csrf
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example1">メールアドレス</label>
                <input type="email" name="email" id="form2Example1" class="form-control" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">パスワード</label>
                <input type="password" name="password" id="form2Example2" class="form-control" />
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">ログイン</button>
        </form>

    </main>

</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>

</html>