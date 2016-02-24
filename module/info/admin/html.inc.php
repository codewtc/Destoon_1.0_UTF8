<?php
defined('IN_DESTOON') or exit('Access Denied');
$menus = array (
    array('生成网页', '?moduleid='.$moduleid.'&file='.$file),
    array('一键生成', '?moduleid='.$moduleid.'&file='.$file.'&action=all'),
);
$all = (isset($all) && $all) ? 1 : 0;
$this_forward = '?moduleid='.$moduleid.'&file='.$file;
switch($action) {
	case 'all':
		msg('正在开始生成', '?moduleid='.$moduleid.'&file='.$file.'&action=index&all=1');
	break;
	case 'index':
		tohtml('index', $module);
		$all ? msg('首页生成成功', '?moduleid='.$moduleid.'&file='.$file.'&action=list&all=1') : dmsg('首页生成成功', $this_forward);
	break;
	case 'list':
		if(isset($catids)) {
			if(strpos($catids, ',')) {
				$catids = explode(',', $catids);
				$catid = $catids[0];
				unset($catids[0]);
				tohtml('list', $module);
				$catids = implode(',', $catids);
				msg('['.$CATEGORY[$catid]['catname'].'] 生成成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&catids='.$catids.'&all='.$all);
			} else {
				$catid = $catids;
				tohtml('list', $module);
				$all ? msg('['.$CATEGORY[$catid]['catname'].'] 生成成功', '?moduleid='.$moduleid.'&file='.$file.'&action=show&all='.$all) : msg('['.$CATEGORY[$catid]['catname'].'] 生成成功', $this_forward);
			}		
		} else {
			$catids = array();
			foreach($CATEGORY as $c) {
				$catids[]=$c['catid'];
			}
			$catids = implode(',', $catids);
			msg('开始生成栏目', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&catids='.$catids.'&all='.$all);
		}
	break;
	case 'show':
		$catid = isset($catid) ? intval($catid) : '';
		$sql = $catid ? " AND catid=$catid" : '';
		if(!isset($fid)) {
			$r = $db->get_one("SELECT min(itemid) AS fid FROM {$table} WHERE status>2 AND islink=0 {$sql}");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		if(!isset($tid)) {
			$r = $db->get_one("SELECT max(itemid) AS tid FROM {$table} WHERE status>2 AND islink=0 {$sql}");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		$update = (isset($update) && $update) ? 1 : 0;
		if($update) {
			require MOD_ROOT.'/info.class.php';
			$do = new info($moduleid);
		}
		isset($num) or $num = 100;
		if($fid <= $tid) {
			$result = $db->query("SELECT itemid FROM {$table} WHERE status>2 AND islink=0 AND itemid>=$fid {$sql} ORDER BY itemid LIMIT 0,$num ");
			if($db->affected_rows($result)) {
				while($r = $db->fetch_array($result)) {
					$itemid = $r['itemid'];
					$update ? $do->update($itemid) : tohtml('show', $module);
				}
				$itemid += 1;
			} else {
				$itemid = $fid + $num;
			}
		} else {
			$msg = $update ? '更新成功' : '生成成功';
			$all ? msg($msg, $this_forward) : dmsg($msg, $this_forward);
		}
		msg('ID从'.$fid.'至'.($itemid-1).$MOD['name'].($update ? '更新' : '生成').'成功', "?moduleid=$moduleid&file=$file&action=$action&fid=$itemid&tid=$tid&num=$num&update=$update&all=$all");
	break;
	case 'cate':
		$catid or msg('请选择栏目');
		if(!isset($item_count)) {
			$condition = $CATEGORY[$catid]['child'] ? "catid IN (".$CATEGORY[$catid]['arrchildid'].")" : "catid=$catid";
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition AND status>2 AND islink=0");
			$item_count = $r['num'];
			cache_item($moduleid, $catid, $item_count);
		}
		isset($num) or $num = 50;
		isset($fid) or $fid = 1;
		$total = ceil($item_count/$MOD['pagesize']);
		$total = $total ? $total : 1;
		if($fid <= $total) {
			tohtml('list', $module);
			msg('第'.$fid.'页至第'.($fid+$num-1).'页生成成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&catid='.$catid.'&fid='.($fid+$num).'&num='.$num.'&item_count='.$item_count);
		} else {
			dmsg('生成成功', $this_forward);
		}
	break;
	case 'item':
		$catid or msg('请选择栏目');
		msg('', '?moduleid='.$moduleid.'&file='.$file.'&action=show&catid='.$catid.'&num='.$num);
	break;
	default:
		$r = $db->get_one("SELECT min(itemid) AS fid,max(itemid) AS tid FROM {$table} WHERE status>2 AND islink=0");
		$fid = $r['fid'] ? $r['fid'] : 0;
		$tid = $r['tid'] ? $r['tid'] : 0;
		include tpl('html', $module);
	break;
}
?>