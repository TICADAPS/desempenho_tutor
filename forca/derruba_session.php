<?php
ob_start();
session_start();
session_destroy();
header("Location: https://agsusbrasil.org/sistema-integrado/login.php");
exit();
ob_end_flush();