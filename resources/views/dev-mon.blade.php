<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Monitoring</title>
    <style type="text/css">
    .red {
        color: red;
    }

    .green {
        color: green;
    }
    </style>
</head>
<body>
    <ul>
        <li id="device-1"></li>
        <li id="device-2"></li>
    </ul>

<script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
<script>

$(document).ready(function() {
    realTimeStatDev('192.168.201.2', 'device-1');
    realTimeStatDev('192.168.201.3', 'device-2');
});

function realTimeStatDev(ip, device)
{
    $.ajax({
    url: <?php echo '"'.route("monitor").'"'; ?>+'/'+ip,
    success: function (result) {
        $.each(result, function (i, hasil) {
            $('#'+device).html(ip+" "+hasil, realTimeStatDev(ip, device));
            if(hasil == 'Aktif') {
                $('#'+device).removeClass('red');
                $('#'+device).addClass('green');
            }
            else {
                $('#'+device).removeClass('green');
                $('#'+device).addClass('red');
            }
        });
    }
    });
}
</script>
</body>
</html>
