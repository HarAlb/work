<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="keywords" content="Laravel Test for starting work "/>
        <meta name="description" content="This is a test app for working "/>

        <title>Test Cut Url</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body>
        <div class="position-absolute d-flex flex-column absolute-center">
            <form class="form-inline" id="formUrl" action="{{ route('create')  }}" method="post">
                @csrf
                @if($errors->has('url'))
                    <div class="alert alert-danger" role="alert">
                        {{$errors->first('url')}}
                    </div>
                @endif
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" class="form-control" value="{{old('url')}}" name="url" id="inputPassword2" placeholder="Url with http or https">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Url cut</button>

              </form>
              @if(!empty($websites))
                <div class="d-flex flex-column">
                    <ul class="list-group">
                        @foreach ($websites as $item)
                            <li class="list-group-item">
                                <a href="{{$item['full_url']}}" target="_blank">{{$item['title']}}</a>
                                <h3>Generated</h3>
                                <a href="{{$item['generated_url']}}">{{$item['generated_url']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
              @endif
        </div>
        <script type="application/javascript" src="{{mix('js/app.js')}}" charset="UTF-8"></script>
    </body>
</html>
