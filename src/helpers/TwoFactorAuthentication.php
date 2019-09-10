<?php
namespace henrik\auth\helpers;


use henrik\auth\interfaces\AuthUserInterface;
use henrik\auth\interfaces\TwoFactorAuthenticationInterface;

/**
 * Class TwoFactorAuthenticationInterface
 * @package henrik\auth
 */
class TwoFactorAuthentication implements TwoFactorAuthenticationInterface
{
    /**
     * @param $savedSecret
     * @param $submittedSecret
     * @return bool
     */
    public static function verify($savedSecret, $submittedSecret)
    {
        return $submittedSecret == $savedSecret;
    }

    /**
     * @param AuthUserInterface $userToAuthenticate
     * @return bool|mixed
     */
    public static function required(AuthUserInterface $userToAuthenticate)
    {
        return !is_null($userToAuthenticate->getTwoFactorSecret());
    }

}