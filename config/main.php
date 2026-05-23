<?php
// TODO List:
// Replace the maintenance variable with a dynamic one.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();


if (!isset($_SESSION["passcode"])) {
    $_SESSION["passcode"] = "";
}

// variables

$maintenance = false;

$maintenanceKey = "doyousuckdicks?yesyesyes!";

require_once "config.php";


// import page builder, new technique to build pages, makes development MUCH MUCH easier.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/PageBuilder.php';

// import all the classes
foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/config/classes/*.php') as $filename) {
    require_once $filename;
}


// define session variables from token
if (isset($_COOKIE["_ROBLOSECURITY"])) {
    $token = $_COOKIE["_ROBLOSECURITY"];

    $auth = new Auth;
    if ($auth->validateToken($token)) {
        $auth->loginWithToken($token);
    }
}


if ($maintenance) {
    PageBuilder::$pageConfig["title"] = "Under Maintenance"; // were under maintenance sorry
} else {
    if (isset($title)) {
        PageBuilder::$pageConfig["title"] = "Rovive - " . $title;
    } else {
        PageBuilder::$pageConfig["title"] = "Rovive";
    }
}


// maintenance code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["passcode"])) {
    $_SESSION["passcode"] = $_POST["passcode"];
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["leaveMbypass"])) {
    $_SESSION["passcode"] = "";
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit;
}

if ($maintenance && $_SESSION["passcode"] !== $maintenanceKey) {
    $content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/config/maintenance.php');
    echo $content;
    exit;
}




// for banned users
if (isset($_SESSION["user"])) {
    $userclass = new User;
    if ($userclass::getUser($_SESSION["user"]["id"])["ongoing_action_id"] > 0 && !str_contains($_SERVER["REQUEST_URI"], "/not-approved")) {
        header("Location: /not-approved");
        exit;
    }
}
