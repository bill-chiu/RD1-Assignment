
    <form id="form1" name="form1" method="post">
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
                <button name="btnOK" type="btnOK" class="btn btn-primary">查詢天氣</button>
                <button name="btnRain" type="btnRain" class="btn btn-primary">查詢雨量</button>
            </div>
        </div>
        <div id="boxb">
            <h2>
         
                    @php  echo  "天氣報告<br>"; @endphp

                <a><img src="image/country/@php echo '基隆市' @endphp.jpg" width="480" height="270"></a>
            </h2>

        </form>