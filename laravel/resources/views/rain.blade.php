<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/grid.css') }}">
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


    <div id="boxb">
        <h2>

            {{ $locationName }}雨量報告<br>

            <a><img src="image/country/{{$locationName}}.jpg" width="480" height="270"></a>
        </h2>
    </div>
    <div id="boxa">

        @foreach ($data5 as $item5)

            <div>
                <div style="background-color:#003D79 " align="center">
                    <font color="white">
                        觀測站 : {{ $item5->townName }}<br>

                    </font>
                </div>
                <div style="background-color:#D2E9FF; ">
                    站址 : {{ $item5->townName }} {{ $item5->town }}<br>

                    隸屬 : {{ $item5->attribute }}<br>
                    @php
                    if ($item5->oneHour >= 0) {

                    echo '過去1小時累積雨量 : ' . $item5->oneHour . "<br>";
                    } else {
                    echo '過去1小時累積雨量 : 無檢測紀錄' . "<br>";
                    }

                    if ( $item5->oneDay >= 0) {

                    echo '過去24小時累積雨量 : ' . $item5->oneDay . "<br>";
                    } else {
                    echo '過去24小時累積雨量 : 無檢測紀錄' . "<br>";
                    }
                    @endphp
                </div>
            </div>
        @endforeach
</body>

</html>
