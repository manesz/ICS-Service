<?php
    require_once("header.php");
?>
<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/ics_service.js"></script>
<body class='login'>
<div class="wrapper">
    <h1><a href="index.php"><img src="assets/img/logo.png" alt="" class='retina-ready' width="64" height="auto">ICS<small style="color: #FFF;">-services</small></a></h1>
    <div class="login-body">
        <h2>SIGN IN</h2>
        <form action="" method='get' class='form-validate' id="test">

            <div class="control-group">
                <div class="email controls">
                    <input type="text" id="username" name='username' placeholder="Username / Email" class='input-block-level' data-rule-required="true" data-rule-email="true">
                </div>
            </div>
            <div class="control-group">
                <div class="pw controls">
                    <input type="password" id="password" name="password" placeholder="Password" class='input-block-level' data-rule-required="true">
                </div>
            </div>
            <div class="submit">
<!--                <div class="remember">-->
<!--                    <input type="checkbox" name="remember" class='icheck-me' data-skin="square" data-color="blue" id="remember"> <label for="remember">Remember me</label>-->
<!--                </div>-->
                <input type="button" id="signin" value="Sign me in" class='btn btn-primary'>
            </div>
        </form>
        <div class="forget">
            <a href="#"><span id="authenResult" style="color: red;"></span></a>
        </div>
    </div>
</div>
</body>

<?php require_once("footer.php");?>