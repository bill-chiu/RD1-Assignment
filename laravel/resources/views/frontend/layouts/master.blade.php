<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/grid.css')}}">
</head>

<style>

</style>

<body style="background-color:#ECFFFF	; ">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


   
  
    @include('frontend.layouts.header')
    @include('frontend.layouts.navbar')



    </h1>

    <div>

       
        <div align="center">

            <h3>
                <div>  {{$data[0]->Wx}} <br>

                    <a><img src="image/weather/{{$data[0]->WxV}}.svg" width="200" height="200"></a>
            </h3>


            <h3>   {{$data[0]->MinT}}  /  {{$data[0]->MaxT}}  °C<br>

              降雨機率  {{$data[0]->PoP}}%
            </h3>
        </div>
    </div>
</div>
</div>






    
    @yield('content')
    @include('frontend.layouts.footer')
           
      

</body>

</html>