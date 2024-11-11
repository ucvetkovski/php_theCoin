<?php
define("BASE_URL", "http://localhost/social/%22");
define("ABSOLUTE_PATH", $_SERVER["DOCUMENT_ROOT"] . "/social");
define("ENV_FAJL", ABSOLUTE_PATH . "/config/.env");

define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));

define("key", env("API_KEY"));

function env($naziv)
{
    $open = fopen(ENV_FAJL, "r");
    $podaci = file(ENV_FAJL);
    $vrednost = "";
    foreach ($podaci as $key => $value) {
        $konfig = explode("=", $value);
        if ($konfig[0] == $naziv) {
            $vrednost = trim($konfig[1]); // trim() zbog \n
        }
    }
    return $vrednost;
}
?>