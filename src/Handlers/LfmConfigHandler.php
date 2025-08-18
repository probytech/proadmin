<?php

namespace App\Proadmin\Handlers;


class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        return 'uploads';
    }
}
