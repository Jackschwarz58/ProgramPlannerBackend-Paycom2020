<?php
//Error and Success code for use in all the other PHP files

//Success Codes
define("OPSUCCESS", "HTTP/1.1 200 Success!");
define("COOKIECONFIRM", "HTTP/1.1 201 Login Cookie Present");
define("COOKIENOTFOUND", "HTTP/1.1 202 No Cookie Found");
define("COOKIESDELETED", "HTTP/1.1 203 Cookies Deleted/User Logged Out");


//Global Error Codes
define("SQLERROR", "HTTP/1.1 439 SQL Connection Error");
define("NOTALLOWED", "HTTP/1.1 438 Access Not Allowed");
define("EMPTYFIELDS", "HTTP/1.1 432 Empty Input Fields");
define("COOKIEERROR", "HTTP/1.1 437 Cookies Not Defined");


//Login Specific Error Codes
define("PASSINCORRECT", "HTTP/1.1 433 Incorrect Password");
define("USERINCORRECT", "HTTP/1.1 434 User Not Found");

//Sign-Up Specific Error Codes
define("INVALIDUIDEMAIL", "HTTP/1.1 445 Email Address & Username Invalid");
define("INVALIDEMAIL", "HTTP/1.1 446 Email Address Invalid");
define("INVALIDUID", "HTTP/1.1 447 Username Invalid (No Special Characters)");
define("INVALIDPWDCHECK", "HTTP/1.1 448 Passwords Don't Match");
define("USERTAKEN", "HTTP/1.1 449 Username Already Taken");

//Session Specific Error Codes
define("NOFUNCNAME", "HTTP/1.1 451 No Function Defined");
define("FUNCNOTFOUND", "HTTP/1.1 452 Function Undefined");
define("EDITFIELDNOTFOUND", "HTTP/1.1 453 Error When Attempting to Edit Session");
define("NOIDGIVEN", "HTTP/1.1 454 No Session ID Given");
define("RELATIONEXISTS", "HTTP/1.1 455 You are Already Enrolled in This Session");
