Создать приложение используя Symfony последней версии (не ниже 4) на котором пользователи будут размещать свои посты с новостями.

Для реализации приложения необходимо пользоваться Symfony bundles(например, 30 самых популярных, из которых будете использовать несколько), работа с БД через Doctrine. Обязательно использовать: FOSUserBundle, Timestampable, Sluggable, Migrations.

На фронте Bootstrap 4 по желанию, но можно и без него.

Структура проекта:

- в Header:
    Если пользователь не авторизован:
        Название приложения
        Ссылка на домашнюю страницу Home
        Ссылка на страницу Login

    Если пользователь авторизован:
        Название приложения
        Ссылка на домашнюю страницу Home
        Ссылка на страницу NewPost
        Ссылка на страницу MyPosts
        Ссылка на страницу Logout

- в Body:
    1. Главная страница
        Список постов с новостями. Название новости содержит дату ее обновления и её Title. Сортировка происходит в порядке свежести. При нажатии на новость попадаем на страницу просмотра новости.
        Добавить пагинацию, выводить по 5 постов на страницу

    2. Страница Login
        Стандартная форма авторизации
        Ссылка на страницу Register

    3. Страница Register
        Стандартная форма регистрации

    4. Страница NewPost
        Форма для создания новости
        - title
        - content
        - кнопка create

    5. Страница MyPost
        Список постов с новостями, которые были созданы данным пользователем.
        На против каждой новости есть две кнопки:
        Edit(открывает страницу редактирования новости)
        Delete(удаляет новость)

    6. Страница просмотра новости
        Если пользователь не авторизован:
            Видит саму новость и комментарии к ней.
            Не может оставлять комментарии
            Кнопка возвращения к списку

        Если пользователь авторизован:
            Видит саму новость и комментарии к ней.
            Может оставлять комментарии к новости
            Кнопка возвращения к списку

PS: Самое важное это не внешний вид приложения, а то как Вы думаете, организовуете код и умеете искать недостающую информацию.

Будем смотреть на Entities, Controllers, twig templates, Services(если будут)

1) php bin/console doctrine:database:create
2) php bin/console doctrine:schema:update --force
