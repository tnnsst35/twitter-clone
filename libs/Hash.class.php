<?php
class Hash {
    public function passwordHash($password) {
        $stretch = 10000;
        $salt    = "20111026_Sunrise_s-taninishi_t-arai_k-cho_k-hamada";
        $hash    = $password;
        for ($i = 0;$i < $stretch;$i++) {
            $hash = hash("sha256", $hash . $salt);
        }
        return mb_substr($hash, 0, 32);
    }
}
