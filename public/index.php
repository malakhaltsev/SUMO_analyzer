<?php

ERROR_REPORTING(E_ALL);

include("configuration.php");
include("../application/Core/Autoloader.php");

(new Core\Bootstrap())->startup();