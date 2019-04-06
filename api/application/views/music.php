<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>在线音乐</title>
    <!-- require APlayer -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.css">
    <script src="https://cdn.jsdelivr.net/npm/aplayer/dist/APlayer.min.js"></script>
    <!-- require MetingJS -->
    <script src="https://cdn.jsdelivr.net/npm/meting@2/dist/Meting.min.js"></script>
    <style>
        body {
            margin: 0;
        }

        .aplayer {
            margin: 0;
            box-sizing: border-box;
            border: 1px solid #eee;
        }
    </style>
</head>

<body>
    <meting-js volume="1" theme="#f099bb" auto="<?=$url?>"></meting-js>
</body>

</html>