<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="description" content="simple_blog" />
        <title>blog_view</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    </head>
    
    <body style="background-color:#fffafa">
        <h1>blog</h1>
        <p>this is a sample blog</p>
        
        <div class = "contains">
            
            <a href="posts/create">新規作成</a>
            <table class = "table table-bordered">
                <tr>
                    <td class = "text-center">title</td>
                    <td class = "text-center">contents</td>
                    <td class = "text-center">task</td>
                </tr>
                
                @foreach($datas as $data)
                    <tr>
                        <th><a href="/posts/{{ $data->id}}">{{ $data->title }}</a></th>
                        <th><a href="/posts/{{ $data->id}}">{{ $data->body }}</a></th>
                        <th><a href="/posts/{{ $data->id}}/edit">edit</a></th>
                    </tr>
                @endforeach
                <div class = 'pagenate'>
                    {{ $datas -> links()}}
                </div>
            </table>
        </div>
        
       
    </body>
    
</html>
