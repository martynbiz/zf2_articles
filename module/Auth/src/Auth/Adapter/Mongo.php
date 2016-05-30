<?php
namespace Auth\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class Mongo implements AdapterInterface
{
    /**
     * @var string
     */
    private $identity;

    /**
     * @var string
     */
    private $credential;

    /**
     * Set the identity and return $this to allow chaining
     * @param string $identity
     * @return Auth\Adapter\Mongo
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * Set the identity and return $this to allow chaining
     * @param string $credential
     * @return Auth\Adapter\Mongo
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *               If authentication cannot be performed
     */
    public function authenticate()
    {
        $code = Result::SUCCESS;
        $identity = $this->identity;
        $result = new Result($code, $identity);

        return $result;
    }
}
