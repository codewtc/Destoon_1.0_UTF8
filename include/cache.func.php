<?php
/*
	[Destoon B2B System] Copyright (c) 2009 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
function cache_all() {
	cache_module();
	cache_area();
	cache_category();
	cache_group();
	cache_pay();
	cache_type();
	cache_keylink();
	return true;
}

function cache_pay() {
	global $db, $DT_PRE;
	$setting = array();
	$query = $db->query("SELECT * FROM {$DT_PRE}setting WHERE item LIKE '%pay-%'");
	while($r = $db->fetch_array($query)) {
		if(substr($r['item'], 0, 4) == 'pay-') {
			$setting[substr($r['item'], 4)][$r['item_key']] = $r['item_value'];
		}
	}
	//Order
	$pay = array();
	$pay['chinabank'] = $setting['chinabank'];
	$pay['alipay'] = $setting['alipay'];
	$pay['tenpay'] = $setting['tenpay'];
	cache_write('pay.php', $pay);
}

function cache_module($moduleid = 0) {
	global $db, $DT_PRE;
	if($moduleid) {
		$r = $db->get_one("SELECT * FROM {$DT_PRE}module WHERE disabled=0 AND moduleid='$moduleid' ");
		$setting = array();
		$setting = get_setting($moduleid);
		$setting['moduleid'] = $moduleid;
		$setting['name'] = $r['name'];
		$setting['moduledir'] = $r['moduledir'];
		$setting['ismenu'] = $r['ismenu'];
		$setting['domain'] = $r['domain'];
		$setting['linkurl'] = $r['linkurl'];
		cache_write('module-'.$moduleid.'.php', $setting);
		return true;
	} else {
		$query = $db->query("SELECT moduleid,module,name,moduledir,domain,linkurl,style,listorder,islink,ismenu FROM {$DT_PRE}module WHERE disabled=0 ORDER by listorder asc,moduleid desc");
		$CACHE = array();
		$modules = array();
		while($r = $db->fetch_array($query)) {
			if(!$r['islink']) {
				$linkurl = $r['domain'] ? $r['domain'] : linkurl($r['moduledir'].'/');
				if($r['moduleid'] == 1) $linkurl = DT_URL;
				if($linkurl != $r['linkurl']) {
					$r['linkurl'] = $linkurl;
					$db->query("UPDATE {$DT_PRE}module set linkurl='$linkurl' WHERE moduleid='$r[moduleid]' ");
				}
				cache_module($r['moduleid']);
			}
			$modules[$r['moduleid']] = $r;
        }
		$CACHE['module'] = $modules;
		$CACHE['dt'] = cache_read('module-1.php');
		cache_write('module.php', $CACHE);
	}
}

function cache_area() {
	global $db, $DT_PRE;
	$data = array();
    $query = $db->query("SELECT areaid,areaname,parentid,arrparentid,child,arrchildid,listorder FROM {$DT_PRE}area ORDER by listorder,areaid");
    while($r = $db->fetch_array($query)) {
		$areaid = $r['areaid'];
        $data[$areaid] = $r;
    }
	cache_write('area.php', $data);
	//Cache Tree
	$areas = array();
	foreach($data as $id=>$are) {
		$areas[$id] = array('id'=>$id,'parentid'=>$are['parentid'],'name'=>$are['areaname']);
	}
	require_once DT_ROOT.'/include/tree.class.php';
	$tree = new tree;
	$tree->tree($areas);
	$content = $tree->get_tree(0, "<option value=\\\"\$id\\\">\$spacer\$name</option>").'</select>';
	cache_write('areatree.php', $content);
}

function cache_category($moduleid = 0) {
	global $db, $DT_PRE, $DT;
	if($moduleid) {
		$data = array();
		$query = $db->query("SELECT * FROM {$DT_PRE}category WHERE moduleid='$moduleid' ORDER BY listorder,catid");
		while($r = $db->fetch_array($query)) {
			$data[$r['catid']] = $r;
		}
		cache_write('category-'.$moduleid.'.php', $data);//For listurl cache_read
		$query = $db->query("SELECT * FROM {$DT_PRE}category WHERE moduleid='$moduleid' ORDER BY listorder,catid");
		while($r = $db->fetch_array($query)) {
			$r['linkurl'] = listurl($moduleid, $r['catid']);
			if($DT['index']) $r['linkurl'] = str_replace($DT['index'].'.'.$DT['file_ext'], '', $r['linkurl']);
			cache_write('category_'.$r['catid'].'.php', $r);
			unset($r['moduleid'], $r['template'], $r['seo_title'], $r['seo_keywords'], $r['seo_description']);
			$data[$r['catid']] = $r;
		};
		cache_write('category-'.$moduleid.'.php', $data);
		//Cache Tree
		$categorys = array();
		foreach($data as $id=>$cat) {
			$categorys[$id] = array('id'=>$id, 'parentid'=>$cat['parentid'], 'name'=>$cat['catname']);
		}
		require_once DT_ROOT.'/include/tree.class.php';
		$tree = new tree;
		$tree->tree($categorys);
		$content = $tree->get_tree(0, "<option value=\\\"\$id\\\">\$spacer\$name</option>").'</select>';
		cache_write('cattree-'.$moduleid.'.php', $content);
	} else {
		$moduleids = array();
		$query = $db->query("SELECT * FROM {$DT_PRE}category ORDER by listorder,catid");
		while($r = $db->fetch_array($query)) {
			if(isset($moduleids[$r['moduleid']])) continue;
			cache_category($r['moduleid']);
			$moduleids[$r['moduleid']] = $r['moduleid'];
		}
	}
}

function cache_group() {
	global $db, $DT_PRE;
	$data = $group = array();
	$query = $db->query("SELECT * FROM {$DT_PRE}group ORDER BY groupid desc");
	while($r = $db->fetch_array($query)) {
		$tmp = array();
		$tmp = get_setting('group-'.$r['groupid']);
		$data[$r['groupid']] = $r;
		if($tmp) {
			foreach($tmp as $k=>$v) {
				$r[$k] = $v;
			}
		}
		cache_write('group-'.$r['groupid'].'.php', $r);
	}
	cache_write('group.php', $data);
}

function cache_type($item = '') {
	global $db, $DT_PRE;
	if($item) {
		$types = array();
		$result = $db->query("SELECT typeid,typename,style FROM {$DT_PRE}type WHERE item='$item' AND cache=1 ORDER BY listorder DESC,typeid DESC ");
		while($r = $db->fetch_array($result)) {
			$types[$r['typeid']] = $r;
		}
		cache_write('type-'.$item.'.php', $types);
		return $types;
	} else {
		$arr = array();
		$result = $db->query("SELECT item FROM {$DT_PRE}type WHERE item!='' AND cache=1 ORDER BY typeid DESC ");
		while($r = $db->fetch_array($result)) {
			if(!in_array($r['item'], $arr)) {
				$arr[] = $r['item'];
				cache_type($r['item']);
			}
		}
	}
}

function cache_keylink($item = '') {
	global $db, $DT_PRE;
	if($item) {
		$keylinks = array();
		$result = $db->query("SELECT title,url FROM {$DT_PRE}keylink WHERE item='$item' ORDER BY listorder DESC,itemid DESC");
		while($r = $db->fetch_array($result)) {
			$keylinks[] = $r;
		}
		cache_write('keylink-'.$item.'.php', $keylinks);
		return $keylinks;
	} else {
		$arr = array();
		$result = $db->query("SELECT item FROM {$DT_PRE}keylink");
		while($r = $db->fetch_array($result)) {
			if(!in_array($r['item'], $arr)) {
				$arr[] = $r['item'];
				cache_keylink($r['item']);
			}
		}
	}
}

function cache_clear_ad($all = false) {
	global $DT_TIME;
	$globs = glob(CACHE_ROOT.'/htm/*.htm');
	if($globs) {
		foreach($globs as $v) {
			if(strpos($v, 'ad_', basename($v)) === false) continue;
			if($all) {
				unlink($v);
			} else {
				$exptime = intval(substr(file_get_contents($v), 4, 14));
				if($exptime && $DT_TIME > $exptime) unlink($v);
			}
		}
	}
	file_put(CACHE_ROOT.'/htm/ad.dat', $DT_TIME);
}

function cache_clear_tag($all = false) {
	global $DT_TIME;
	$globs = glob(CACHE_ROOT.'/tag/*.htm');
	if($globs) {
		foreach($globs as $v) {
			if($all) {
				unlink($v);
			} else {
				$exptime = intval(substr(file_get_contents($v), 4, 14));
				if($exptime && $DT_TIME > $exptime) unlink($v);
			}
		}
	}
	file_put(CACHE_ROOT.'/tag/tag.dat', $DT_TIME);
}

function cache_clear_sql($dir, $all = false) {
	global $DT_TIME;
	if($dir) {
		$globs = glob(CACHE_ROOT.'/sql/'.$dir.'/*.php');
		if($globs) {
			if($globs) {
				foreach($globs as $v) {
					if($all) {
						unlink($v);
					} else {
						$exptime = intval(substr(file_get_contents($v), 8, 18));
						if($exptime && $DT_TIME > $exptime) unlink($v);
					}
				}
			}
		}
	} else {
		cache_clear('php', 'dir', 'sql');
	}
	file_put(CACHE_ROOT.'/sql/sql.dat', $DT_TIME);
}
?>
