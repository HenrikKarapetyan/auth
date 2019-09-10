<?php


namespace henrik\auth;


use henrik\session\Session;

/**
 * Class AbstractAuth
 * @package henrik\auth
 */
abstract class AbstractAuth
{
    /**
     * @var int
     */
    protected $auth_type;
    /**
     * @var integer
     */
    protected $maxLoginAttempts;
    /**
     * @var string
     */
    protected $segmentKey = 'auth';
    /**
     * @var Session
     */
    protected $session;

    /**
     * @return int
     */
    public function getLoginRequestBlockingTime()
    {
        return $this->login_request_blocking_time;
    }

    /**
     * @param int $login_request_blocking_time
     */
    public function setLoginRequestBlockingTime($login_request_blocking_time)
    {
        $this->login_request_blocking_time = $login_request_blocking_time;
    }

    /**
     * @var int
     */
    protected $login_request_blocking_time = 3600; // 2 hours

    /**
     * @return int
     */
    public function getMaxLoginAttempts()
    {
        return $this->maxLoginAttempts;
    }

    /**
     * @param int $maxLoginAttempts
     */
    public function setMaxLoginAttempts($maxLoginAttempts)
    {
        $this->maxLoginAttempts = $maxLoginAttempts;
    }

    /**
     * @return string
     */
    public function getSegmentKey()
    {
        return $this->segmentKey;
    }

    /**
     * @param string $segmentKey
     */
    public function setSegmentKey($segmentKey)
    {
        $this->segmentKey = $segmentKey;
    }
}