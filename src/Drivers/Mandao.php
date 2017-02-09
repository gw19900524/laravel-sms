<?php

namespace Gw19900524\Sms\Drivers;

class Mandao
{
    protected $parameters = [
        'url' => '',
        'port' => '',
        'sn' => '',
        'secret' => '',
    ];
    
    /**
     *
     * Send the message to the mobiles.
     * 
     * @param  string   $mobiles
     * @param  string  $content
     * @return bool
     */
    public function send($mobiles, $content)
    {
        $argv = array( 
            'sn' => $this->getSn(),
            'pwd' => strtoupper(md5($this->getSn().$this->getSecret())), 
            'mobile' => $mobiles,
            'content' => $content,
            'ext' => '',		
            'stime' => '',
            'rrid' => '',
        );
        $flag = 0; 
        $params = ""; 
        foreach ($argv as $key=>$value) { 
            if ($flag!=0) { 
                $params .= "&"; 
                $flag = 1; 
            } 
            $params.= $key."="; 
            $params.= urlencode($value); 
            $flag = 1; 
        }
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $this->getUrl()); 
        curl_setopt($ch, CURLOPT_PORT, $this->getPort());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $result = curl_exec($ch);
        curl_close($ch);
        preg_match('/<string xmlns="http:\/\/tempuri.org\/">(.*)<\/string>/', $result, $matches);
        if ($matches[1] > 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        
        $this->parameters[$key] = $value;

        return $this;
    }
    
    /**
     * @param $value
     *
     * @return $this
     */
    public function setUrl($value)
    {
        return $this->setParameter('url', $value);
    }
    
    /**
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->getParameter('url');
    }
    
    /**
     * @param $value
     *
     * @return $this
     */
    public function setPort($value)
    {
        return $this->setParameter('port', $value);
    }
    
    /**
     *
     * @return mixed
     */
    public function getPort()
    {
        return $this->getParameter('port');
    }
    
    /**
     * @param $value
     *
     * @return $this
     */
    public function setSn($value)
    {
        return $this->setParameter('sn', $value);
    }
    
    /**
     *
     * @return mixed
     */
    public function getSn()
    {
        return $this->getParameter('sn');
    }
    
    /**
     * @param $value
     *
     * @return $this
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }
    
    /**
     *
     * @return mixed
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }
}