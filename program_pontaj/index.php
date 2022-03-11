<?php

session_start();

define("START", "1");

require_once 'db-connect.php';

require_once 'detect-action.php';

require_once 'html.php';

require_once 'db-disconnect.php';
