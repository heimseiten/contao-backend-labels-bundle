<?php

declare(strict_types=1);

namespace Solidwork\ContaoBackendLabelsBundle\Util;

use Contao\BackendUser;
use Contao\StringUtil;
use Contao\UserGroupModel;

class BackendLabelPermission
{
    private static bool|null $cache = null;

    public static function isGranted(): bool
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $user = BackendUser::getInstance();

        // $user->admin is the raw DB column value; $user->isAdmin may not be set in Contao 5
        if ($user->admin) {
            return self::$cache = true;
        }

        $groupIds = StringUtil::deserialize($user->groups ?? '', true);
        $groupIds = array_values(array_filter(array_map('intval', (array) $groupIds)));

        if ($groupIds === []) {
            return self::$cache = false;
        }

        $groups = UserGroupModel::findMultipleByIds($groupIds);

        if ($groups === null) {
            return self::$cache = false;
        }

        foreach ($groups as $group) {
            if ($group->sldwrk_showBackendLabels) {
                return self::$cache = true;
            }
        }

        return self::$cache = false;
    }
}
