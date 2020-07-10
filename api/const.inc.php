<?php
//Success Codes
define("OPSUCCESS", "HTTP/1.1 200 Successful Operation");

//Global Error Codes
define("SQLERROR", "HTTP/1.1 439 SQL Connection Error");
define("NOTALLOWED", "HTTP/1.1 438 Access Not Allowed");
define("EMPTYFIELDS", "HTTP/1.1 432 Empty Input Fields");

//Login Specific Error Codes
define("PASSINCORRECT", "HTTP/1.1 433 Incorrect Password");
define("USERINCORRECT", "HTTP/1.1 434 User Not Found");

//Sign-Up Specific Error Codes
define("INVALIDUIDEMAIL", "HTTP/1.1 445 Email Address & Username Invalid");
define("INVALIDEMAIL", "HTTP/1.1 446 Email Address Invalid");
define("INVALIDUID", "HTTP/1.1 447 Username Invalid (No Special Characters)");
define("INVALIDPWDCHECK", "HTTP/1.1 448 Passwords Don't Match");
define("USERTAKEN", "HTTP/1.1 449 Username Already Taken");
