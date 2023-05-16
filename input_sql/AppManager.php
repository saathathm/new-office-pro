<?php
set_time_limit(0);
// application manager
class AppManager {

    private static $pm; // persistance manager
    // get persistance manager

    public static function getPM() {
        if (self::$pm === null) {
            include_once 'PersistanceManager.php';
            self::$pm = new PersistanceManager();
        }
        return self::$pm;
    }
}

?>