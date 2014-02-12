<?php
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("header");
?>
<script>
    function addWait(){

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

            <form action="#" method='post' class='form-validate' id="frmSignIn" name="frmSignIn" onsubmit="addWait()">
                <div class="control-group">
                    <div class="email controls">
                        <input type="text" id="username" name='username' placeholder="Username / Email"
                               class='input-block-level' data-rule-required="true">
                    </div>
                </div>
                <div class="control-group">
                    <div class="pw controls">
                        <input type="password" id="password" name="password" placeholder="Password"
                               class='input-block-level' data-rule-required="true">
                    </div>
                </div>
                <div class="submit">
                    <!--                <div class="remember">-->
                    <!--                    <input type="checkbox" name="remember" class='icheck-me' data-skin="square" data-color="blue" id="remember"> <label for="remember">Remember me</label>-->
                    <!--                </div>-->
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