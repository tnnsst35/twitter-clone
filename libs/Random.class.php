<?php
class Random {
    public static function get($salt = '', $length = 32, $stretch = 10000) {
        $rand = time() . mt_rand();
        for ($i = 0;$i < $stretch;$i++) {
            $rand = hash("sha256", $rand . $salt);
        }
        return mb_substr($rand, 0, $length);
    }
}
