<h2>{{ $title }}</h2>
<table class="table">
    <tr>
        @foreach ($index as $hoge)
            <th scope="col">{{ $hoge }}</th>
        @endforeach
        <th scope="col">操作</th>
    </tr>
        @foreach ($values as $value)
            <tr>
            @foreach ($columns as $column)
                <td>{{ $value->{$column} }}</td>
            @endforeach
                <td><a href="/{{ $repository_name_snake }}/{{ $value->id }}" class="btn btn-primary">編集</a></td>
            </tr>
        @endforeach
</table>
