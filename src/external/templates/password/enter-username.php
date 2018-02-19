<?php

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\dto\SystemURLs;

// Set the page title and include HTML header
$sPageTitle = gettext("Family Registration");
require(SystemURLs::getDocumentRoot() . "/Include/HeaderNotLoggedIn.php");
?>

    <div class="register-box" style="width: 600px;">
        <div class="register-logo">
            <?php
            $headerHTML = '<b>Church</b>CRM';
            $sHeader = SystemConfig::getValue("sHeader");
            $sChurchName = SystemConfig::getValue("sChurchName");
            if (!empty($sHeader)) {
                $headerHTML = html_entity_decode($sHeader, ENT_QUOTES);
            } else if (!empty($sChurchName)) {
                $headerHTML = $sChurchName;
            }
            ?>
            <a href="<?= SystemURLs::getRootPath() ?>/"><?= $headerHTML ?></a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg"><?= gettext('Reset your password') ?></p>

            <div class="form-group has-feedback">
                <input id="username" type="text" class="form-control" placeholder="<?= gettext('Login Name') ?>"
                       required>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <button type="submit" id="resetPassword" class="btn bg-olive"><?= gettext('Go'); ?></button>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.form-box -->
    </div>
    <script nonce="<?= SystemURLs::getCSPNonce() ?>" >
        $("#resetPassword").click(function (e) {
            var userName = $("#username").val();
            if (userName) {
                $.ajax({
                    method: "POST",
                    url: window.CRM.root + "/api/public/user/password/reset/",
                    data: JSON.stringify({ 'userName': userName })
                }).done(function (data) {
                    bootbox.alert("<?= gettext("Check your email for a password reset link")?>",
                        function () {
                            window.location.href = window.CRM.root + "/";
                        }
                    );
                }).fail(function () {
                    bootbox.alert("<?= gettext("Sorry, we are unable to process your request at this point in time.")?>");
                });
            } else {
                bootbox.alert("<?= gettext("Login Name is Required")?>");
            }
        });
    </script>
<?php
// Add the page footer
require(SystemURLs::getDocumentRoot() . "/Include/FooterNotLoggedIn.php");
