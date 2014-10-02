<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 2/10/2557
 * Time: 13:56 น.
 */

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$sessionLock = $this->Constant_model->sessionLock;

//check สถานะ login
if (empty($this->session->userdata['username'])) {
    redirect($webUrl . "signin");
}

//check session lock
if ($this->session->userdata[$sessionLock] == false) {
    redirect($webUrl);
}

$this->load->view("header");

$id = @$this->session->userdata['id'];
$arrMember = $this->Member_model->memberList($id);
extract((array)$arrMember[0]);

$name = "$firstname $lastname";
$imagePath = file_exists($image_path) ? $baseUrl . $image_path : $baseUrl . "assets/img/no_img.gif";
?>
<script>
    user_login = 'lock';
</script>
    <body class='locked'>
    <div class="wrapper ">
        <div class="pull-left">
            <img src="<?php echo $imagePath; ?>" alt="" width="200" height="200">
            <a href="<?php echo $webUrl; ?>signout">Not <?php echo $name; ?>?</a>
        </div>
        <div class="right">
            <div class="upper">
                <h2><?php echo $name; ?></h2>
                <span>Locked</span>
            </div>
            <form action="" method='post' class='form-validate' id="frmPost">

                <?php if ($message) { ?>
                    <p id="messageError" style="color: #b94a48;">Incorrect Password</p>
                <?php } else { ?>
                    <p id="messageError"></p>
                <?php } ?>
                <input type="hidden" id="username" name="username" value="<?php echo $username; ?>"/>
                <input type="password" id="password"
                       name="password" placeholder="Password"
                       autofocus=""
                       class='input-block-level'
                       data-rule-required="true"
                       onkeypress="$('#messageError').hide();">

                <div>
                    <input type="submit" value="Unlock" class='btn btn-inverse'>
                </div>
            </form>
        </div>
    </div>
    </body>
<?php
$this->load->view("footer");