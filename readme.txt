=== Server Security Scan ===
Contributors: wordpressutils
Donate link: 
Tags: security, server security, server scan, security scan, security check, secure, server vulnerability, php security, hacker safe, unsafe php settings, unsafe php functions , attack, hack, hackers, prevention, RFI, XSS, CRLF, CSRF, SQL Injection, vulnerability, view phpinfo, phpinfo, check phpinfo, website security, WordPress security, security log
Requires at least: 2.8
Tested up to: 3.6
Stable tag: 1.0.1
License: GPLv2 or later
Scans wordpress website server security for detecting possible vulnerabilities and hacks.

== Description ==

♦ Check your server's overall security
♦ Detect unsafe PHP settings
♦ Detect unsafe PHP functions
♦ Check for security modules
♦ Detect unwanted write permissions
♦ Detect all errors and error levels

Server Security Scan identifies possible vulnerabilities and loopholes in your sever by inspecting various PHP configurations and settings, checking write permissions of directories, checking for presence of security modules and by detecting the presence of any unsafe PHP functions. Thus it helps to protect your server from various possible web site hacks such as variable injection, code injection and SQL injection etc.

= Unsafe PHP configuration scan =

Server Security Scan checks for certain PHP configurations in your server to identify whether they are configured safely so as to safeguard your server from hackers. The scanner suggests possible issues of wrongly configuring these settings as well as the criticality level of misconfiguring these settings.

= Unsafe PHP function scan =

Hackers may misuse some of the PHP functions which you do not use in your applications. Often these functions might be enabled by default in most of the servers. The Server Security Scanner detects whether such functions are enabled in your server and suggests the criticality level and issues related to those functions.

= Directory permission scan =

It is unsafe to leave your web accessible directories with write permission. The Server Security Scanner detects all writable folder permissions and reports them.

= Security module scan =

There are certain PHP extensions which can be used to enhance the security of your PHP installation. The Server Security Scan detects whther such modules are installed on your server and reprts the same.

The Server Security Scan detects various possiblities of hacking your server and reports them. The items are reported with criticality of each of the detection. You may contact your host to get the issues rectified if you are not familiar with updating server configurations.
 
= About =

Server Security Scan is developed and maintained by [wordpressutils](http://wordpressutils.com/ "wordpressutils.com").

== Installation ==

1. Extract `server-security-scan.zip` to your `/wp-content/plugins/` directory.
2. In the admin panel under plugins activate Server Security Scan.
3. You can now run the checks now by clicking `Run Checks` link in the menu.

== Frequently Asked Questions ==

= The Server Security Scan is not working properly. =

Please check the wordpress version you are using. Make sure it meets the minimum recommended version. Make sure all files of the `Server Security Scan` plugin are uploaded to the folder `wp-content/plugins/`

= Does the Server Security Scan automatically fix errors in my server ? =

No, the plugin scans and detects vulnerable parts in your server and reports the same to you. You have to manually rectify the reported issues either by yourself or by contacting your host. 

= Does the Server Security Scan report the seriousness of issues ? =

Yes the plugin categorizes the issues into 3 levels based on seriousness, Critical(most important), Warning and Notice(least important).

= Does Server Security Scan work on all type of servers ? =

Yes it does work with all kinds of servers.

= Is Server Security Scan  Network / MU / Multisite Compatible ? =

Yes. Server Security Scan works well with Network / MU /Multisite installations.

== Screenshots ==

1. Server Security Scan - Result Page

== Changelog ==

= Server Security Scan 1.0.1 =
* Fixed minor bugs.

= Server Security Scan 1.0.0 =
* First official launch.

== Upgrade Notice ==

Nothing here.

== More Information ==

= Troubleshooting =

Please read the FAQ first if you are having problems.

= Requirements =

    WordPress 2.8+
    PHP 5+