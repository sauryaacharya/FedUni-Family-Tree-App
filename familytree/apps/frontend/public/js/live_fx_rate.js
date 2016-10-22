$(document).ready(function(){
    $("#currency_amt").keydown(function(e){
        var value = String.fromCharCode(e.keyCode);
        if(isNaN(value) && e.keyCode != 8 && e.keyCode != 190)
        {
            return false;
        }
        return true;
    });
    
    $("#convert_btn").click(function(){
       var currency_from = $("#country_currency_from").val();
       var currency_to = $("#country_currency_to").val();
       var pair = currency_from+currency_to;
       var amount = $("#currency_amt").val();
       
       if(amount === "" || isNaN(amount))
       {
           $(".convert_result").html("<span style='font-family:Arial;color:#e60000;font-size:13px;'>Enter the amount to convert.</span>");
       }
       else
       {
       convertCurrency(pair, amount, currency_from, currency_to);   
       }
    });
    getRate();
    setInterval(getRate, 3300);
});

var is_request_first = true;
function getRate()
{
    $.ajax({
        type: "POST",
        url: "http://localhost/fortunefx/ajaxservice/getLiveFxRate/limit",
        cache: false,
        beforeSend: function(){
            var loader_html = "<img src='http://localhost/fortunefx/apps/frontend/public/images/ajax_loader.gif' alt='Loading' style='vertical-align:middle;'/><br/><span style='font-family:Arial;font-size:13px;color:#4d4d4d;'>Loading Currency Rate</span>";
            $("#ajax_loader1").html(loader_html);
        },
        success: function(data)
        {
            is_request_first = false;
            var rate_arr = data;
            $("#rate_tbl").html(getRateHtml(rate_arr));
            $("#ajax_loader1").html("");
        }
        
    });
}

function getRateHtml(rate_arr)
{
    var i;
    var html = "<table id='live_rate_tbl'>";
    html += "<tr><th>Pair</th><th>Buy</th><th>Sell</th><th>Spread</th></tr>";
    for(i = 0; i < 5; i++)
    {
        var spread = (rate_arr[i].buy - rate_arr[i].sell) * 10000;
        var spread_str = spread.toString().split(".");
        var st = spread_str[0].toString() + "." + spread_str[1].slice(0, 2);
        //var st = spread_str[0].toString() + "." + spread_str[1].toString()+spread_str[2].toLocaleString();
        html += "<tr>";
        html += "<td style='font-weight:bold;'>" + rate_arr[i].name + "</td>";
        html += "<td>" + rate_arr[i].sell + "</td>";
        html += "<td>" + rate_arr[i].buy + "</td>";
        html += "<td>"+ st + "</td>";
        html += "</tr>";
    }
    html += "</table>";
    return html;
}

function convertCurrency(pair, amount, currency_from, currency_to)
{
    $.ajax({
        type: "POST",
        url: "http://localhost/fortunefx/ajaxservice/getLiveFxRate/" + pair,
        cache: false,
        beforeSend: function(){
            $("#ajax_loader").css("visibility", "visible");
        },
        success: function(data)
        {
            var converted_result = amount * data[0].rate;
            //var result_string = converted_result.toString().split(".");
            //var final_result_st = result_string[0].toString() + "." + result_string[1].slice(0, 4);
            var converted_html = amount + " " + currency_from + " = " + converted_result + " " + currency_to;
            $(".convert_result").html("<span style='font-family:Arial;font-size:15px;color:#4d4d4d;font-weight:bold;'>" + converted_html + "</span>");
            $("#ajax_loader").css("visibility", "hidden");
        }
        
    });
}