<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/main.php';

if (!isset($_SESSION["user"])) {
    header("Location: /");
    exit;
}

$title = $_SESSION["user"]["username"] . " - Rovive";
?>

<?php echo PageBuilder::buildHeader(); ?>

<link rel='stylesheet' href='/css/leanbase___9b9fc145916d65f94e610d1f02775894_m.css' />

<link rel='stylesheet' href='/css/page___9b1354f6392e505305c1aa8a1f7931d6_m.css' />

<link rel='stylesheet' href='/css/accountoridk.css' />

<div class="content ">

    <div class="section">
        <div class="container-header">
            <h1 class="user-account-header">My Settings</h1>
        </div>
    </div>
    <div id="settings-container">
        <div class="left-navigation">
            <ul id="vertical-menu" class="menu-vertical submenus" role="tablist">
                <li class="menu-option">
                    <a class="rbx-tab-heading" href="#info" id="tab-info">
                        <span class="text-lead">Account Info</span>
                        <span class="rbx-tab-subtitle"></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content rbx-tab-content">
            <div class="tab-content rbx-tab-content">
                <div class="tab-pane active" id="info">
                    <div class="section profile-info" ng-controller="profileUtilitiesController">
                        <div class="container-header">
                            <h3>Account Info</h3>
                        </div>
                        <div class="section-content">
                            <p><span style="opacity: 35%; font-weight:400">Username:</span>
                                <?= htmlspecialchars($_SESSION["user"]["username"]) ?><button class="pull-right" style="height: 1em; opacity: 75%; font-weight:400; border: none; outline: none; background-color: Transparent" id="EditUsername">Edit</button></p>
                            <p><span style="opacity: 35%; font-weight:400">Password:</span> *********<button class="pull-right" style="height: 1em; opacity: 75%; font-weight:400; border: none; outline: none; background-color: Transparent" id="EditPassword">Edit</button></p>
                            <p><span style="opacity: 35%; font-weight:400">Email Address:</span>
                                <?= isset($_SESSION["user"]["email"]) 
                                ? htmlspecialchars($_SESSION["user"]["email"]) 
                                : "N/A" ?>
                                <button class="pull-right" style="height: 1em; opacity: 75%; font-weight:400; border: none; outline: none; background-color: Transparent" id="EditEmail">Edit</button></p>
                        </div>
                    </div>
                    <div class="section profile-about" ng-controller="profileUtilitiesController">
                        <div class="container-header">
                            <h3>Personal</h3>
                        </div>
                        <div class="section-content">
                            <h3>W.I.P</h3>
                        </div>
                    </div>
                    <div class="section profile-about" ng-controller="profileUtilitiesController">
                        <div class="container-header">
                            <h3>Extensions</h3>
                        </div>
                        <div class="section-content">
                            <div class="row mt-1">
                                <input class="form-control input-field" style="display: inline-block; width: 49.5%; opacity: 80%;" readonly="" type="text" value="Website Theme">
                                <select id="themeSelector" class="form-control input-field" style="display: inline-block; width: 50%;">
                                    <option value="light">Default</option>
                                    <option value="dark">Dark Theme</option>
                                </select>
                                <script>
                                    const themeSelector = document.getElementById("themeSelector");
                                    themeSelector.value = "<%= theme %>";
                                    themeSelector.onchange = function() {
                                        const xhr = new XMLHttpRequest();
                                        xhr.open("POST", "/v1/api/theme/set");
                                        xhr.setRequestHeader("Content-Type",
                                            "application/x-www-form-urlencoded");
                                        xhr.setRequestHeader("Cookie", document.cookie);
                                        xhr.onload = function() {
                                            if (xhr.status === 200) {
                                                window.location.reload();
                                            } else {
                                                Roblox.GenericConfirmation
                                                    .open({
                                                        titleText: "Something went wrong.",
                                                        bodyContent: "Failed to change theme.",
                                                        acceptText: "OK",
                                                        acceptColor: Roblox
                                                            .GenericConfirmation
                                                            .blue,
                                                        declineColor: Roblox
                                                            .GenericConfirmation
                                                            .none,
                                                        allowHtmlContentInBody: true,
                                                        dismissable: true,
                                                        onAccept: function(e) {
                                                            window.location.reload();
                                                        }
                                                    });
                                            }
                                        }
                                        xhr.send("theme=" + themeSelector.value);
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="social">

                </div>
                <div class="tab-pane " id="privacy">

                </div>
                <div class="tab-pane " id="billing">

                </div>
            </div>

        </div><!-- profile-header -->
    </div>
</div>

<script type="text/javascript">
    var Roblox = Roblox || {};
</script>


<!-- The Modal -->
<div id="passwordModal" class="customModal">

    <!-- Modal content -->
    <div class="customModal-content">
        <span class="closeCustomModal">&times;</span>
        <h4>Change your password</h4>

        <form class="betterForm" method="POST" action="/api/settings/changepassword">
            <div class="form-group">
                <label for="currentPassword">Old password</label>
                <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder="Old password">
            </div>
            <div class="form-group">
                <label for="newPassword">New password</label>
                <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New password">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm password</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-secondary-md">Submit</button>
            </div>
        </form>

    </div>

</div>

<!-- The Modal -->
<div id="emailModal" class="customModal">

    <!-- Modal content -->
    <div class="customModal-content">
        <span class="closeCustomModal">&times;</span>
        <h4>Change your email</h4>

        <form class="betterForm" method="POST" action="/api/settings/changeemail">
            <div class="form-group">
                <label for="newEmail">New email</label>
                <input type="email" class="form-control" name="newEmail" id="newEmail" placeholder="New email">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-secondary-md">Submit</button>
            </div>
        </form>

    </div>

</div>

<!-- The Modal -->
<div id="usernameModal" class="customModal">

    <!-- Modal content -->
    <div class="customModal-content">
        <span class="closeCustomModal">&times;</span>
        <h4>Change your username</h4>

        <form class="betterForm" method="POST" action="/api/settings/changeusername">
            <div class="form-group">
                <label for="newUsername">New username</label>
                <input type="text" class="form-control" name="newUsername" id="newUsername" placeholder="New username">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-secondary-md">Submit (Costs 1,000 Robux)</button>
            </div>
        </form>

    </div>

</div>

<script defer>
    $(".customModal").appendTo("body"); // set their parent to the body

    $(".customModal").hide();

    $("#EditPassword").click(function() {
        $("#passwordModal").show();
    });
    $("#EditEmail").click(function() {
        $("#emailModal").show();
    });
    $("#EditUsername").click(function() {
        $("#usernameModal").show();
    });

    $(".closeCustomModal").click(function() {
        $(".customModal").hide();
    });


    $(".betterForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: this.action,
            type: "POST",
            data: $(this).serialize(),
            success: function(data) {
                window.location.reload();
            },
            error: function(data) {
                alert(data.responseText);
            }
        });

    });
</script>
<style>
    .customModal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 2000;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .customModal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px;
        width: 80%;
        max-width: 500px;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .closeCustomModal {
        color: gray;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .closeCustomModal:hover,
    .closeCustomModal:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .customModal .form-control {
        height: 34px;
        padding: 6px 12px;
    }
</style>

<?php echo PageBuilder::buildFooter(); ?>
