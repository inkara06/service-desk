# QazaqGaz Service Desk (Laravel)

Веб-приложение Service Desk для создания и обработки заявок (tickets) с ролями **User** и **Admin**.  
Пользователь создаёт заявки и видит их статус, администратор управляет заявками (статус, исполнитель, срок) и использует поиск/фильтры.

---

## Стек

- **PHP** (Laravel)
- **Blade** + **Tailwind CSS**
- **Vite** (сборка фронтенд-ассетов, создаёт `public/build/manifest.json`)
- База данных: **SQLite** (для тестов/CI) или **MySQL** (локально/прод)

---

## Возможности

### User
- Создание заявки
- Просмотр списка своих заявок
- Фильтрация списка по статусу (`?status=in_progress`, `?status=done`)
- Дашборд со статистикой и превью заявок “В обработке”

### Admin
- Просмотр всех заявок
- Быстрый поиск по заявкам (поле `q`)
- Расширенный поиск (выпадающий блок) с фильтрами:
  - статус
  - приоритет
  - исполнитель
  - даты (from/to по `created_at`)
- Изменение:
  - статуса
  - исполнителя
  - срока (due_date)

---

## Роли и доступ

- Роль хранится в `users.role` (например: `user`, `admin`)
- Админ-роуты доступны по префиксу `/admin` и защищены middleware `admin`
  - `GET /admin/tickets` — список заявок
  - `PATCH /admin/tickets/{ticket}/status` — обновление статуса/исполнителя/срока

---

## Установка и запуск (локально)

### 1) Клонировать и установить зависимости PHP
```bash
composer install
cp .env.example .env
php artisan key:generate

2) Установить зависимости Node и собрать ассеты (Vite)

Важно: в проекте используется @vite(...), поэтому для корректного рендера страниц нужен public/build/manifest.json.

npm install
npm run dev
# или для прод-сборки:
npm run build

3) Настроить базу данных

Вариант A: MySQL (локально)
В .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=service_desk
DB_USERNAME=root
DB_PASSWORD=

Затем:

php artisan migrate

Вариант B: SQLite 
В .env:

DB_CONNECTION=sqlite

Создать файл базы:

touch database/database.sqlite
php artisan migrate

4) Запуск сервера

php artisan serve

Открыть: http://127.0.0.1:8000

⸻

Тесты

php artisan test

Если тесты падают с ошибкой вида:
ViteManifestNotFoundException: public/build/manifest.json

Сделайте сборку ассетов:

npm install
npm run build


⸻

CI (GitHub Actions)

В CI используется:
	•	установка PHP зависимостей (composer install)
	•	настройка SQLite
	•	миграции
	•	установка Node зависимостей
	•	npm run build (чтобы появился public/build/manifest.json)
	•	запуск тестов php artisan test

⸻

Основные маршруты

User
	•	GET /dashboard — дашборд
	•	GET /tickets — мои заявки
	•	GET /tickets/create — форма создания
	•	POST /tickets — создание заявки

Admin
	•	GET /admin/tickets — админка (поиск/фильтры/управление)
	•	PATCH /admin/tickets/{ticket}/status — обновления заявки

⸻

Примечания по интерфейсу
	•	UI сделан в стиле QazaqGaz (градиентные акценты, светлая тема)
	•	Для фильтров и пагинации используются query-параметры, например:
	•	/tickets?status=in_progress
	•	/admin/tickets?q=printer&status=in_progress&from=2026-01-01&to=2026-01-31

