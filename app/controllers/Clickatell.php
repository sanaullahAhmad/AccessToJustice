<?php
//use app\config\clickatell;
class Clickatell
{
    private static $to = array();
    private static $message = false;
    public function to($number = false)
    {
        if (is_array($number)) {
            foreach($number as $n) {
                self::$to[] = $this->format_number($n);
            }
        } else {
            self::$to[] = $this->format_number($number);
        }
        return $this;
    }
    public function message($message)
    {
        self::$message = $message;
        return $this;
    }
    public function send()
    {
        // Check to see if recipients and a message have been specified
        if ( (count(self::$to) == 0) or (self::$message === false) ) {
            return 'Required attributes (to and message) have not been set.';
        }
        // Load the config
        $config = Config::get('clickatell::clickatell');
        //print_r($config);exit;
        $uri = array(
            'api_id=UUx__dq3TMGz7NgrcFMJNQ==' /*. $config['api_id']*/,
            'user=Accesstojustice' /*. $config['user']*/,
            'password=hamid266' /*. $config['password']*/,
            'to=' . implode(',', self::$to),
            'text=' . str_replace(' ', '+', self::$message)
        );
        $url = /*$config['base_url']*/ 'https://api.clickatell.com'. '/http/sendmsg?' . implode('&', $uri);
        $request = file($url);
        $reply = explode(':', $request[0]);
        if ($reply[0] == "ID") {
            // The message has been sent
            return array('status' => 'success', 'id' => $reply[1]);
        } else if ($reply[0] == "ERR") {
            // Something went wrong
            return array('status' => 'failed', 'message' => $reply[1]);
        }
    }
    private function format_number($number)
    {
        return trim($number, " +");
    }
}