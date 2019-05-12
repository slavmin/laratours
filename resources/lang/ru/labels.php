<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы названий Labels
    |--------------------------------------------------------------------------
    |
    | Следующие языковые ресурсы используются в названиях
    | Labels всего вашего приложения.
    | Вы можете свободно изменять эти языковые ресурсы в соответствии
    | с требованиями вашего приложения.
    |
    */

    'general' => [
        'all' => 'Все',
        'yes' => 'Да',
        'no' => 'Нет',
        'copyright' => 'Copyright',
        'custom' => 'Выборочно',
        'actions' => 'Действие',
        'active' => 'Активирован',
        'buttons' => [
            'save' => 'Сохранить',
            'update' => 'Обновить',
            'send' => 'Отправить',
            'delete' => 'Удалить',
            'select' => 'Выбрать',
            'restore' => 'Восстановить',
            'delete-permanently' => 'Удалить навсегда',
        ],
        'hide' => 'Скрыть',
        'inactive' => 'Неактивен',
        'none' => 'Нет',
        'show' => 'Показать',
        'toggle_navigation' => 'Навигация',
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create' => 'Создать новую роль',
                'edit' => 'Изменить роль',
                'management' => 'Доступ',
                'table' => [
                    'number_of_users' => 'Пользователей',
                    'permissions' => 'Разрешения',
                    'role' => 'Роль',
                    'sort' => 'Позиция',
                    'total' => 'ролей всего|всего ролей',
                ],
            ],
            'teams' => [
                'create' => 'Создать новую компанию',
                'edit' => 'Изменить компанию',
                'management' => 'Компании',
                'active' => 'Активные компании',
                'deactivated' => 'Заблокированные компании',
                'deleted' => 'Удаленные компании',
                'table' => [
                    'number_of_users' => 'Пользователей',
                    'owner' => 'Админ компании',
                    'team' => 'Имя',
                    'sort' => 'Позиция',
                    'total' => 'всего компаний|компаний всего',
                ],
                'tabs' => [
                    'titles' => [
                        'history' => 'История',
                        'overview' => 'Обзор',
                        'profile' => 'Реквизиты',
                    ],
                    'content' => [
                        'overview' => [
                            'members' => 'Участники',
                            'created_at' => 'Создан',
                            'deleted_at' => 'Удалён',
                            'last_updated' => 'Обновлён',
                            'name' => 'Компания',
                            'status' => 'Статус',
                        ],
                    ],
                ],
                'view' => 'Просмотр компании',
            ],
            'users' => [
                'active' => 'Активные пользователи',
                'all_permissions' => 'Полный доступ',
                'change_password' => 'Изменение пароля',
                'change_password_for' => 'Изменить пароль :user',
                'create' => 'Создать учётную запись',
                'deactivated' => 'Заблокированные пользователи',
                'deleted' => 'Удаленные пользователи',
                'edit' => 'Редактирование учётной записи',
                'management' => 'Пользователи',
                'no_permissions' => 'Нет разрешений',
                'no_roles' => 'Невозможно присвоить роль.',
                'permissions' => 'Разрешения',
                'table' => [
                    'confirmed' => 'Подтверждён',
                    'activated' => 'Статус',
                    'created' => 'Создан',
                    'email' => 'E-mail',
                    'id' => 'ID',
                    'last_updated' => 'Обновлён',
                    'name' => 'Логин',
                    'first_name' => 'Имя',
                    'last_name' => 'Фамилия',
                    'no_deactivated' => 'Нет заблокированных пользователей',
                    'no_deleted' => 'Нет удаленных пользователей',
                    'other_permissions' => 'Другие Разрешения',
                    'permissions' => 'Разрешения',
                    'roles' => 'Роль',
                    'social' => 'Социальный аккаунт',
                    'team' => 'Компания',
                    'total' => 'пользователей всего|всего пользователей',
                ],
                'tabs' => [
                    'titles' => [
                        'history' => 'История',
                        'overview' => 'Обзор',
                    ],
                    'content' => [
                        'overview' => [
                            'avatar' => 'Аватар',
                            'confirmed' => 'Подтверждён',
                            'created_at' => 'Создан',
                            'deleted_at' => 'Удалён',
                            'team' => 'Компания',
                            'email' => 'E-mail',
                            'last_login_at' => 'Last Login At',
                            'last_login_ip' => 'Last Login IP',
                            'last_updated' => 'Обновлён',
                            'name' => 'Логин',
                            'first_name' => 'Имя',
                            'last_name' => 'Фамилия',
                            'status' => 'Статус',
                            'timezone' => 'Timezone',
                        ],
                    ],
                ],
                'view' => 'Просмотр учётной записи',
            ],
        ],
    ],
    'frontend' => [
        'auth' => [
            'login_box_title' => 'Вход',
            'login_button' => 'Вход',
            'login_with' => 'Вход из :social_media',
            'register_box_title' => 'Регистрация',
            'register_button' => 'Зарегистрироваться',
            'remember_me' => 'Запомнить меня',
        ],

        'contact' => [
            'box_title' => 'Контакт',
            'button' => 'Отправить',
        ],

        'passwords' => [
            'expired_password_box_title' => 'Срок действия изменения пароля истек.',
            'forgot_password' => 'Забыли Пароль?',
            'reset_password_box_title' => 'Сброс Пароля',
            'reset_password_button' => 'Смена пароля',
            'update_password_button' => 'Обновить пароль',
            'send_password_reset_link_button' => 'Отправить',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Изменить пароль',
            ],
            'profile' => [
                'avatar' => 'Аватар',
                'created_at' => 'Создан',
                'edit_information' => 'Редактирование информации',
                'email' => 'E-mail',
                'last_updated' => 'Обновлён',
                'name' => 'Логин',
                'first_name' => 'Имя',
                'last_name' => 'Фамилия',
                'update_information' => 'Обновление информации',
            ],
        ],
        'teams' => [
            'from' => 'из',
            'profile' => 'Реквизиты компании',
            'table' => [
                'name' => 'Компания',
                'members' => 'Участники',
                'number_of_users' => 'Пользователей',
                'owner' => 'Админ компании',
                'team' => 'Имя',
                'sort' => 'Позиция',
                'total' => 'всего компаний|компаний всего',
            ],
         ],
        'tours' => [
            'management' => 'Управление турами',
            'tour' => [
                'management' => 'Типы туров',
                'name' => 'Тип тура',
                'create' => 'Создать новый тип',
                'edit' => 'Изменить тип',
                'country' => 'Страна',
                'city' => 'Город',
                'table' => [
                    'name' => 'Имя',
                    'description' => 'Описание',
                    'sort' => 'Позиция',
                    'total' => 'всего типов|типов всего',
                ],
            ],
            'type' => [
                'name' => 'Тип тура',
                'create' => 'Создать новый тип',
                'edit' => 'Изменить тип',
                'management' => 'Типы туров',
                'table' => [
                    'name' => 'Имя',
                    'description' => 'Описание',
                    'sort' => 'Позиция',
                    'total' => 'всего типов|типов всего',
                ],
            ],
            'country' => [
                'name' => 'Страна',
                'create' => 'Создать новую страну',
                'edit' => 'Изменить страну',
                'management' => 'Страны',
                'deleted' => 'Страны для удаления',
                'table' => [
                    'name' => 'Имя',
                    'description' => 'Описание',
                    'sort' => 'Позиция',
                    'total' => 'всего стран|стран всего',
                ],
            ],
            'city' => [
                'name' => 'Город',
                'create' => 'Создать новый город',
                'edit' => 'Изменить город',
                'management' => 'Города',
                'deleted' => 'Города для удаления',
                'table' => [
                    'name' => 'Имя',
                    'description' => 'Описание',
                    'sort' => 'Позиция',
                    'total' => 'всего городов|городов всего',
                ],
            ],
            'guide' => [
                'name' => 'Гид',
                'create' => 'Создать нового гида',
                'edit' => 'Изменить гида',
                'management' => 'Гиды',
                'table' => [
                    'name' => 'Имя',
                    'description' => 'Описание',
                    'price' => 'Цена',
                    'sort' => 'Позиция',
                    'total' => 'всего гидов|гидов всего',
                ],
            ],
            'attendant' => [
                'name' => 'Сопровождающий',
                'create' => 'Создать нового сопровождающего',
                'edit' => 'Изменить сопровождающего',
                'management' => 'Сопровождающие',
                'table' => [
                    'name' => 'Имя',
                    'description' => 'Описание',
                    'price' => 'Цена',
                    'sort' => 'Позиция',
                    'total' => 'всего сопровождающих|сопровождающих всего',
                ],
            ],
            'museum' => [
                'name' => 'Музей',
                'create' => 'Создать новый музей',
                'edit' => 'Изменить музей',
                'management' => 'Музеи',
                'table' => [
                    'name' => 'Имя',
                    'description' => 'Описание',
                    'price' => 'Цена',
                    'sort' => 'Позиция',
                    'total' => 'всего музеев|музеев всего',
                ],
            ],
        ],
    ],
];
