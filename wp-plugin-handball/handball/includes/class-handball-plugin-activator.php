<?php

class HandballPluginActivator
{

    public static function activate()
    {
        if (! wp_next_scheduled('handball_synchronize_data')) {
            wp_schedule_event(time(), 'hourly', 'handball_synchronize_data');
        }
    }
}