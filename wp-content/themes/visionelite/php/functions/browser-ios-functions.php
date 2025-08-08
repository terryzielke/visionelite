<?php

/*
	GET BROWSER AND OS INFO
*/
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'microsoftwindows',
                          '/windows nt 6.3/i'     =>  'microsoftwindows',
                          '/windows nt 6.2/i'     =>  'microsoftwindows',
                          '/windows nt 6.1/i'     =>  'microsoftwindows',
                          '/windows nt 6.0/i'     =>  'microsoftwindows',
                          '/windows nt 5.2/i'     =>  'microsoftwindows',
                          '/windows nt 5.1/i'     =>  'microsoftwindows',
                          '/windows xp/i'         =>  'microsoftwindows',
                          '/windows nt 5.0/i'     =>  'microsoftwindows',
                          '/windows me/i'         =>  'microsoftwindows',
                          '/win98/i'              =>  'microsoftwindows',
                          '/win95/i'              =>  'microsoftwindows',
                          '/win16/i'              =>  'microsoftwindows',
                          '/macintosh|mac os x/i' =>  'appleosx',
                          '/mac_powerpc/i'        =>  'appleosx',
                          '/linux/i'              =>  'linux',
                          '/ubuntu/i'             =>  'ubuntu',
                          '/iphone/i'             =>  'appleios',
                          '/ipod/i'               =>  'appleios',
                          '/ipad/i'               =>  'appleios',
                          '/android/i'            =>  'android',
                          '/blackberry/i'         =>  'blackberry',
                          '/webos/i'              =>  'mobilephone'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'internetexplorer',
                            '/firefox/i'   => 'firefox',
                            '/safari/i'    => 'safari',
                            '/chrome/i'    => 'chrome',
                            '/edge/i'      => 'edge',
                            '/opera/i'     => 'opera',
                            '/netscape/i'  => 'netscape',
                            '/maxthon/i'   => 'maxthon',
                            '/konqueror/i' => 'konqueror',
                            '/mobile/i'    => 'handheldbrowser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}