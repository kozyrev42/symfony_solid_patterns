<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 * Принцип D - принцип инверсии зависимостей. Dependency Inversion Principle (DIP):
 * Модули верхнего уровня не должны зависеть от модулей нижнего уровня.
 * И те, и другие должны зависеть от абстракций.
 * Абстракции не должны зависеть от деталей. Детали должны зависеть от абстракций. 
 * 
 * ---
 * 
 * Анти‑пример нарушения Dependency Inversion Principle (D из SOLID).
 * NotificationService знает о конкретном классе EmailSender и
 * жёстко создаёт его внутри — высокоуровневый модуль зависит от детали.
 * 
 * ---
 * 
 * В анти-примере NotificationService сам создаёт EmailSender,
 * то есть модуль верхнего уровня зависит от нижнего уровня напрямую. Это нарушает принцип Dependency Inversion
 * 
 * ---
 * 
 * Принцип инверсии зависимостей позволяет мне проектировать код,
 *  в котором высокоуровневые модули не привязаны к конкретным реализациям,
 *  а работают с абстракциями. Это облегчает тестирование, замену деталей и повышает гибкость архитектуры.
 * 
 * bin/console solid:bad:d
 */
#[AsCommand(
    name: 'solid:bad:d',
    description: 'Нарушение принципа Dependency Inversion — жёсткая зависимость от деталей'
)]
class SolidDBadCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $service = new NotificationService();            // жёстко привязан к EmailSender
        $service->notify('Hello, DIP is broken!');

        // если захотим отправлять SMS, придётся редактировать NotificationService
        return Command::SUCCESS;
    }
}

/**
 * 
 *  Модуль верхнего уровня.
 *  Это бизнес-логика. Она отвечает за отправку уведомлений,
 *  и должна быть гибкой и масштабируемой.
 * 
 *  Она определяет что делать, но не должна заботиться о том, как именно это делается.
 */
class NotificationService
{
    /** Высокоуровневый модуль напрямую создаёт EmailSender → нарушение DIP */
    public function notify(string $message): void
    {
        $sender = new EmailSenderBad(); // ← конкретная реализация внутри EmailSender
        $sender->sendEmail($message);
    }
}

/**
 * 
 * Модуль низкого уровня. Детали реализации.
 * 
 * Это техническая реализация, то есть механизм отправки сообщений.
 */
class EmailSenderBad
{
    public function sendEmail(string $message): void
    {
        echo "[Email] $message\n";
    }
}
