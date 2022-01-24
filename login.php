<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <!-- <link rel="stylesheet" href="reset.css"> -->

    <link rel="stylesheet" href="css/substyle.css">
    <link rel="stylesheet" href="css/form.css">

</head>
<body>

    <main>
        <div class="background">
                <div class="logo_div">
                <a href="index.php"><img class="logo" src="logo.png" width="70px"></a>
                    <h1 class="appname">ログイン画面</h1>    
                </div>
            <nav class="nav">

                <form action="loginp.php" method="post">

                    <div class="cp_iptxt margin1">
                        <p>学籍番号(ep20xxx)</p>
                        <input type="text" id="s_number" name="s_number" requiredminlength="4" maxlength="5" size="10">
                    </div>

                    <div class="cp_iptxt margin1">
                        <p>パスワード</p>
                        <input type="password" id="pass" name="pass" requiredminlength="8" maxlength="16" size="10">
                    </div>

                    <input type="submit" id="go" name="go" requiredminlength="4" maxlength="8" size="10" value="ログイン">
                </form>

            </nav>
        </div>

    </mian>

</body>
</html>