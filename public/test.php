<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>jQuery UI 日期选择器（Datepicker） - 默认功能</title>
    <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>
</head>
<body>
<form method="post" action="{{url('date')}}">
    <p>日期：<input type="text" id="datepicker" name="da"></p>
    <button type="submit">提交</button>
</form>

</body>
</html>
