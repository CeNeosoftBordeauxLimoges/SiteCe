<?php

namespace Extranet\UtilisateurBundle\Service;

class Mailer
{

    protected $mailer;
    protected $templating;
    protected $router;

    public function __construct($mailer, \Twig_Environment $templating, $router)
    {
        $this->mailer      = $mailer;
        $this->templating  = $templating;
        $this->router      = $router;
    }

    public function getMessage($identifier, $parameters = array())
    {
        $template = $this->templating->loadTemplate($identifier);

        $subject  = $template->renderBlock('subject',   $parameters);
        $bodyHtml = $template->renderBlock('body_html', $parameters);
        $bodyText = $template->renderBlock('body_text', $parameters);

        return \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setBody($bodyText, 'text/plain')
            ->addPart($bodyHtml, 'text/html')
        ;
    }

    public function send($message)
    {
        if ($this->mailer->send($message)) {
            return true;
        }

        return false;
    }
}
