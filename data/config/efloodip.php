<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 23 Sep 2020 16:34:36 GMT
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$array_except_flood_site = array();
$array_except_flood_site['::1'] = array('mask' => "//", 'begintime' => 1600878876, 'endtime' => 0);

$array_except_flood_admin = array();
