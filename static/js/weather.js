$(function () {
  $.ajax({
    type: "GET",
    url: "/weather",
    data: {},
    dataType: "json",
    success: function(data){
      //console.log(data);
      //let ret = ("("+data+")");
      var weather = data.weathers;
      //console.log(weather);
      if (weather) {
        let aa = '';
        for (var k in weather) {
          aa += '<li class="scrolltext-title"><a href="javascript:;" rel="bookmark" style="color:#777;font-size:13px;">'+data.cityName +' '+ weather[k].ymd + ' '+ weather[k].week+ ' ' + weather[k].type+ ' '+ weather[k].low + '~'+ weather[k].high+ '</a></li>';
        }
        $('#myWeather').html(aa);
      }
    }
  });
});