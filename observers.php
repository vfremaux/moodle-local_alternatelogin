<?php

class local_alternatelogin_observer {

    public static function on_user_created(\core\event\user_created $event) {
        // Process additional data.
        assert(1);
        return true;
    }

}