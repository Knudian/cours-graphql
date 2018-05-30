<?php

namespace App\Constant;

/**
 * Class MessageCode
 * @package App\Constant
 */
final class MessageCode extends AbstractConstant
{
    const NONE                          = 'NONE';
    const NOTHING_CHANGED               = 'NOTHING_CHANGED';
    const CREATED                       = 'CREATED';
    const UPDATED                       = 'UPDATED';
    const NULL_ATTRIBUTE                = 'NULL_ATTRIBUTE';
    const BAD_REQUEST                   = 'BAD_REQUEST';
    const NOT_FOUND                     = 'NOT_FOUND';
    const INVALID_CREDENTIALS           = 'INVALID_CREDENTIALS';
    const INSUFFICIENT_RIGHTS           = 'INSUFFICIENT_RIGHTS';
    const CANNOT_DEACTIVATE_YOURSELF    = 'CANNOT_DEACTIVATE_YOURSELF';
    const USER_CREATED                  = 'CREATED';
    const USER_UPDATED                  = 'UPDATED';
    const USER_NOT_FOUND                = 'USER_NOT_FOUND';
    const NEW_TOKEN                     = 'NEW_TOKEN';
    const TOKEN_EXPIRED                 = 'TOKEN_EXPIRED';
    const INVITATION_USED               = 'INVITATION_USED';
}