<!-- 개인 공간 관리 -->
<?php // 아무곳에서나 팝업형태로 불러오기 위해 php 코드 html코드안으로 옮김
$id = $this->session->userdata('id');
$user_ikey = $this->Common_m->get_column2('user_list', array('userid' => $id), 'ikey');
$row = $this->Main_m->get_team_row($user_ikey);

$t_code = $row->t_code;
$total_cnt = $this->Common_m->get_count('project_list', array('t_code' => $row->t_code, 'useyn' => 'Y'));
$cnt = ceil($total_cnt / 20);
$p_list = $this->Space_manage_m->get_limit_result(0, 20, $row->t_code);
$date_arr = array('0' => '일', '1' => '월', '2' => '화', '3' => '수', '4' => '목', '5' => '금', '6' => '토');
?>
<link rel="stylesheet" href="/public/css/space.css?<?=time()?>">
<link rel="stylesheet" href="/public/css/main_write.css?<?=time()?>">
<link href="/public/css/lib/air-datepicker.css" rel="stylesheet" type="text/css">
<script src="/public/js/lib/air-datepicker.js"></script>
<div class="private_space" style="display: none">
    <div class="inner">
    <div class="b-close">&times;</div>
        <div class="search_zone">
        	<input type="hidden" id="tc" value="<?=$t_code?>">
        	<input type="hidden" id="cnt" value="<?=$cnt?>">
        	<input type="hidden" id="op" value="<?=$this->input->get('p')?>">
            <h4>개인공간</h4>
            <div class="search_wrap">
                <div class="btns">
                    <button type="button" class="search-btn blue" id="today_btn" onclick="change_date('t')" >당일</button>
                    <button type="button" class="search-btn" id="week_btn" onclick="change_date('w')">주간</button>
                    <button type="button" class="search-btn" id="month_btn" onclick="change_date('m')">월간</button>
                </div>
                <div id="today_div">
	                <input type="text" id="datepicker" class="datepicker" value="<?=date('Y-m-d')?>" autocomplete="off" onclick="change_list('t', this.value)">
	                <!-- <input type="text" id="datepicker2" class="datepicker" value="<?=date('Y-m-d')?>" autocomplete="off"> -->
	            </div>

	            <div id="week_div" class="w80" style="display: none">
	            	<select id="week_year" name="week_year">
	            		<option value="">선택해주세요</option>
	            		<?php for ($i=date('Y', strtotime('-4 years')); $i <= date('Y'); $i++) { ?>
	            		<option value="<?=$i?>" <?=(date('Y') == $i ? 'selected' : '') ?>><?=$i?>년</option>
	            		<?php } ?>
	            	</select>
	            	<select id="week_month" name="week_month" onchange="week_change()">
	            		<option value="">선택해주세요</option>
	            		<?php for ($i = 1; $i <= 12; $i++) { ?>
	            		<option value="<?=sprintf('%02d', $i)?>" <?=(date('m') == $i ? 'selected': '') ?>><?=$i?>월</option>
	            		<?php } ?>
	            	</select>
	            	<select id="week" name="week" onchange="change_list('w', this.value)"></select>
	            </div>

	            <div id="month_div" class="w80" style="display: none">
	            	<select id="year" class="w40" name="year">
	            		<?php for ($i=date('Y', strtotime('-4 years')); $i <= date('Y'); $i++) { ?>
	            		<option value="<?=$i?>" <?=(date('Y') == $i ? 'selected' : '') ?>><?=$i?>년</option>
	            		<?php } ?>
	            	</select>

	            	<select id="month" class="w40" name="month" onchange="change_list('m', this.value)">
	            		<?php for ($i=1; $i<=12; $i++) { ?>
	            		<option value="<?=sprintf('%02d', $i)?>" <?=(date('m') == $i ? 'selected' : '') ?>><?=sprintf('%02d', $i)?>월</option>
	            		<?php } ?>
	            	</select>
	            </div>
            </div>
        </div>
        <div class="list_zone">
            <table>
                <thead>
                    <tr>
                        <th>제목</th>
                        <th>담당자</th>
                        <th>상태</th>
                        <th>시작일 ~ 마감일</th>
                        <th>수정일</th>
                        <th>파일위치</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                	if (!empty($p_list)) {
                    	foreach ($p_list as $row): 
                    		$class = '';
                    		$p_name = '';
                    		$p_person = '';
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

                    		if ($row->p_name != '') {
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
                            <td class="T-left Elli" onclick="location.href='/main/p_index?i=<?=$row->ikey?>'"><?=$p_name?></td>
                            <td onclick="location.href='/main/p_index?i=<?=$row->ikey?>'"><?=$p_person?></td>
                            <td onclick="location.href='/main/p_index?i=<?=$row->ikey?>'"><span class="<?=$class?>"><?=$p_status?></span></td>
                            <td class="date" onclick="location.href='/main/p_index?i=<?=$row->ikey?>'"><?=$p_start?> (<?=$date_arr[$start_date]?>) ~ <?=$p_deadline?></td>
                            <td class="date" onclick="location.href='/main/p_index?i=<?=$row->ikey?>'"><?=$mod_dt?></td>
                            <td class="link">파일위치 이동</td>
                        </tr>
                    	<?php endforeach;
                   	} else { ?>
                       	<tr>
                       		<td colspan="6">작성된 문서가 없습니다.</td>
                       	</tr>
                    <?php } ?>
                </tbody>
                <?php for ($i = 2; $i <= $cnt; $i++) { ?>
                <tbody id="more_table_<?=$i?>"></tbody>
                <?php } ?>
            </table>
        </div>
        <?php if ($cnt > 1) { ?>
        <div class="btn_wrap"><button class="more hv" id="more_btn">20개 더보기</button></div>
    	<?php } ?>
    </div>
</div>

<script>
	$(document).ready(function() {
		let date = new Date()
		now = date.getFullYear();
		now += '-' + Number(date.getMonth() + 1);
		
		let txt = '';

		$.ajax({
			type: 'get',
			url: '/space_manage/get_week',
			data: {'dt': now},
			dataType: 'json',
			success: function(data) {
				if (data.length != 0) {
					let i = 1;
					txt = '<option value="">선택해주세요.</option>';
					$.each(data, function(k, v) {
						txt += '<option value="' + v['start'] + '">' + i + '주차 (' + v['start'] + ' ~ )';
						i++;
					});

					$('#week').html(txt);
				}
			}
		});
	});

    $('.open_private').off().click(function(){
		$('.private_space').bPopup({
			  modalClose: true
			, opacity: 0.7
			, positionStyle: 'absolute' 
			, speed: 100
			, transition: 'fadeIn'
			, transitionClose: 'fadeOut'
			, zIndex : 900,
			onOpen: function(){ /** 팝업창 열릴 때 */
				$('.open_private').addClass('active');
			},
			onClose: function(){ /** 팝업창 닫힐 때 */
				$('.open_private').removeClass('active');
			}
		});
    });

    new AirDatepicker('#datepicker', {
        isMobile: true,
        autoClose: true,
        dateFormat: 'yyyy-MM-dd',
        onSelect: function(date) {
        	change_list('t', date.formattedDate);
        }
    })

    // new AirDatepicker('#datepicker2', {
    //     isMobile: true,
    //     autoClose: true,
    //     dateFormat: 'yyyy-MM-dd'
    // })

    let page = 1;
    $(function() {
    	$('#more_btn').click(function() {
    		++page;
    		$('#more_table_' + page).load('/space_manage/more?t_code=' + $('#tc').val() + '&page=' + page);
    		if ($('#cnt').val() == page) {
    			$('#more_btn').hide();
    		}
    	});
    });

    function change_date(v) {
    	$('.search-btn').removeClass('blue');

    	if (v == 't') {
    		$('#today_div').show();
    		$('#today_btn').addClass('blue');
    		$('#week_div').hide();
    		$('#month_div').hide();
    	} else if (v == 'w') {
    		$('#today_div').hide();
    		$('#week_div').show();
    		$('#week_btn').addClass('blue');
    		$('#month_div').hide();
    	} else if (v == 'm') {
    		$('#today_div').hide();
    		$('#week_div').hide();
    		$('#month_div').show();
    		$('#month_btn').addClass('blue');
    	}
    }

    function change_list(t, v) {
    	let date = '';

    	if (t == 't' || t == 'w') {
    		date = v;
    	} else if (t == 'm') {
    		date = $('#year').val() + '-' + v;
    	}

    	$.ajax({
    		type: 'get',
    		url: '/space_manage/change_list',
    		data: {'date': date, 'type': t},
    		dataType: 'json',
    		success: function(data) {
    			if (data.length != 0) {
    				let txt = '';
    				$.each(data, function(k, v) {
    					let c = '';
    					let subject = '';
    					let deadline = '';
    					let username = '';
    					if (v['p_status'] == "진행") {
    						c = 'green';
    					} else if (v['p_status'] == "완료") {
    						c = 'blue';
    					}

    					if (v['p_name'] == '') {
    						subject = '새로운 프로젝트명을 입력하세요.';
    					} else {
    						subject = v['p_name'];
    					}

    					if (v['p_deadline'] == '0000-00-00') {
    						deadline = '';
    					} else {
    						deadline = date_format_p(v['p_deadline'], 'nh');
    					}

    					if (v['username'] == null) {
    						username = '-';
    					} else {
    						username = v['username'];
    					}

    					txt += '<tr>';
    					txt += '	<td class="T-left Elli" onclick="location.href=\'/main/p_index?i=' + v['ikey'] + '\'">' + subject + '</td>';
    					txt += '	<td onclick=\'/main/p_index?i=' + v['ikey'] + '\'>' + username + '</td>';
    					txt += '	<td onclick=\'/main/p_index?i=' + v['ikey'] + '\'><span class="' + c + '">' + v['p_status'] + '</td>';
    					txt += '	<td class="date" onclick="location.href=\'/main/p_index?i=' + v['ikey'] + '\'">' + date_format_p(v['p_start'], 'nh') + ' ~ ' + deadline + '</td>';
    					txt += '	<td class="date" onclick="location.href=\'/main/p_index?i=' + v['ikey'] + '\'">' + date_format_p(v['mod_dt'], 'h') + '</td>';
    					txt += '	<td class="link">파일위치 이동</td>';
    					txt += '</tr>';
    				});

    				$('.list_zone > table > tbody').html(txt);
    			} else {
    				let txt = '<tr>';
    				txt += '	<td colspan="6">등록된 문서가 없습니다.</td>';
    				txt += '</tr>';

    				$('.list_zone > table > tbody').html(txt);
    			}
    		}
    	});
    }

    // 주차 변경:S
    function week_change() {
        let year = $('#week_year').val();
        let month = $('#week_month').val();
        let date = year + '-' + month;
        $.ajax({
            type: 'get',
            url: '/space_manage/get_week',
            data: {'dt': date},
            dataType: 'json',
            success: function(data) {
                if (data.length != 0) {
                    let txt = '<option value="">선택해주세요.</option>';
                    let i = 1;
                    $.each(data, function(k, v) {
                        txt += '<option value="' + v['start'] + '">' + i + '주차 (' + v['start'] + ' ~ )</option>';
                        i++;
                    });

                    $('#week').empty();
                    $('#week').html(txt);
                }
            }
        });
    }
    // 주차 변경:E

    // dateformat 변환 함수:S
    function date_format_p(val, type) {
    	let week_array = new Array('일', '월', '화', '수', '목', '금', '토');

        let d = new Date(val);

        let year = d.getFullYear();
        let month = (d.getMonth() + 1);
        let day = d.getDate();
        let yoil = d.getDay();

        let hour = d.getHours();
        let minutes = d.getMinutes();

        let result = '';

        if (month.length == 1) {
            month = '0' + month;
        }

        if (day.length == 1) {
            day = '0' + day;
        }

        if (hour.length == 1) {
            hour = '0' + hour;
        }

        if (minutes.length == 1) {
            minutes = '0' + minutes;
        }

        if (type == 'nh') {
        	result = year + '. ' + month + '. ' + day + ' (' + week_array[yoil] + ')';
        } else if (type == 'h') {
        	result = year + '. ' + month + '. ' + day + ' (' + week_array[yoil] + ') ' + hour + '시 ' + minutes + '분';
        }

        return result;
    }
    // dateformat 변환 함수:E
</script>