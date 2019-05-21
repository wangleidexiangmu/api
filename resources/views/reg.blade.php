<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="regest" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>企业名称：</td>
                <td> <input type="text" name="pusername"></td>
            </tr>
            <tr>
                <td>法人名称：</td>
                <td> <input type="text" name="username"></td>
            </tr>
            <tr>
                <td>税务号：</td>
                <td> <input type="text" name="number"></td>
            </tr>
            <tr>
                <td>对公账号：</td>
                <td> <input type="text" name="pubnum"></td>
            </tr>
            <tr>
                <td>营业执照：</td>
                <td> <input type="file" name="phoon"></td>
            </tr>
            <tr>
                <td></td>
                <td> <input type="submit" value="提交"></td>
            </tr>
        </table>


    </form>
</body>
</html>