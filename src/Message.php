<?php

namespace Fabian\Mandrill;

use Nette\Mail\Message as NetteMessage;

/**
 * Provides similar API to Nette\Mail\Message 
 */
class Message extends NetteMessage
{
    /**
     * Message parameters
     * @var array
     */
    private $mandrillParams = [];

    /**
    * @inheritdoc
    */
    public function setFrom(string $email, ?string $name = NULL)
    {
        $this->mandrillParams['from_email'] = $email;
        if ($name !== null) {
            $this->mandrillParams['from_name'] = $name;
        }
        return $this;
    }

    /**
    * @inheritdoc
    */
    public function setBody(string $body)
    {
        $this->mandrillParams['text'] = $body;
        return $this;
    }
    
    /**
    * @inheritdoc
    */
    public function setHtmlBody(string $html, ?string $basePath = null)
    {
        $this->mandrillParams['html'] = $html;
        
        return $this;
    }
    
    /**
    * @inheritdoc
    */
    public function setSubject(string $subject)
    {
        $this->mandrillParams['subject'] = $subject;
        
        return $this;
    }
    
    /**
    * @inheritdoc
    */
    public function addTo(string $email, string $name = null)
    {
        if (!isset($this->mandrillParams['to'])) {
            $this->mandrillParams['to'] = [];
        }
        $recipient = ['email' => $email];
        if ($name !== null) {
            $recipient['name'] = $name;
        }
        $this->mandrillParams['to'][] = $recipient;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addReplyTo(string $email, ?string $name = null) {
        if (!isset($this->mandrillParams['headers'])) {
            $this->mandrillParams['headers'] = array();
        }
        $this->mandrillParams['headers']['Reply-To'] = $email;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addTag(string $tag)
    {
        if (!isset($this->mandrillParams['tags'])) {
            $this->mandrillParams['tags'] = [];
        }
        $this->mandrillParams['tags'][] = $tag;
        
        return $this;
    }
    
    /**
     * Enable a background sending mode that is optimized for bulk sending. In async mode, messages/send will immediately return a status of "queued" for every recipient. To handle rejections when sending in async mode, set up a webhook for the 'reject' event. Defaults to false for messages with no more than 10 recipients; messages with more than 10 recipients are always sent asynchronously, regardless of the value of async.
     * @inheritdoc
     */
    public function setAsync(bool $async = true)
    {
        $this->mandrillParams['async'] = $async;
        
        return $this;
    }
    
    /**
     * Add another Mandrill param
     * @param string $param
     * @param string $value
     * @return static
     */
    public function setParam(string $param, string $value)
    {
        $this->mandrillParams[$param] = $value;
        
        return $this;
    }
    
    /**
     * Returns Mandrill params
     * @return array
     */
    public function getMandrillParams(): array
    {
        return $this->mandrillParams;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return static
     */
    public function addBcc(string $email, string $name = null)
    {
        $this->mandrillParams['bcc_address'] = $email;
        
        return $this;
    }
}