<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/10  8:4:39.
 */

namespace henrik\auth;


use DateTime;
use henrik\auth\exceptions\LoginAttemptsLimitException;
use henrik\auth\exceptions\RepeatableWrongPasswordException;
use henrik\auth\interfaces\AuthUserInterface;
use henrik\session\Session;

/**
 * Class Auth
 * @package henrik\auth
 */
class Auth extends AbstractAuth
{
    /**
     * Auth constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->session->setSegmentName($this->segmentKey);
    }

    /**
     * @param AuthUserInterface $userToAuthenticate
     */
    public function loginUser(AuthUserInterface $userToAuthenticate)
    {
        $loggedInUserId = $userToAuthenticate->getAuthId();
        $this->session->set('loggedInUserId', $loggedInUserId);
        /**
         * when user is authenticated no needs  to  serve login attempts history
         */
        $this->resetLoginAttempts();
    }

    /**
     *
     */
    public function resetLoginAttempts()
    {
        $this->session->set('loginAttempts', 0);
    }

    /**
     *
     * @throws LoginAttemptsLimitException
     * @throws RepeatableWrongPasswordException
     */
    protected function checkLoginAttempts()
    {
        $loginAttempts = $this->session->get('loginAttempts', 0);
        $current_datetime = time();

        $nextLoginDate = $this->session->get('nextLoginDate', 0);
        if ($nextLoginDate > $current_datetime) {
            throw new RepeatableWrongPasswordException('Your login requests are  blocked. Try after ' . gmdate('Y-m-d H:i:s', $nextLoginDate));
        } else if (!is_null($this->maxLoginAttempts) && $loginAttempts >= $this->maxLoginAttempts) {
            $this->session->set('nextLoginDate', $current_datetime + $this->getLoginRequestBlockingTime());
            $this->session->set('loginAttempts', 0);
            throw new LoginAttemptsLimitException('your login queries limit is expired try to reset your password');
        }
        $this->increaseLoginAttempts();
    }


    /**
     *
     */
    protected function increaseLoginAttempts()
    {
        $loginAttempts = $this->session->get('loginAttempts');
        $this->session->set('loginAttempts', $loginAttempts + 1);
    }

    /**
     *
     */
    public function logout()
    {
        $this->session->start();
        $this->session->clearSegment();
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return !is_null($this->getLoggedInUserId());
    }

    /**
     * @return int
     */
    public function getLoggedInUserId()
    {
        return $this->session->get("loggedInUserId", null);
    }

}