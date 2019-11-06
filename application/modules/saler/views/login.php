<!DOCTYPE html>

<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        
        <title>VM Saler Account</title>

        
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/libraries/admin/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
        
        <link href="/template/admin/css/admin-styles.css" rel="stylesheet" type="text/css"/>

    <body class="login">
      
        <div class="login-form">

            <form action="" method="post">

                <h3 class="form-title" data-id="">VM Saler Account</h3>
                
                <br>

                <input <? if( $error == 1 ): ?>class="invalid"<? endif; ?> value="" type="text" autocomplete="off" placeholder="Логин" name="username">
                <input <? if( $error == 2 ): ?>class="invalid"<? endif; ?> value="" type="password" autocomplete="off" placeholder="Пароль" name="password">
                
                <button type="submit" class="btn save"> Войти </button>
                
            </form>
        
        </div>
        
    </body>

</html>