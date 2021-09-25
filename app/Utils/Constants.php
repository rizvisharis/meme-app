<?php

namespace App\Utils;


class Constants
{
    public static $ROLE = [
        'admin' => 'admin',
    ];

    public static $ERROR_MESSAGE = [
        'success' => 'Success!',
        'id_exist' => 'Id already exist!',
        'id_not_exist' => 'Id not already exist!',
        'invite_user_not_found' => 'Invitation not found / expired',
        'no_email_password' => 'Your password or email is incorrect!',
        'link_expired' => 'Your link has been expired!',
        'password_not_match' => 'Your current password does not match!',
        'access_denied' => 'You do not have access permission!',
        'token_not_exist' => 'Token not provided!',
        'file_format_wrong' => 'upload file not in binary format!',
        'hub_name_exist' => 'hub name already exist!',
        'tank_name_exist' => 'tank name already exist!',
        'max_count' => 'maximum count reached!',
        'volume_exceeded' => 'volume exceeded',
        'jobs_exist' => 'Job already existed',
    ];

    public static $ERROR_CODE = [
        'success' => 200,
        'unauthorized' => 401,
        'access_denied' => 403,
        'not_found' => 404,
        'unprocessable_entity' => 422,
        'internal_server_error' => 500,
    ];

    public static $STATUS = [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'invite' => 'Invited',
    ];

    public static $EMAIL_TEMPLATE = [
        'activate' => 'emails.userActivate',
        'forgotPassword' => 'emails.forgotPassword',
    ];

    public static $EMAIL_SUBJECT = [
        'activate' => 'Account activation',
        'forgotPassword' => 'Password reset',
    ];
}
