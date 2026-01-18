# Products API

Реализация поиска по товарам с фильтрами, сортировкой и пагинацией.

## Установка

1. **Клонируйте репозиторий:**
   ```bash
   git clone https://github.com/vlad1self/products-api.git
   cd products-api
   ```

2. **Установите зависимости:**
   ```bash
   composer install
   ```

3. **Настройте окружение:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Запустите миграции и сидеры:**
   ```bash
   php artisan migrate --seed
   ```

5. **Запустите локальный сервер:**
   ```bash
   php artisan serve
   ```

## Возможности
- Поиск по названию (параметр `q`)
- Фильтрация по цене (`price_from`, `price_to`)
- Фильтрация по категории (`category_id`)
- Фильтрация по наличию (`in_stock`)
- Фильтрация по минимальному рейтингу (`rating_from`)
- Сортировка (`sort`): `price_asc`, `price_desc`, `rating_desc`, `newest`
- Пагинация (10 товаров на страницу)
- Единый формат API ответов через `ApiResponse`

## Использование API

### GET /api/products

**Параметры запроса:**
- `q` - поиск по подстроке в названии
- `price_from`, `price_to` - диапазон цен
- `category_id` - ID категории
- `in_stock` - в наличии (true/false)
- `rating_from` - минимальный рейтинг
- `sort` - сортировка (`price_asc`, `price_desc`, `rating_desc`, `newest`)
- `page` - номер страницы

**Пример запроса:**
`GET /api/products?q=iPhone&price_from=50000&sort=price_desc&in_stock=true`

**Пример ответа:**
```json
{
    "data": {
        "items": [
            {
                "id": 1,
                "name": "Apple iPhone 15 Pro",
                "price": "129999.00",
                "category": {
                    "id": 1,
                    "name": "Смартфоны"
                },
                "in_stock": true,
                "rating": 4.8,
                "created_at": "2024-01-16 12:00:00",
                "updated_at": "2024-01-16 12:00:00"
            }
        ],
        "timestamp": "2024-01-18 13:15:00"
    },
    "meta": {
        "total": 2,
        "count": 2,
        "per_page": 10,
        "current_page": 1,
        "total_pages": 1
    },
    "status": {
        "code": 200,
        "message": "Успешно",
        "description": "Успешно"
    }
}
```

## Тестирование
Запуск тестов:
```bash
php artisan test
```
Тесты покрывают:
- Листинг товаров
- Все виды фильтрации
- Все виды сортировки
- Валидацию входных данных
- Структуру JSON ответа
