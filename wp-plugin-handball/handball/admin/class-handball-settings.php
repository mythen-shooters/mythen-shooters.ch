<?php

class HandballSettings
{
    public static function registerSettings()
    {
        $sectionId = 'handball_settings_section_synchronize';
        $settingsPage = 'general';
        
        add_settings_section($sectionId, 'Handball - SHV Synchronisierung', null, $settingsPage);
        
        register_setting('general', 'HANDBALL_API_URL');
        add_settings_field(
            'handball_setting_api_url',
            'SHV API Url',
            function () {
                $setting = get_option('HANDBALL_API_URL');
                ?><input class="regular-text" type="text" name="HANDBALL_API_URL" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>"><?php
            },
            $settingsPage,
            $sectionId
        );

        register_setting('general', 'HANDBALL_API_USERNAME');
        add_settings_field(
            'handball_setting_api_username',
            'SHV API Username',
            function () {
                $setting = get_option('HANDBALL_API_USERNAME');
                ?><input class="regular-text" type="text" name="HANDBALL_API_USERNAME" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>"><?php
            },
            $settingsPage,
            $sectionId
        );

        register_setting('general', 'HANDBALL_API_PASSWORD');
        add_settings_field(
            'handball_setting_api_password',
            'SHV API Password',
            function () {
                $setting = get_option('HANDBALL_API_PASSWORD');
                ?><input class="regular-text" type="text" name="HANDBALL_API_PASSWORD" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>"><?php
            },
            $settingsPage,
            $sectionId
        );

        register_setting('general', 'HANDBALL_SYNCHRONIZE_CLUB_ID');
        add_settings_field(
            'handball_setting_api_synchronize_club_id',
            'Club ID to sync',
            function () {
                $setting = get_option('HANDBALL_SYNCHRONIZE_CLUB_ID');
                ?><input class="regular-text" type="text" name="HANDBALL_SYNCHRONIZE_CLUB_ID" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>"><?php
            },
            $settingsPage,
            $sectionId
        );

        register_setting('general', 'HANDBALL_CURRENT_SAISON');
        add_settings_field(
            'handball_setting_current_saison',
            'Current Saison',
            function () {
                $setting = get_option('HANDBALL_CURRENT_SAISON');
                $options = ['<option value="">-</option>'];
                foreach ((new HandballSaisonRepository())->findAll() as $saison) {
                    $selected = selected($setting, $saison->getValue(), false);
                    $options[] = '<option '.$selected.' value="'.$saison->getValue().'">'.$saison->formattedShort().'</option>';
                }
                ?>
               	<select name="HANDBALL_CURRENT_SAISON">
               		<?= implode('', $options) ?>
               	</select>
                <?php
            },
            $settingsPage,
            $sectionId
        );
		
		register_setting('general', 'HANDBALL_NUMBER_OF_EVENTS_TO_SHOW');
        add_settings_field(
            'handball_setting_number_of_events_to_show',
            'Number of events to show',
            function () {
                $setting = get_option('HANDBALL_NUMBER_OF_EVENTS_TO_SHOW');
                ?><input class="regular-text" type="text" name="HANDBALL_NUMBER_OF_EVENTS_TO_SHOW" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>"><?php
            },
            $settingsPage,
            $sectionId
        );
    }
}