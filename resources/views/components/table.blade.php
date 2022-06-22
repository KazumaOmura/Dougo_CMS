<h2>{{ $title }}</h2>
<table class="table">
    <tr>
        @foreach ($index as $hoge)
            <th scope="col">{{ $hoge }}</th>
        @endforeach
        @if ($edit_flag || $detail_flag)
            <th scope="col">操作</th>
        @endif
    </tr>
        @foreach ($values as $value)
            <tr>
            @foreach ($columns as $column)
                <td>{{ $value->{$column} }}</td>
            @endforeach
            @if($edit_flag)
                <td><a href="/{{ $repository_name_snake }}/edit/{{ $value->id }}" class="btn btn-primary">編集</a></td>
            @endif
            @if($detail_flag)
                <td><a href="/{{ $repository_name_snake }}/detail/{{ $value->id }}" class="btn btn-success">詳細</a></td>
            @endif
            </tr>
        @endforeach
</table>
