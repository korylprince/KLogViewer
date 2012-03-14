KLogViewer
https://github.com/korylprince/KLogViewer

#Installing#

This has been installed on various versions of Ubuntu Server. It should work on any machine as long as it is running a webserver and PHP (5+).
If you are using a different authentication method, you may need something more. Check the KAuth requirements here:
https://github.com/korylprince/KAuth

If you are running this on a windows box, you need to edit the commands and find a replacement for grep, tail, sed, etc.

Simply copy the KLogViewer folder to your web directory, copy auth/options.php.def to auth/options.php and edit it for authentication options and for your list of logs.

If you just want a single login, copy auth/users.list.def to auth/users.list. You can use auth/mkpasswd.php to change the password. See https://github.com/korylprince/KAuth for usage.

Then navigate to your website and login. 

If you have any issues or questions, email the email address below, or open an issue at:
https://github.com/korylprince/KLogViewer/issues

#Usage#

This distribution is a simple web interface for checking looking at log files.
The default username/password is administrator/admin.

You can select the log type from the select box in the top left.
You can search the log with the textbox.
You can set the amount of lines to show with the select box in the middle.
You can set the page to autorefresh for different amounts of time.
The "AutoRefresh" text acts as a toggle switch. If it is red then autorefresh is activated.

If you wish to change authentication (say for AD integration) then edit auth/options.php.

To add or edit logs, you need to edit the $validTypes array in auth/options.php.

Read the comments to learn how to add your own.

The default config is for a DNS/DHCP server.

You can specify the refresh times and line amounts and their defaults in auth/options.php

This builds upon the "KAuth" Library:
https://github.com/korylprince/KAuth

The authentication can be extended using that library. Note: sessions must be used.

#Copyright Information#

jQuery and jQuery UI are produced by the jQuery team: http://jquery.com/ and http://jqueryui.com/

session_lib.php was taken from the PHP manual: http://php.net/manual/en/function.session-set-save-handler.php

jQuery Cookie was taken from https://github.com/carhartl/jquery-cookie


All other code is Copyright 2012 Kory Prince (korylprince at gmail dot com.) This code is licensed under the GPL v3 which is included in this distribution.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
