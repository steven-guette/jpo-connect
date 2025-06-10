<?php
namespace App\Notifications;

use App\Entities\JpoEvent;
use App\Entities\User;
use Core\Utils\Mailer;
use PHPMailer\PHPMailer\Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


final class NotificationsMailer extends Mailer {
    
    /**
     * @param User $user
     * @param JpoEvent $jpoEvent
     * @param array $managers
     * @return true
     * @throws Exception
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendRegistrationNotification(User $user, JpoEvent $jpoEvent, array $managers = []): bool {
        $template = 'registration.twig';
        $data = [ 'user' => $user, 'jpoEvent' => $jpoEvent ];
        
        $this->sendMailToManager($managers, "[Nouvelle inscription :: {$jpoEvent->getTitle()}] {$user->getFullName()}", $template, $data);
        return $this->sendMailToUser($user->getEmail(), "Confirmation d'inscription à la JPO : {$jpoEvent->getTitle()}", $template, $data);
    }
    
    /**
     * @param User $user
     * @param JpoEvent $jpoEvent
     * @param array $managers
     * @return true
     * @throws Exception
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendCancellationNotification(User $user, JpoEvent $jpoEvent, array $managers = []): bool {
        $template = 'cancellation.twig';
        $data = [ 'user' => $user, 'jpoEvent' => $jpoEvent ];
        
        $this->sendMailToManager($managers, "[Annulation d'inscription :: {$jpoEvent->getTitle()}] {$user->getFullName()}", $template, $data);
        return $this->sendMailToUser($user->getEmail(), "Annulation d'inscription à la JPO : {$jpoEvent->getTitle()}", $template, $data);
    }
    
    /**
     * @param array $managers
     * @param string $subject
     * @param string $template
     * @param array $data
     * @return void
     * @throws Exception
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function sendMailToManager(array $managers, string $subject, string $template, array $data): void {
        if (empty($managers)) return;
        foreach (array_filter($managers, fn($m) => $m instanceof User) as $manager) {
            $this->send($manager->getEmail(), $subject, $template, $data);
        }
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
    private function sendMailToUser(string $to, string $subject, string $template, array $data): bool {
        return $this->send($to, $subject, $template, $data);
    }
}