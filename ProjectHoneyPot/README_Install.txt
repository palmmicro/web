PROJECT HONEY POT ADDRESS DISTRIBUTION SCRIPT

Congratulations! You've successfully begun the process of installing a
Project Honey Pot address distribution script on your website. Through
this script we hand out honey pot addresses and track the spammers who
abuse them.

The next step is to install this script on your web server. The
following instructions are provided to help you with this process. They
have been written to apply to many cases, but not all. If you have
questions, or these instructions do not seem to apply in your case, you
should check with your website administrator.

-------------------------
INSTALLATION INSTRUCTIONS
-------------------------

STEP 1: LOCATE THE SCRIPT

	Locate the copy of the script included in the downloaded file. In
	your case, the script is named:
	
	memorial.php

STEP 2: COPY IT TO THE CORRECT LOCATION

	Copy the script into your web server's html folder. On most
	Unix/Linux systems this folder will be called:
	
	htdocs/ or www/
	
	If you do not know where your html folder is located, ask your
	web server administrator. Ensure when you copy the script you do
	not change its name or otherwise modify it.
        
        You may install the script in any folder that is accessible
        over the web. For example:
        
        htdocs/folder1/folder2/

STEP 3: SET THE PERMISSIONS

	On most systems, in order for the script to execute its
	permissions must be set correctly. On Unix/Linux systems you
	can set the scripts' permissions with the following command:
	
	chmod 644 memorial.php
	
STEP 4: INSTALL PHP

	The script requires your webserver to run PHP. If it has not already 
        been installed you will need to install it. 
         
        You may download the latest version of PHP from following website:
	
	http://www.php.net
        
        Installation instructions can be found here:
        
        http://www.php.net/manual/en/install.php

STEP 5: VISIT THE SCRIPT

	Once you've installed the script on your web server you need to
	access it. Open a web browser and type in the URL of your web site 
        followed by the path to the script. For example, if you installed
        your script inside 'folder1/folder2/', access the script like so: 
	
	http://www.palmmicro.com/folder1/folder2/memorial.php
	
	If installed correctly, you will see instructions on how to
	finalize the installation.

---------------
TROUBLESHOOTING
---------------

PHP INSTALLATION

	In order for the script to work, you must install PHP. If you
	have not already installed PHP, you can get the latest version
	and instructions on how to install it, from:
	
	http://www.php.net/
        
        PHP works well with the Apache Web Server:
        
        http://www.apache.org/

WEB SERVER CONFIGURATION

	You need to make certain your web server software is able to
	execute PHP scripts. Follow the instructions provided with your
	web server software in order to ensure it is set up correctly
	to do this.

SCRIPT CHANGES

	The script will not execute correctly if you change its name or
	any of its contents. You should return to the Project Honey Pot
	site and download a new copy of the script if you modified it in
	any way.
