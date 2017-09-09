<?php

namespace common\rbac;
use backend\models\User;

/**
 * содержит описание действий и пользователей, которым эти действия позволены
 */
class Rbac
{
    /**
     * Разрешения, отвечающие за доступ к actions, задаем в виде controller_action
     */
    const PERM_USER_LIST     = 'user_list';
    const PERM_USER_EDIT     = 'user_edit';
    const PERM_USER_VALIDATE = 'user_validate';
    const PERM_USER_SAVE     = 'user_save';
    const PERM_USER_DELETE   = 'user_delete';

    const PERM_SITE_INDEX  = 'site_index';
    const PERM_SITE_LOGIN  = 'site_login';
    const PERM_SITE_LOGOUT = 'site_logout';

    const PERM_REQUEST_LIST         = 'request_list';
    const PERM_REQUEST_STATE_CHANGE = 'request_state_change';

    const PERM_ERROR  = 'error';

    const ROLES_AUTHORIZED     = '@';
    const ROLES_NOT_AUTHORIZED = '?';

    const ROLE_GUEST          = 'guest';
    const ROLE_MANAGER        = 'manager';
    const ROLE_ADMIN          = 'admin';

    const PERMISSIONS = [
        self::PERM_USER_LIST,
        self::PERM_USER_EDIT,
        self::PERM_USER_VALIDATE,
        self::PERM_USER_SAVE,
        self::PERM_USER_DELETE,
        self::PERM_ERROR,

        self::PERM_SITE_INDEX,
        self::PERM_SITE_LOGIN,
        self::PERM_SITE_LOGOUT,

        self::PERM_REQUEST_LIST,
        self::PERM_REQUEST_STATE_CHANGE,
    ];
}