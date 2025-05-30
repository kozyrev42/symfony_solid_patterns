<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_dynamic_01.svg" alt="Symfony Logo"></a>
</p>

1. Создание нового проекта:
`composer create-project symfony/website-skeleton symfony_solid_patterns`

- Запуск встроенного сервера:`php -S localhost:8030 -t public`,
`APP_ENV=dev php -S localhost:8030 -t public public/index.php`

2. Принцип единственной ответственности (SRP — Single Responsibility Principle).
- Гласит: "Класс должен иметь только одну причину для изменения".

- Разобраны пример/анти-пример SRP.
 
3. Принцип O - открытости/закрытости (Open/Closed Principle, OCP)
- "Сущности (классы, модули, функции) должны быть открыты для расширения, но закрыты для изменения."
- Это значит, что поведение системы можно расширять, не изменяя уже написанный код.
- Например: Мы можем добавлять новые типы сотрудников (например, класс Intern добавлять в цикл для обработки), не изменяя существующий код.
