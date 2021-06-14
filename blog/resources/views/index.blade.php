<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="description" content="simple_blog" />

        <title>blog_view</title>
    </head>
    
    <body>
        <h1>blog</h1>
        <p>this is a sample blog</p>
        <table border="1" style="border-collapse: collapse">
            <tr>
                <td>title</td>
                <td>contents</td>
            </tr>
            
            @foreach($datas as $data)
                <tr>
                    <th>{{ $data->title }}</th>
                    <th>{{ $data->body }}</th>
                </tr>
            @endforeach
        </table>
        
       
    </body>
    
</html>
