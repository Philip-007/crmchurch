<?php

namespace ChurchCRM\Emails;

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\User;


abstract class BaseUserEmail extends BaseEmail
{
    protected $user;

    /**
     * BaseUserEmail constructor.
     * @param $user User
     */
    public function __construct($user)
    {
        parent::__construct([$user->getEmail()]);
        $this->user = $user;
        $this->mail->Subject = SystemConfig::getValue("sChurchName") . ": " . $this->getSubSubject();
        $this->mail->isHTML(true);
        $this->mail->msgHTML($this->buildMessage());
    }

    protected abstract function getSubSubject();

    public function getTokens()
    {
        $myTokens =  ["toName" => $this->user->getPerson()->getFirstName(),
            "userName" => $this->user->getUserName(),
            "userNameText" => gettext('Login Name'),
            "body" => $this->buildMessageBody()
        ];
        return array_merge($this->getCommonTokens(), $myTokens);
    }

    protected abstract function buildMessageBody();
}
