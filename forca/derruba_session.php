<?php
ob_start();
session_start();
session_destroy();
header("Location: https://agsusbrasil.org/sistema-integrado/gestor/");
exit();
ob_end_flush();