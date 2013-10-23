<?php
loadFile("libs/Random.class.php");

class Csrf {
    const key = "__token";

    public static function setToken($view) {
        $token = Random::get("Csrf");
        setcookie(self::key, $token, time() + 5 * MINUTE, "/twitter/", "service.tnnsst35.com");
        $view->assign(self::key, $token);
    }

    public static function checkToken() {
        $postToken   = postParam(self::key);
        $cookieToken = isset($_COOKIE[self::key]) ? $_COOKIE[self::key] : null;
        setcookie(self::key, "", 0, "/twitter/", "service.tnnsst35.com");
        return $postToken === $cookieToken;
    }
}
