## Документация по функции генерации отчетов

### Общее описание

Функция генерации отчетов в приложении MRAS позволяет пользователям создавать, просматривать и управлять отчетами о состоянии системы управления информационной безопасностью (СУИБ) в рамках проектов. Эта функция предоставляет детальную информацию о текущем состоянии выполнения требований стандарта ISO 27001, а также помогает в выявлении проблемных областей и оценке уровня безопасности.

### Основные элементы интерфейса

1.  **Навигационная панель слева**:
    
    -   **Projects**: Раздел для просмотра и управления проектами.
    -   **Docs**: Раздел для доступа к документации и справочным материалам.
2.  **Заголовок**:
    
    -   Отображает название текущего проекта.
    -   Содержит кнопки "Survey" и "Reports" для перехода к соответствующим разделам.
3.  **Раздел отчетов (Reports)**:
    
    -   Список ранее сгенерированных отчетов с указанием времени генерации и уровня безопасности в процентах.
    -   Кнопка "Create Report" для создания нового отчета.
4.  **Область контента (Просмотр отчета)**:
    
    -   Отображает содержимое выбранного отчета, включая вопросы, ответы и диаграммы.

### Функциональные возможности

1.  **Создание отчета**:
    
    -   Пользователь может создать новый отчет, нажав кнопку "Create Report".
    -   Отчет генерируется на основе текущих данных проекта, включая все ответы на вопросы.
2.  **Просмотр отчета**:
    
    -   Пользователь может просматривать детали ранее сгенерированных отчетов, нажав кнопку "View Report" рядом с соответствующим отчетом.
    -   Отчет включает в себя:
        -   Список вопросов и ответов.
        -   Диаграмму, визуализирующую распределение безопасных и небезопасных ответов.
        -   Рекомендации и заключения на основе анализа данных.

### Описание логики работы

1.  **Создание отчета**:
    
    -   При нажатии кнопки "Create Report" система собирает текущие данные проекта.
    -   На основе собранных данных генерируется отчет, который сохраняется в базе данных с указанием времени создания и уровня безопасности.
2.  **Просмотр отчета**:
    
    -   При выборе отчета для просмотра данные загружаются из базы данных и отображаются на экране.
    -   Вопросы и ответы отображаются в табличном виде.
    -   Диаграмма генерируется для визуализации уровня безопасности.

### Технические детали

1.  **Фронтенд**:
    
    -   JavaScript  используется для динамического обновления содержимого страницы.
    -   CSS для стилизации элементов интерфейса.
2.  **Бэкенд**:
    
    -   Серверная часть написана на Laravel (PHP), которая обрабатывает запросы, генерирует отчеты и сохраняет их в базу данных.
3.  **База данных**:
    
    -   MySQL используется для хранения данных о проектах, отчетах и ответах пользователей.
