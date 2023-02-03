<html>
<head>
    <title>假裝這是後台</title>
</head>
<body>
<h1>假裝這是後台</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('system.push-message') }}" method="post">
    <div>
        <label>
            UID:
            <input type="text" name="uid">
        </label>
    </div>
    <div>
        <label>
            標題欄位:
            <input type="text" name="title">
        </label>
    </div>
    <div>
        <label>
            內容欄位:
            <input type="text" name="content">
        </label>
    </div>
    <div>
        <button type="submit">送出</button>
    </div>
</form>
</body>
</html>
