<?php
session_start();
session_unset();
session_destroy();
header('location: front/index.php');