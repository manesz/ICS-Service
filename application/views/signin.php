<?php
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("header");
?>
<!--        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
    <script>
        var c_username = '';
        var c_password = '';
        var c_remember = '';

        $(document).ready(function () {
            $("body").prepend(strWaitImage);
            c_username = getCookie("username");
            c_password = getCookie("password");
            c_remember = getCookie("remember_me");
//            alert(c_remember)
            if (c_remember) {
                $('#username').val(c_username);
                $('#password').val(c_password);
                $(".remember div").addClass('checked');
                $('#remember_me').attr('checked', true);
            } else {
                $('#remember_me').removeAttr('checked');
                $('#username').val('');
                $('#password').val('');
            }
            $('#remember_me').click(function () {
                addRememberMe();
            });
        });
        function addRememberMe() {
            if ($('#remember_me').is(':checked')) {
                setCookie('username', $('#username').val());
                setCookie('password', $('#password').val());
                setCookie('remember_me', "true");
            } else {
                $(".remember div").removeClass('checked');
                $('#remember_me').removeAttr('checked');
                setCookie('username', "");
                setCookie('password', "");
                setCookie('remember_me', "");
            }
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }

        function setCookie(key, value) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value +';path=/'+ ';expires=' + expires.toUTCString();
        }
    </script>
    <body class='login'>
    <div class="wrapper">
        <h1>
            <a href="<?php echo $webUrl; ?>dashboard">
                <img src="<?php echo $baseUrl; ?>assets/img/logo.png" alt="" class='retina-ready' width="64"
                     height="auto">ICS
                <small style="color: #FFF;">-Services</small>
            </a>
        </h1>
        <div class="login-body">
            <h2>SIGN IN</h2>

            <form action="#" method='post' class='form-validate' id="frmSignIn" name="frmSignIn">
                <div class="control-group">
                    <div class="email controls">
                        <input type="text" id="username" autofocus=""
                               maxlength="50"
                               name='username' placeholder="Username / Email"
                               class='input-block-level' data-rule-required="true">
                    </div>
                </div>
                <div class="control-group">
                    <div class="pw controls">
                        <input type="password" id="password"
                               maxlength="50"
                               name="password" placeholder="Password"
                               class='input-block-level' data-rule-required="true">
                    </div>
                </div>
                <div class="submit">
                    <div class="remember">
                        <input type="checkbox" name="remember_me"
                               class='icheck-me' data-skin="square" data-color="blue"
                               id="remember_me">
                        <label for="remember_me">Remember me</label>
                    </div>
                    <input type="submit" id="btnSignIn" value="Sign me in" class='btn btn-primary'>
                </div>
            </form>
            <div class="forget">
                <a href="#"><span id="authenResult" style="color: red;"></span></a>
            </div>
        </div>
    </div>
    </body>

<?php
$this->load->view("footer");
?>