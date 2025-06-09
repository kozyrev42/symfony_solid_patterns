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
 * 
 * Высокоуровневые модули (бизнес-логика) не должны зависеть от низкоуровневых (реализаций),
 * и те и другие должны зависеть от абстракций (Интерфейсов).
 * 
 * 
 * В нашем примере NotificationService (высокоуровневый модуль) зависит от MessageSenderInterface,
 * а не от конкретных реализаций EmailSender или SmsSender.
 * Это делает код гибким и легко масштабируемым.
 *
 * 
 * bin/console solid:good:d 
 */
#[AsCommand(
    name: 'solid:good:d',
    description: 'Хороший пример: Dependency Inversion Principle',
)]
class SolidDGoodCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // NotificService - по очереди принимает объекты нижнего уровня (EmailSender, SmsSender)
        // и использует их для отправки уведомлений
        // При необходимости можно легко добавить ещё один модуль нижнего уровня!
        // Потому-что NotificService зависит от абстракции (MessageSenderInterface).
        $emailService = new NotificService(new EmailSender());
        $smsService = new NotificService(new SmsSender());

        $output->writeln("-- Email уведомление:");
        $emailService->notify("Ваш заказ доставлен!");

        $output->writeln("\n-- SMS уведомление:");
        $smsService->notify("Ваш код подтверждения: 1234");

        return Command::SUCCESS;
    }
}


// Абстракция (Интерфейс). 
interface MessageSenderInterface
{
    public function send(string $message): void;
}

// NotificationService (модуль верхнего уровня) зависит от абстракции (Интерфейса).
class NotificService
{
    public function __construct(
        private MessageSenderInterface $sender
    ) {}

    public function notify(string $message): void
    {
        $this->sender->send($message);
    }
}


//  Реализация (модуль нижнего уровня).
class EmailSender implements MessageSenderInterface
{
    public function send(string $message): void
    {
        echo "[EmailSender] Отправка Email: $message\n";
    }
}


//  Ещё одна реализация(модуль нижнего уровня).
class SmsSender implements MessageSenderInterface
{
    public function send(string $message): void
    {
        echo "[SmsSender] Отправка SMS: $message\n";
    }
}
