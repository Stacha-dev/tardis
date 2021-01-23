<?php

declare(strict_types=1);

namespace App\Controller;

use App\Lib\Middleware\RouteFactory;
use Exception;

final class Mail extends Base
{

	/**
	 * Parse routes
	 *
	 * @param  \App\Lib\Middleware\Router $router
	 * @return void
	 */
	public function registerRoutes(\App\Lib\Middleware\Router $router): void
	{
		$router->register(RouteFactory::fromConstants(1, "POST", "@^(?<version>[0-9])/mail$@", "sendMail"));
	}


	/**
	 * Send Mail
	 */
	public function sendMail(string $to = '', string $subject = '', string $content = ''): bool
	{
		$body = $this->request->getBody();
		$to = $body->getBodyData('to') ?? $to;
		$subject = $body->getBodyData('subject') ?? $subject;
		$content = $body->getBodyData('content') ?? $content;

		$mail = new \App\Lib\Mailer\Mail($to, $subject, $content);
		$mail->setFrom('Chip the Cat', 'chip@project-release.stacha.dev'); // to be set in config file
		$status = $mail->send();

		$this->view->render(array("status" => $status));
		return $status;
	}
}
