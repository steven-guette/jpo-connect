<?php
namespace Core\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Mailer {
    private PHPMailer $mailer;
    private Environment $twig;
    
    /**
     * @throws Exception
     */
    public function __construct() {
        $this->mailer = new PHPMailer(true);
        
        if (getenv('MAILER_SMTP') === 'true') {
            $this->mailer->isSMTP();
            $this->mailer->Host = getenv('MAILER_HOST');
            $this->mailer->Port = (int) getenv('MAILER_PORT');
            $this->mailer->SMTPAuth = !empty(getenv('MAILER_USERNAME'));
            $this->mailer->Username = getenv('MAILER_USERNAME');
            $this->mailer->Password = getenv('MAILER_PASSWORD');
            $this->mailer->SMTPSecure = getenv('MAILER_ENCRYPTION');
        } else {
            $this->mailer->isMail();
        }
        
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->setFrom(
            getenv('MAILER_FROM') ?: 'no-reply@whitecat.fr',
            getenv('MAILER_FROM_NAME') ?: 'JPO :: La Plateforme_'
        );
        $this->mailer->isHTML();
        
        $loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates/emails');
        $this->twig = new Environment($loader);
    }
    
    /**
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array $data
     * @return bool
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function send(string $to, string $subject, string $template, array $data): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            
            $html = $this->twig->render($template, $data);
            $this->mailer->Body = $html;
            $this->mailer->AltBody = strip_tags($html);
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}