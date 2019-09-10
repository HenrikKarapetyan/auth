<?php

namespace henrik\auth\interfaces;

/**
 * Interface TwoFactorAuthenticationInterface
 * @package henrik\auth\interfaces
 */
interface TwoFactorAuthenticationInterface
{

    /**
     * @param $savedSecret
     * @param $submittedSecret
     * @return bool
     */
    public static function verify($savedSecret, $submittedSecret);

    /**
     * @param AuthUserInterface $userToAuthenticate
     * @return mixed
     */
    public static function required(AuthUserInterface $userToAuthenticate);
}