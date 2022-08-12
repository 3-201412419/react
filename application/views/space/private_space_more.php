<?php foreach ($list as $row):
	$class = '';
	$p_name = '';
	if ($row->p_status == 'E') {
		$class = 'green';
		$p_status = '진행';
	} else if ($row->p_status == 'Y') {
		$class = 'blue';
		$p_status = '완료';
	}

	$p_start = date('Y. m. d', strtotime($row->p_start));
	$p_deadline = date('Y. m. d', strtotime($row->p_deadline));

	$start_date = date('w', strtotime($row->p_start));
	$end_date = date('w', strtotime($row->p_deadline));
	$mod_date = date('w', strtotime($row->mod_dt));

	$mod_dt_arr = explode(' ', $row->mod_dt);
	$mod_dt = date('Y. m. d', strtotime($mod_dt_arr[0]));
	$mod_dt .= ' ('.$date_arr[$mod_date].') ';
	$mod_dt .= date('H시 m분', strtotime($mod_dt_arr[1]));

	if ($row->p_name) {
		$p_name = $row->p_name;
	} else {
		$p_name = '새로운 프로젝트명을 입력하세요.';
	}

	if ($row->p_person != '') {
		$p_person = Common::get_column('user_list', $row->p_person, 'username');
	} else {
		$p_person = '-';
	}

	if ($row->p_deadline != '0000-00-00') {
		$p_deadline = $p_deadline. ' ('.$date_arr[$end_date].')';
	} else {
		$p_deadline = '';
	}
	?>
<tr>
	<td class="T-left Elli"><?=$p_name?></td>
	<td><?=$p_person?>
	<td><span class="<?=$class?>"><?=$p_status?></span></td>
	<td class="date"><?=$p_start?> (<?=$date_arr[$start_date]?>) ~ <?=$p_deadline?></td>
	<td class="date"><?=$mod_dt?></td>
	<td class="link">파일위치 이동</td>
</tr>
<?php endforeach;?>