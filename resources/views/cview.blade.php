<html>
    <head></head>
<body>
<form method="post" action='{{route("run")}}'>
    {{csrf_field()}}
    <input name="command">
    <button type="submit">run command</button>
</form>
</body>
</html>
