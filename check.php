<div id="wpu_ssc_header"></div>
<div class="wpu_ssc_body">
<?php 

define('ERROR_CRITICAL', 'Critical');
define('ERROR_WARNING', 'Warning');
define('ERROR_NOTICE', 'Notice');

$windows =  ('win' == substr(strtolower(PHP_OS), 0, 3) || 'cygwin' == substr(strtolower(PHP_OS), 0, 6)) ?  true : false;
 $process_user = $windows ? getenv('username') : ((function_exists('posix_getpwuid') && function_exists('posix_geteuid')) ? ( ($process_user = posix_getpwuid(posix_geteuid())) ? $process_user['name'] : 'unknown' ) : 'unknown');
/*$process_user='unknown';
if($windows) 
{
	$process_user = getenv('username');
} 
elseif(function_exists('posix_getpwuid') && function_exists('posix_geteuid'))
{
	$process_user = posix_getpwuid(posix_geteuid());
	$process_user = ($process_user) ? $process_user['name'] : 'unknown';
}*/

$path= realpath(getcwd().'/../');

$server=array();
$modules=array();
$php=array();
$functions=array();
$insecure_functions=array();

$server['Server']=php_uname(); 
$server['Operating System']=PHP_OS; 
$server['Hostname']=$_SERVER['HTTP_HOST']; 
$server['Username']=$process_user; 
$server['Date']=date('Y-m-d H:i:s'); 
$server['Timezone']=date_default_timezone_get(); 

$modules['Suhosin']=extension_loaded('suhosin') ? array( 'Yes','','') : array('No','<a href="http://www.hardened-php.net/suhosin/">Suhosin</a> is an advanced protection system for PHP installations.',ERROR_NOTICE);

$php['User']=array($process_user, $windows ? 'PHP is running as '.$process_user.' - ensure that this user is not an administrator as it creates abuse possibilities.'  : ( ( 'root' == $process_user ) ? 'PHP is running as the system\'s "root" user account - this creates abuse possibilities.' : '' ), ($windows ? ERROR_WARNING : ( ( 'root' == $process_user ) ? ERROR_WARNING : '' ) ) ); 
$php['Version']=array(phpversion(),'Please consider updating if there are known vulnerabilities with this version.',ERROR_NOTICE); 

$php['Safe mode (safe_mode)']=ini_get('safe_mode') ? array('Enabled','This feature has been DEPRECATED as of PHP 5.3.0. Relying on this feature is highly discouraged. (http://php.net/manual/en/features.safe-mode.php) Instead of safe mode, use <kbd>open_base_dir</kbd> and <kbd>disabled_functions</kbd>.',ERROR_WARNING) : array('Disabled','',''); 
$php['Open base dir (open_base_dir)']=ini_get('open_base_dir') ? array('Enabled','','') : array('Disabled','It is better to enforce a base directory (eg: "/var/www/") to prevent PHP from accessing other directories in the filesystem.',ERROR_WARNING); 
$php['Enable dl(enable_dl)']=ini_get('display_errors') ? array('Enabled','With dynamic loading, it is possible to ignore all open_basedir restrictions which is dangerous.',ERROR_WARNING) : array('Disabled','',''); 

$php['Expose PHP(expose_php)']=ini_get('expose_php') ? array('Enabled','Exposing your PHP version will help hackers to exploit known vulnerablities in your php version.',ERROR_WARNING) : array('Disabled','',''); 
$php['Display errors(display_errors)']=ini_get('display_errors') ? array('Enabled','This is useful during development, but it is safer to set it to "Off" in live site.',ERROR_WARNING) : array('Disabled','',''); 

$php['File uploads(file_uploads)']=ini_get('file_uploads') ? array('Enabled','If you do not need file uploads it is safer to disable them.',ERROR_NOTICE) : array('Disabled','',''); 
$php['Maximum upload size (upload_max_filesize)']=array(ini_get('upload_max_filesize'),'If you are using file uploads and you dont want hackers to waste your bandwidth, set this to a reasonable size.',ERROR_NOTICE); 
$php['Maximum file uploads per client (max_file_uploads)']=array(ini_get('max_file_uploads'),'It would be wise to set this to a low integer',ERROR_NOTICE); 
$php['Temporary upload dir (upload_tmp_dir)']=array("upload_tmp_dir = " .ini_get('upload_tmp_dir') .'<br />System default tmp_dir = ' .tempnam(sys_get_temp_dir(), 'Tux'), 'Must be a writable directory. If not specified PHP will use the system default, and if the system default is not inside a public directory, you you are a lot safer.',ERROR_NOTICE); 

$php['Remote file open(allow_url_fopen)']=ini_get('allow_url_fopen') ? array('Enabled','If you do not need to read remote files, set it to "No"',ERROR_NOTICE) : array('Disabled','',''); 
$php['Remote file inclusion(allow_url_include)']=ini_get('allow_url_include') ? array('Enabled','If you do not need to include remote files, set it to "No"',ERROR_NOTICE) : array('Disabled','',''); 

$php['Script memory limit (memory_limit)']=array(ini_get('memory_limit'),'Make sure this is not high, as it prevents poorly written scripts from eating up all available memory on a server',ERROR_NOTICE); 
$php['Maximum post size(post_max_size)']=array(ini_get('post_max_size'),' If you need to upload large files, this value must be larger than <kbd>upload_max_filesize</kbd>',ERROR_NOTICE); 

$php['Register globals(register_globals)']=ini_get('register_globals') ? array('Enabled','You must disable register_globals in your PHP configuration to prevent malicious variable manipulation. This feature is deprecated from 5.3.0',ERROR_CRITICAL) : array('Disabled','',''); 
$php['magic_quotes_gpc']=ini_get('magic_quotes_gpc') ? array('Enabled','It is better to handle quotes escaping manually rather than letting server do it.',ERROR_WARNING) : array('Disabled','',''); 
$php['use_trans_sid']=ini_get('use_trans_sid') ? array('Enabled','While this helps people who do not accept cookies, search engines will rank your site lower.',ERROR_NOTICE) : array('Disabled','','');

$insecure_functions['System functions']	= array(array('apache_get_modules','apache_get_version','apache_getenv','get_loaded_extensions','phpinfo','phpversion'),
		'These functions should be disabled to reduce the amount of information a malicious user can obtain about your PHP configuration.',
		ERROR_WARNING
		);

$insecure_functions['File handling functions']	= array(array('chgrp','chmod','chown','copy','link','mkdir','rename','rmdir','symlink','touch','unlink'),
		'You may change your configuration to disable PHP accessing filesystem unless this is absolutely necessary.',
		ERROR_WARNING
		);

$insecure_functions['Log functions']	= array(array('openlog','syslog'),
		'These functions should be disabled to avoid the possibility of log file tampering on your system.',
		ERROR_WARNING
		);

$insecure_functions['Process functions']	= array(array('proc_nice'),
		'These functions should be disabled to prevent PHP scripts from disrupting other processes.',
		ERROR_CRITICAL
		);

$insecure_functions['Command execution functions']	= array(array('apache_note','apache_setenv','dl','exec','passthru','pcntl_exec','popen','proc_close','proc_open','proc_get_status','proc_terminate','putenv','shell_exec','system','virtual'),
		'These functions should be disabled to prevent PHP from executing commands on the underlying system.',
		ERROR_CRITICAL
		);

foreach ($insecure_functions as $key=>$value) {
	foreach ($value[0] as $v) {
		$functions[$key][0][$v]=function_exists($v) ? 'Enabled' : 'Disabled';
	}
	$functions[$key][1]=$value[1];
	$functions[$key][2]=$value[2];
}
?>

<br/>
<div class="wpu_subheading">Server info</div>
<table class="widefat">
<tr><th width="20%">Config</th><th width="80%">Value</th></tr>
<?php foreach ($server as $key=>$value) { ?><tr><td><?php echo $key; ?></td><td><?php echo $value; ?></td></tr><?php } ?>
</table>

<br/>
<div class="wpu_subheading">Error information levels <span> (Information about errors reported by this plugin.) </span></div>
<table class="widefat">
<tr><th width="20%">Error Level</th><th width="80%">Meaning</th></tr>
<tr><td class="wpu_info"><?php echo ERROR_NOTICE; ?></td><td>These issues are least critical.</td></tr>
<tr><td class="wpu_warn"><?php echo ERROR_WARNING; ?></td><td>Check with your developers &amp; host to see if these can be avoided for better security.</td></tr>
<tr><td class="wpu_err"><?php echo ERROR_CRITICAL; ?></td><td>Need to be taken care with high priority.</td></tr>
</table>

<br/>
<div class="wpu_subheading">Directory permissions <span> (Check if following write permissions are required.) </span></div>
<div class="wpu_heigth_limiter">
<table class="widefat">
<tr><th>Directory</th><th width="20%">Writable</th></tr>
<tr><td><?php echo $path;?></td><td class="<?php echo is_writable($path) ? "wpu_warn" : "";?>"><?php echo is_writable($path) ? "Yes" : "No";?></td></tr><?php 
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){	if(is_dir($name))	{?><tr><td><?php echo $name;?></td>
<td class="<?php echo is_writable($name) ? "wpu_warn" : "";?>"><?php echo is_writable($name) ? "Yes" : "No";?></td></tr><?php }}?>
</table>
</div>

<br/>
<div class="wpu_subheading">External Security Modules</div>
<table class="widefat">
<tr><th width="20%">Module/Extension</th><th width="20%">Installed</th><th width="10%">Level</th><th width="50%">Alert</th></tr>
<?php foreach ($modules as $key=>$value) { ?><tr><td><?php echo $key; ?></td><td><?php echo $value[0]; ?></td>
<td class="<?php if($value[2]==ERROR_CRITICAL)echo "wpu_err";if($value[2]==ERROR_WARNING)echo "wpu_warn";if($value[2]==ERROR_NOTICE)echo "wpu_info"; ?>"><?php echo $value[2]; ?></td>
<td><?php echo $value[1]; ?></td></tr><?php } ?>
</table>

<br/>
<div class="wpu_subheading">PHP Configurations</div>
<table class="widefat">
<tr><th width="20%">Config</th><th width="20%">Value</th><th width="10%">Level</th><th width="50%">Alert</th></tr>
<?php foreach ($php as $key=>$value) { ?><tr><td><?php echo $key; ?></td><td><?php echo $value[0]; ?></td>
<td class="<?php if($value[2]==ERROR_CRITICAL)echo "wpu_err";if($value[2]==ERROR_WARNING)echo "wpu_warn";if($value[2]==ERROR_NOTICE)echo "wpu_info"; ?>"><?php echo $value[2]; ?></td>
<td><?php echo $value[1]; ?></td></tr><?php } ?>
</table>

<br/>
<div class="wpu_subheading">PHP functions <span> ( Hackers may use some functions which you don't use; it would be better to disable them. For example to disable the <kbd>shell_exec()</kbd> and the <kbd>system()</kbd> funtions use : <kbd> disable_functions = shell_exec,system</kbd>)</span></div>
<br><br><?php foreach ($functions as $key=>$value) {?>
<p><b><?php echo $key; ?> : </b><?php echo $value[1]?> </p>
<table class="widefat">
<tr><th width="20%">Function name</th><th width="20%">Status</th><th></th></tr>
<?php foreach ($value[0] as $k=>$v) {?>
<tr><td><?php echo $k; ?></td><td class="<?php if("Enabled"==$v){if($value[2]==ERROR_CRITICAL)echo "wpu_err";if($value[2]==ERROR_WARNING)echo "wpu_warn";if($value[2]==ERROR_NOTICE)echo "wpu_info";} ?>"><?php echo $v; ?></td><td></td></tr><?php 
}?></table><?php }?>
</div>
<div id="wpu_ssc_footer"></div>