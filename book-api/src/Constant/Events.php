<?php

namespace App\Constant;

/**
 * Class Events
 * @package App\Constant
 */
final class Events extends AbstractConstant
{
    const USER_CREATED          = 'user.created';
    const USER_CONNECTED        = 'user.connected';
    const USER_RESET_PASSWORD   = 'user.resetpassword';
    const USER_ACTIVATED        = 'user.activated';
    const USER_DEACTIVATED      = 'user.deactivated';
    const USER_UPDATED          = 'user.updated';
    const USER_DELETED          = 'user.deleted';
    const USER_INVITED          = 'user.invited';
}