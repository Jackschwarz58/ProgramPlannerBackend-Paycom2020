<?php
//Success Codes
define("LOGINSUCCESS", "HTTP/1.1 200 Successful Login");

//Error Codes
define("EMPTYFIELDS", "HTTP/1.1 432 Empty Input Fields");
define("SQLERROR", "HTTP/1.1 439 SQL Connection Error");
define("PASSINCORRECT", "HTTP/1.1 433 Password Incorrect");
define("USERINCORRECT", "HTTP/1.1 434 User Not Found");
