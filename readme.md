# filebrowser
Simple mac file browser web application on Laravel

You can config BROWSE_URL at config/app.php LINE 198


-----------

filemtime has some problem with thai-language file. I tried to resolve this according to

http://stackoverflow.com/questions/10551922/filesize-stat-failed
http://stackoverflow.com/questions/7639292/filemtime-function-filemtime-stat-failed-for-filenames-with-umlauts

Sadly, none of these solution works. So if you try this on folder with thai-language file may cause error.

I would gladly accept your recommend to fix this bug. 

Also, at first I taught of using angular, but the unlimited-level tree node implementation for angular seems to be very complicated. I need to write my own directives. So, for the sake of the speed, I decided to use only simple jQuery.

PS. I found that my attribute concatanation implementation in filebrowser.js is very shorter than I expected. It's kinda elegantly short but kinda hard to read.

