<?php

class HandballPluginDeactivator
{

    public static function deactivate()
    {
        wp_clear_scheduled_hook('handball_synchronize_data');
    }
}