# Woodmart Price Inquiry

Adds a **“Request Price”** button to Woodmart WooCommerce product pages with a built-in modal inquiry form and email delivery.

---

## 🇬🇧 English

### Description

**Woodmart Price Inquiry** is a lightweight demonstration plugin for WordPress that adds a **“Request Price”** button to WooCommerce product pages when using the **Woodmart theme**.

Instead of displaying a fixed product price, the plugin opens a **modal inquiry form**, allowing customers to request pricing details directly from the store owner.

The plugin is intentionally built as a **code-quality showcase**: clean architecture, clear separation of concerns, and extensibility-first design.

---

### Features

- “Request Price” button on Woodmart product pages
- Built-in modal inquiry form (no page reloads)
- Email delivery to the site administrator
- Two captcha strategies:
  - Simple built-in **math captcha**
  - Integration with **Contact Form 7** and **contact-form-7-image-captcha**
- No theme file modifications required
- Developer-friendly, extendable architecture

---

### Use Cases

- B2B WooCommerce stores with negotiable pricing
- Custom-made or configurable products
- Wholesale or quote-based sales models

---

### Requirements

- WordPress 6.0+
- WooCommerce
- Woodmart theme
- (Optional) Contact Form 7
- (Optional) contact-form-7-image-captcha

---

### Installation

1. Clone the repository into:
   ```
   wp-content/plugins/woodmart-price-inquiry
   ```
2. Activate **Woodmart Price Inquiry** in the WordPress admin panel
3. Open any Woodmart product page
4. Use the **“Request Price”** button

---

### Architecture Overview

The plugin follows a **modular, separation-of-concerns approach** and avoids monolithic procedural code.

**Conceptual layers:**

- **Bootstrap layer**
  - Plugin entry file
  - Dependency checks (WooCommerce, Woodmart)
- **Integration layer**
  - Woodmart hooks for product page rendering
  - WooCommerce product context abstraction
- **UI layer**
  - Button injection
  - Modal rendering
- **Form handling**
  - Validation
  - Captcha strategy (math / CF7)
  - Email delivery
- **Extensibility points**
  - Filters and actions for customization
  - Replaceable captcha and mail services

This structure demonstrates readiness for scaling without refactoring core logic.

---

### Roadmap

Planned and possible extensions (not all required for demo purposes):

- AJAX-based form submission
- Admin settings page (email, button text, captcha type)
- CRM integrations (AmoCRM, Bitrix24, HubSpot)
- Google Tag Manager events (form open / submit)
- reCAPTCHA / hCaptcha support
- Per-product enable/disable logic
- REST API endpoint for external integrations

---

### License

MIT License

---

## 🇷🇺 Русская версия

### Описание

**Woodmart Price Inquiry** — плагин для WordPress, который добавляет кнопку **«Запросить цену»** на страницы товаров WooCommerce при использовании темы **Woodmart**.

Кнопка добавляется **через хуки Woodmart и WooCommerce**, без переопределения шаблонов и без правок файлов темы.

Вместо отображения фиксированной цены плагин открывает **модальное окно с формой запроса**, позволяя клиенту отправить заявку напрямую владельцу магазина.

---

### Возможности

- Кнопка **«Запросить цену»** на странице товара Woodmart
- Встроенная модальная форма без перезагрузки страницы
- Отправка заявок на email администратора
- Два варианта защиты от спама:
  - Простая встроенная **математическая капча**
  - Интеграция с **Contact Form 7** и **contact-form-7-image-captcha**
- Не требует правок файлов темы
- Чистая и расширяемая архитектура

---

### Когда подходит

- B2B-магазины с договорной ценой
- Товары с индивидуальным расчётом стоимости
- Оптовые и кастомные заказы

---

### Требования

- WordPress 6.0+
- WooCommerce
- Тема Woodmart
- (Опционально) Contact Form 7
- (Опционально) contact-form-7-image-captcha

---

### Установка

1. Клонировать репозиторий в:
   ```
   wp-content/plugins/woodmart-price-inquiry
   ```
2. Активировать плагин в админке WordPress
3. Открыть страницу любого товара Woodmart
4. Использовать кнопку **«Запросить цену»**

---

### Архитектура плагина

Плагин спроектирован с упором на **поддерживаемость и расширяемость**.

**Ключевые слои:**

- Инициализация и проверки зависимостей
- Интеграция с Woodmart и WooCommerce
- UI-слой (кнопка + модальное окно)
- Обработка формы и валидация
- Слой капчи (заменяемые стратегии)
- Отправка email-уведомлений
- Точки расширения через хуки и фильтры

Архитектура демонстрирует подход, применимый в production-плагинах.

---

### План развития

- AJAX-отправка формы
- Страница настроек в админке
- Интеграции с CRM
- События для GTM и аналитики
- reCAPTCHA / hCaptcha
- Управление плагином на уровне товара
- REST API

---

### Лицензия

MIT License

