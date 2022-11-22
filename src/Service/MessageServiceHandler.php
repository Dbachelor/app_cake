<?php
namespace App\MessageHandler;

use App\Message\EmailNotification;
use App\Service\MessageService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;


class MessageServiceHandler implements MessageHandlerInterface
{

    public function __construct()
    {
       // $this->mailer = $mailer;
    }

    public function __invoke(MessageService $message)
    {
      return $message->createMessage();
    }
}