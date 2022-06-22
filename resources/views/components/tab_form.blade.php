<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button
            class="nav-link active"
            id="home-tab"
            data-bs-toggle="tab"
            data-bs-target="#home"
            type="button"
            role="tab"
            aria-controls="home"
            aria-selected="true"
        >
            閲覧
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button
            class="nav-link"
            id="profile-tab"
            data-bs-toggle="tab"
            data-bs-target="#profile"
            type="button"
            role="tab"
            aria-controls="profile"
            aria-selected="false"
        >
            編集
        </button>
    </li>
</ul>

{{--閲覧エリア--}}
<div class="tab-content" id="myTabContent">
    <div
        class="tab-pane fade show active"
        id="home"
        role="tabpanel"
        aria-labelledby="home-tab"
    >
        <div class="d-flex flex-wrap">
            @foreach ($columns as $column)
                <div class="list-group-item p-3 d-flex gap-2"><p class="m-0 label">{{ $column }}</p><p class="m-0">{{ $values->{ $column } }}</p></div>
            @endforeach
        </div>
    </div>
    <div
        class="tab-pane fade"
        id="profile"
        role="tabpanel"
        aria-labelledby="profile-tab"
    >

{{--        編集エリア--}}
        <form method="POST" action="update" accept-charset="UTF-8">
            @csrf
        @foreach ($columns as $column)
        <div class="mb-2 row">
            <label for="staticEmail" class="col-sm-1 col-form-label">{{ $column }}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="{{ $column }}" value="{{ $values->{ $column } }}" />
            </div>
        </div>
        @endforeach
            <input type="hidden" name="reponame" value="{{ $repository_name }}">
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
</div>
