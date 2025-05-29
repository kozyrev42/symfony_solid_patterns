<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_dynamic_01.svg" alt="Symfony Logo"></a>
</p>

1. Создание нового проекта:
`composer create-project symfony/website-skeleton symfony_solid_patterns`

- Запуск встроенного сервера:`php -S localhost:8030 -t public`,
`APP_ENV=dev php -S localhost:8030 -t public public/index.php`

2. Принцип единственной ответственности (SRP — Single Responsibility Principle).
 Гласит: "Класс должен иметь только одну причину для изменения".

 Разобраны пример/анти-пример SRP.
 