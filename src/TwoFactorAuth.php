<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/10  8:8:45.
 */

namespace henrik\auth;


use henrik\auth\exceptions\TwoFactorAuthException;
use henrik\auth\helpers\TwoFactorAuthentication;
use henrik\auth\interfaces\AuthUserInterface;

/**
 * Class TwoFactorAuth
 * @package henrik\auth
 */
class TwoFactorAuth extends BasicAuth
{

    /**
     * @param AuthUserInterface $userToAuthenticate
     * @param $submittedPassword
     * @param $submittedTwoFactorSecret
     * @throws TwoFactorAuthException
     * @throws exceptions\LoginAttemptsLimitException
     * @throws exceptions\PasswordException
     */
    public function login(AuthUserInterface $userToAuthenticate, $submittedPassword, $submittedTwoFactorSecret)
    {
        $this->checkLoginAttempts();
        parent::checkUserCredentialsValidity($userToAuthenticate, $submittedPassword);
        $this->checkUserCredentialsValidity($userToAuthenticate, $submittedPassword, $submittedTwoFactorSecret);
        $this->loginUser($userToAuthenticate);
    }

    /**
     * @param AuthUserInterface $userToAuthenticate
     * @param $submittedPassword
     * @param $submittedTwoFactorSecret
     * @throws TwoFactorAuthException
     */
    public function checkUserCredentialsValidity($userToAuthenticate, $submittedPassword, $submittedTwoFactorSecret)
    {
        if (TwoFactorAuthentication::required($userToAuthenticate)) {
            if (is_null($submittedTwoFactorSecret) || !TwoFactorAuthentication::verify($userToAuthenticate->getTwoFactorSecret(), $submittedTwoFactorSecret)) {
                throw new TwoFactorAuthException('The supplied 2fa secret is incorrect for the user {' . $userToAuthenticate->getAuthUsername() . '}');
            }
        }
    }
}