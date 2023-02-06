<?php
session_start();
$idUS = $_SESSION['us'] ? "?us=".$_SESSION['us']:"";
session_destroy();
require_once('app/@config.php');
header('Location: '.base_url($idUS));
