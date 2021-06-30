@extends('layouts.standard')

@section('contains')    
        <h1>blog</h1>
        <p>this is a sample blog</p>
        
        <div class = "contains">
            
            <a href="/posts/create">新規作成</a>
            <table class = "table table-bordered">
                <tr>
                    <td class = "text-center">title</td>
                    <td class = "text-center">contents</td>
                    <td class = "text-center">task</td>
                    <td class = "text-center">task</td>
                   
                </tr>
                
                @foreach($datas as $data)
                    <tr>
                        <th><a href="/posts/{{ $data->id}}">{{ $data->title }}</a></th>
                        <th><a href="/posts/{{ $data->id}}">{{ $data->body }}</a></th>
                        <th><a href="/posts/{{ $data->id }}/edit" class="btn btn-primary btn-sm">edit</a></th>
                        <th><form action="/posts/delete/{{$data->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="削除" class="btn btn-danger btn-sm btn-dell" onclick="return confirm('削除しますか？')">
                            </form>
                        </th>
                    </tr>
                @endforeach
                <div class = 'pagenate'>
                    {{ $datas -> links()}}
                </div>
            </table>
        </div>
        
@endsection
 