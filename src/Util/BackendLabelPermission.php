<?php

declare(strict_types=1);

namespace Solidwork\ContaoBackendLabelsBundle\Util;

use Contao\BackendUser;
use Contao\Database;
use Contao\StringUtil;

class BackendLabelPermission
{
    private static bool|null $cache = null;

    public static function isGranted(): bool
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $user = BackendUser::getInstance();

        if ($user->isAdmin) {
            return self::$cache = true;
        }

        $groupIds = array_map('intval', array_filter((array) StringUtil::deserialize($user->groups ?? '', true)));

        if ($groupIds === []) {
            return self::$cache = false;
        }

        $placeholders = implode(',', array_fill(0, count($groupIds), '?'));
        $result = Database::getInstance()
            ->prepare("SELECT COUNT(*) AS cnt FROM tl_user_group WHERE id IN ({$placeholders}) AND sldwrk_showBackendLabels='1'")
            ->execute(...$groupIds);

        return self::$cache = ($result->cnt > 0);
    }
}