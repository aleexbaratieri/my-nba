<?php

namespace App\Enums;

enum Permissions: string
{
    case VIEW_USER = 'view_user';
    case VIEW_TEAM = 'view_team';
    case VIEW_PLAYER = 'view_player';
    case VIEW_GAME = 'view_game';
    case CREATE_TEAM = 'create_team';
    case CREATE_PLAYER = 'create_player';
    case CREATE_GAME = 'create_game';
    case EDIT_TEAM = 'edit_team';
    case EDIT_PLAYER = 'edit_player';
    case EDIT_GAME = 'edit_game';
    case DELETE_TEAM = 'delete_team';
    case DELETE_PLAYER = 'delete_player';
    case DELETE_GAME = 'delete_game';

    public function toMiddleware(): string
    {
        return 'permission:' . $this->value;
    }
}