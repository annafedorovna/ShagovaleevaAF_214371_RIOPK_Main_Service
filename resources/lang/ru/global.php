<?php

return [
	
	'user-management' => [
		'title' => 'Пользователи',
		'created_at' => 'Time',
		'fields' => [
		],
	],
	
	'permissions' => [
		'title' => 'Привилегии',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
		],
	],
	
	'roles' => [
		'title' => 'Роли',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Name',
			'permission' => 'Permissions',
		],
	],
	
	'users' => [
		'title' => 'Пользователи',
		'created_at' => 'Time',
		'fields' => [
			'name' => 'Имя',
			'email' => 'Email',
			'password' => 'Пароль',
			'roles' => 'Роли',
			'remember-token' => 'Токен (сброс)',
		],
	],
    'app_create' => 'Создать',
    'app_save' => 'Сохранить',
    'app_edit' => 'Изменить',
    'app_view' => 'Просмотр',
    'app_update' => 'Обновить',
    'app_list' => 'Список',
    'app_no_entries_in_table' => 'Нет записей в таблице',
    'custom_controller_index' => 'Индекс пользовательского контроллера.',
    'app_logout' => 'Выйти',
    'app_add_new' => 'Добавить новый',
    'app_are_you_sure' => 'Вы уверены?',
    'app_back_to_list' => 'Вернуться к списку',
    'app_dashboard' => 'Панель управления',
    'app_delete' => 'Удалить',
	'global_title' => 'CWInsurance',
];