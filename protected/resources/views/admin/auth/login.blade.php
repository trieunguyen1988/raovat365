<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Rao vặt 365 - Admin login</title>
        <link rel="stylesheet" href="{!!URL::asset('public/admin//login/css/style.css')!!}">
    </head>
    <body>
        <div class="container">
            <section id="content">
                <form action="" method="post">
                    <h1>Đăng Nhập</h1>
                    <div>
                        <input type="text" placeholder="Email" required="" id="email" name="email" />
                    </div>
                    <div>
                        <input type="password" placeholder="Mật khẩu" required="" id="password" name="password"/>
                    </div>
                    <div>
                        <input type="submit" value="Đăng nhập" />
                        <label><input type="checkbox" name="remember" value="1"/> Nhớ tên đăng nhập</label>
                    </div>
                </form><!-- form -->
                <div class="button">
                    Rao vặt 365
                </div><!-- button -->
            </section><!-- content -->
        </div><!-- container -->
    </body>
</html>
