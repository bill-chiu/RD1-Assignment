<form id="form1" name="form1" method="post" action="weather">
    <div class="form-group row">
        <div class="col-8">
            <select id="locationName" name="locationName" class="custom-select col-4 " required="required">
                <option value="基隆市">基隆市</option>
                <option value="臺北市">臺北市</option>
                <option value="新北市">新北市</option>
                <option value="宜蘭縣">宜蘭縣</option>
                <option value="桃園市">桃園市</option>
                <option value="新竹縣">新竹縣</option>
                <option value="新竹市">新竹市</option>
                <option value="苗栗縣">苗栗縣</option>
                <option value="臺中市">臺中市</option>
                <option value="彰化縣">彰化縣</option>
                <option value="南投縣">南投縣</option>
                <option value="雲林縣">雲林縣</option>
                <option value="嘉義縣">嘉義縣</option>
                <option value="嘉義市">嘉義市</option>
                <option value="臺南市">臺南市</option>
                <option value="高雄市">高雄市</option>
                <option value="屏東縣">屏東縣</option>
                <option value="臺東縣">臺東縣</option>
                <option value="花蓮縣">花蓮縣</option>
                <option value="澎湖縣">澎湖縣</option>
                <option value="金門縣">金門縣</option>
                <option value="連江縣">連江縣</option>
            </select>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            {{ Form::submit('查詢天氣', ['class' => 'btn btn-info', 'name' => 'submitbutton']) }}
            {{ Form::submit('查詢雨量', ['class' => 'btn btn-success', 'name' => 'submitbutton']) }}
        </div>
    </div>
