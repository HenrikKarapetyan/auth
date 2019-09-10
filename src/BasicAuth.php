<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/10  8:8:30.
 */

namespace henrik\auth;


use henrik\auth\exceptions\PasswordException;
use henrik\auth\helpers\PasswordHelper;
use henrik\auth\interfaces\AuthUserInterface;

/**
 * Class BasicAuth
 * @package henrik\auth
 */
class BasicAuth extends Auth
{
    /**
     * @param AuthUserInterface $userToAuthenticate
     * @param $submittedPassword
     * @throws PasswordException
     * @throws exceptions\LoginAttemptsLimitException
     */
    public function login(AuthUserInterface $userToAuthenticate, $submittedPassword)
    {
        $this->checkLoginAttempts();
        $this->checkUserCredentialsValidity($userToAuthenticate, $submittedPassword);
        $this->loginUser($userToAuthenticate);

    }

    /**
     * @param AuthUserInterface $userToAuthenticate
     * @param $submittedPassword
     * @throws PasswordException
     */
    public function checkUserCredentialsValidity(AuthUserInterface $userToAuthenticate, $submittedPassword)
    {
        if (!PasswordHelper::verify($userToAuthenticate->getAuthPassword(), $submittedPassword)) {
            throw new PasswordException(
                'The supplied password is incorrect for the user {' . $userToAuthenticate->getAuthUsername() . '}'
            );
        }
    }
}