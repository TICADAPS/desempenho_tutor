<?php
ob_start();
session_start();
session_destroy();
header("Location: https://www.adapsbrasil.com.br");
exit;
ob_end_flush();