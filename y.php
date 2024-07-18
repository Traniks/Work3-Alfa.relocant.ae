<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (class_exists('Memcache')) {
    $server = 'localhost';
    if (!empty($_REQUEST['server'])) {
        $server = $_REQUEST['server'];
    }
    $memcache = new Memcache();
    $isMemcacheAvailable = @$memcache->connect($server,11211);

    if ($isMemcacheAvailable) {
        $aData = $memcache->get('data');
        echo '<pre>';
        if ($aData) {
            echo '<h2>Data from Cache:</h2>';
            print_r($aData);
        } else {
            $aData = array(
                'me' => 'you',
                'us' => 'them',
            );
            echo '<h2>Fresh Data:</h2>';
            print_r($aData);
            $memcache->set('data', $aData, 0, 300);
        }
        $aData = $memcache->get('data');
        if ($aData) {
            echo '<h3>Memcache seem to be working fine!</h3>';
        } else {
            echo '<h3>Memcache DOES NOT seem to be working!</h3>';
        }
        echo '</pre>';
    }
	
if (!$isMemcacheAvailable) {
    echo '<h3>Memcache not available</h3>';
}	
}

if (class_exists('Memcached')) {
try

{
    $memcached = new Memcached();
    $memcached->addServer("localhost", 11211); 
    $response = $memcached->get("sample_key");
 
    if($response==true) 
    {
      echo $response;
    } 

    else

    {
    echo "<h3>CacheD is empty</h3>";
    $memcached->set("sample_key", "Sample data from cache") ;
    }
}
catch (exception $e)
{
echo $e->getMessage();
}
}


echo '<hr>';
echo time();
echo '<hr>';
phpinfo();
?>