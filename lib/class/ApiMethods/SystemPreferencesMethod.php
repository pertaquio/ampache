<?php
/*
 * vim:set softtabstop=4 shiftwidth=4 expandtab:
 *
 * LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
 * Copyright 2001 - 2020 Ampache.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

declare(strict_types=0);

namespace Lib\ApiMethods;

use Api;
use XML_Data;

final class SystemPreferencesMethod
{
    /**
     * system_preferences
     * MINIMUM_API_VERSION=430000
     *
     * Get your system preferences
     *
     * @param array $input
     * @return boolean
     */
    public static function system_preferences($input)
    {
        $user = \User::get_from_username(\Session::username($input['auth']));
        if (!Api::check_access('interface', 100, $user->id)) {
            return false;
        }
        $preferences  = \Preference::get_all(-1);
        $output_array = array('preferences' => $preferences);
        switch ($input['api_format']) {
            case 'json':
                echo json_encode($output_array, JSON_PRETTY_PRINT);
                break;
            default:
                echo XML_Data::object_array($output_array['preferences'], 'preferences', 'pref');
        }
        \Session::extend($input['auth']);
    }
}
