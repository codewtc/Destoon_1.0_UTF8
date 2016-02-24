<?php
defined('IN_DESTOON') or exit('Access Denied');
$all = (isset($all) && $all) ? 1 : 0;
$menus = array (
    array('生成网页', '?moduleid='.$moduleid.'&file='.$file),
);
$this_forward = '?moduleid='.$moduleid.'&file='.$file;
switch($action) {
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
			$r = $db->get_one("SELECT min(userid) AS fid FROM {$table} WHERE groupid>4 {$sql}");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		if(!isset($tid)) {
			$r = $db->get_one("SELECT max(userid) AS tid FROM {$table} WHERE groupid>4 {$sql}");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		$update = (isset($update) && $update) ? 1 : 0;
		if($update) {
			require  MOD_ROOT.'/company.class.php';
			$do = new company($moduleid);
		}
		isset($num) or $num = 50;
		if($fid <= $tid) {
			$result = $db->query("SELECT userid FROM {$table} WHERE groupid>4 AND userid>=$fid {$sql} ORDER BY userid LIMIT 0,$num ");
			if($db->affected_rows($result)) {
				while($r = $db->fetch_array($result)) {
					$userid = $r['userid'];
					$update ? $do->update($userid) : tohtml('show', $module);
				}
				$userid += 1;
			} else {
				$userid = $fid + $num;
			}
		} else {
			$msg = $update ? '更新成功' : '生成成功';
			$all ? msg($msg, $this_forward) : dmsg($msg, $this_forward);
		}
		msg('ID从'.$fid.'至'.($userid-1).$MOD['name'].($update ? '更新' : '生成').'成功', "?moduleid=$moduleid&file=$file&action=$action&fid=$userid&tid=$tid&num=$num&update=$update&all=$all");
	break;
	case 'cate':
		$catid or msg('请选择栏目');
		if(!isset($item_count)) {
			$condition = $CATEGORY[$catid]['child'] ? "catid IN (".$CATEGORY[$catid]['arrchildid'].")" : "catid=$catid";
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition AND groupid>4");
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
	default:
		$r = $db->get_one("SELECT min(userid) AS fid,max(userid) AS tid FROM {$table} WHERE groupid>4");
		$fid = $r['fid'] ? $r['fid'] : 0;
		$tid = $r['tid'] ? $r['tid'] : 0;
		include tpl('html', $module);
	break;
}
?>