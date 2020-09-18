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



    </h1>
    {{-- 即時 --}}
    <div>


        <div align="center">

            <h3>
                <div> {{ $data[0]->Wx }} <br>

                    <a><img src="image/weather/{{ (int) $data[0]->WxV }}.svg" width="200" height="200"></a>
            </h3>




            <h3> {{ $data[0]->MinT }} / {{ $data[0]->MaxT }} °C<br>

                降雨機率 {{ $data[0]->PoP }}%
            </h3>
        </div>
    </div>
    </div>
    </div>



    {{-- 明後天 --}}

    <h3>明後天天氣預報</h3>

    <div id="boxa" align="center">
        @foreach ($data2 as $item2)
            <div>
                <div style="background-color:#003D79 ">

                    @php
                    //建立一個陣列去轉換星期
                    $week = array("日", "一", "二", "三", "四", "五", "六");
                    //用空格分割startTime
                    list($date) = explode(" ", $item2->startTime);
                    //用底線分割date
                    list($Y, $M, $D) = explode("-", $date);
                    @endphp

                    <font color="white">@php echo $item2->startTime. " 星期" .$week[date("w", mktime(0, 0, 0, $M, $D,
                        $Y))]; @endphp
                    </font>
                </div>
                <div style="background-color:#D2E9FF; "> {{ $item2->Wx }}<br>
                    <a><img src="image/weather/{{ (int) $item2->WxV }}.svg" width="100" height="100"></a>
                    @php echo "<br>" . "溫度" . $item2->T . "°C<br>"; @endphp
                    {{ $item2->PoP }}
                </div>
                <div style="background-color:#ACD6FF; ">


                    {{ $item2->Wx }}<br>
                    <a><img src="image/weather/{{ (int) $item2->WxV }}.svg" width="100" height="100"></a>
                    @php echo "<br>" . "溫度" . $item2->T . "°C<br>"; @endphp
                    {{ $item2->PoP }}
                    <div style="background-color:#46A3FF; ">
                        <font color="white">
                            <td> {{ $item2->WD }}<br></td>
                            <td> {{ $item2->WS }}公尺/秒<br></td>
                        </font>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- 一週 --}}

    <h3>一週天氣預報</h3>
    <div id="box" align="center">
        @php $day='morning'; @endphp
        @foreach ($data3 as $item3)

            @if ($day == 'morning')
                <div>
                    <div style="background-color:#003D79 ">
                        @php
                        //建立一個陣列去轉換星期
                        $week = array("日", "一", "二", "三", "四", "五", "六");
                        //用空格分割startTime
                        list($date) = explode(" ", $item3->startTime);
                        //用底線分割date
                        list($Y, $M, $D) = explode("-", $date);
                        @endphp
                        <font color="white">@php echo $item3->startTime . " 星期" . $week[date("w", mktime(0, 0, 0, $M,
                            $D,
                            $Y))]; @endphp
                        </font>
                    </div>
                    <div style="background-color:#D2E9FF; "> {{ $item3->Wx }}<br>

                        <a><img src="image/weather/{{ (int) $item3->WxV }}.svg" width="60" height="60"></a>

                        @php echo "<br>" . "溫度" . $item3->MinT . "~" . $item3->MaxT ."°C<br>";

                        $MaxAT = $item3->MaxAT;
                        $day='night';
                        @endphp </div>
                    @php $day=='night' @endphp
                    @continue


                @else
                    <div style="background-color:#ACD6FF; ">

                        {{ $item3->Wx }}<br>
                        <a><img src="image/weather/{{ (int) $item3->WxV }}.svg" width="60" height="60"></a>
                        @php echo "<br>" . "溫度" . $item3->MinT . "~" . $item3->MaxT ."°C<br>";@endphp
                        <div style="background-color:#D2E9FF; ">
                            @php $MinAT = $item3->MinAT ; @endphp
                            @php echo "體感溫度 " . $MinAT . "~" . $MaxAT . "°C" @endphp</div>
                        <div style="background-color:#46A3FF; ">
                            <font color="white">
                                <td> {{ $item2->WD }}<br></td>
                                <td> {{ $item2->WS }}公尺/秒<br></td>
                            </font>
                        </div>
                    </div>
                </div>
                @php $day='morning' @endphp
                @continue
            @endif


        @endforeach
    </div>
    </form>

</body>

</html>
