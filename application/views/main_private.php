<link rel="stylesheet" href="/public/css/main.css?<?=time()?>">
<link rel="stylesheet" href="/public/css/main_write.css?<?=time()?>">
<script type="text/javascript" src="/public/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/public/js/dev/editor_custom.js"></script>

<div class="container write_main">
	<div class="write_zone">
		<div class="inner">
			<?php $attributes = array('id' => 'p_form', 'name' => 'p_form');
			echo form_open('', $attributes); ?>
			<div class="title_zone">
				<input type="text" class="hv fc name" id="p_name" name="p_name" autocomplete="off" placeholder="새로운 프로젝트를 입력하세요." value="<?=$p_row['p_name']?>">
				<span class="dot">&middot;&middot;&middot;</span>
			</div>
			<div class="info_zone">
				<input type="hidden" id="tc" name="tc" value="<?=$pri_code?>">
                <input type="hidden" id="i" name="i" value="<?=$p_row['ikey']?>">
                <input type="hidden" id="pc" name="pc" value="<?=$p_row['p_code']?>">
				<input type="hidden" id="dep" name="dep" value="<?=$dep?>"> <!-- 최상단인지 확인 -->
				<input type="hidden" id="lock" name="lock" value="<?=$lock?>"> <!-- 잠금확인 -->
                <input type="hidden" id="mc" name="mc" value="<?=$mc?>"> <!-- 수정여부 -->
                <input type="hidden" id="status" name="p_status" value="<?=$p_row['p_status']?>">
                <input type="hidden" id="p_person" name="p_person" value="<?=$p_row['p_person']?>">
                <input type="hidden" id="p_referred" name="p_referred" value="<?=$p_row['p_referred']?>">
				<dl>
					<dt class="hv <?=(strpos($lock, 'status') !== false ? 'lock' : '')?>" data-val="status">상태</dt>
					<dd>
                        <?php if ($p_row['p_status'] == 'E') {
                            $p_status = '진행중';
                        } else if ($p_row['p_status'] == 'Y') {
                            $p_status = '완료';
                        } ?>
                        <input type="text" class="hv fc open_state_list" id="status_txt" value="<?=$p_status?>" readonly>
						<!-- <select id="status" name="p_status">
							<option value="E" <?=($p_row['p_status'] == 'E' ? 'selected' : '') ?>>진행중</option>
							<option value="Y" <?=($p_row['p_status'] == 'Y' ? 'selected' : '') ?>>완료</option>
						</select> -->
					</dd>
				</dl>
				<dl>
					<dt class="hv <?=(strpos($lock, 'date_lock') !== false ? 'lock' : '') ?>" data-val="date_lock">날짜</dt>
					<dd>
						<input type="date" class="hv fc" id="p_start" name="p_start" autocomplete="off" value="<?=$p_row['p_start']?>">
						~ 
						<input type="date" class="hv fc" id="p_deadline" name="p_deadline" autocomplete="off" value="<?=$p_row['p_deadline']?>">
					</dd>
				</dl>
				<dl>
					<dt class="hv <?=(strpos($lock, 'username') !== false ? 'lock' : '') ?>" data-val="username">작성자</dt>
					<dd>
						<input type="text" class="hv fc" id="username" name="username" autocomplete="off" placeholder="작성자를 입력하세요." value="<?=$p_row['username']?>">
					</dd>
				</dl>
				<dl>
					<dt class="hv <?=(strpos($lock, 'p_person') !== false ? 'lock' : '') ?>" data-val="p_person">담당자</dt>
					<dd>
                        <?php if (strpos($p_row['p_person'], ',') !== false) {
                            $p_person_arr = explode(',', $p_row['p_person']);
                            $i = 0;
                            $p_person = '';
                            foreach ($p_person_arr as $person_row):
                                if ($i != 0) $p_person .= ',';
                                $p_person .= Common::get_column('user_list', $person_row, 'username');
                                $i++;
                            endforeach;
                        } else {
                            $p_person = Common::get_column('user_list', $p_row['p_person'], 'username');
                        } ?>
						<input type="text" class="hv fc open_mb_list" id="person" autocomplete="off" placeholder="담당자를 입력해주세요." value="<?=$p_person?>" readonly>
					</dd>
				</dl>
				<dl>
					<dt class="hv <?=(strpos($lock, 'p_referred') !== false ? 'lock' : '') ?>" data-val="p_referred">참조자</dt> 
					<dd>
                        <?php if (strpos($p_row['p_referred'], ',') !== false) {
                            $p_referred_arr = explode(',', $p_row['p_referred']);
                            $i = 0;
                            $p_referred = '';
                            foreach ($p_referred_arr as $referred_row):
                                if ($i != 0) $p_referred .= ',';
                                $p_referred .= Common::get_column('user_list', $referred_row, 'username');
                                $i++;
                            endforeach;
                        } else {
                            $p_referred = Common::get_column('user_list', $p_row['p_referred'], 'username');
                        } ?>
						<input type="text" class="hv fc open_mb_list" id="referred" autocomplete="off" placeholder="참조자를 입력해주세요." value="<?=$p_referred?>" readonly>
					</dd>
				</dl>
				<dl>
					<dt class="hv <?=(strpos($lock, 'p_tag') !== false ? 'lock' : '') ?>" data-val="p_tag">태그</dt>
					<dd>
						<input type="text" class="hv fc" id="p_tag" name="p_tag" autocomplete="off" placeholder="태그를 입력하세요." value="<?=str_replace('|', ', ', $p_row['p_tag'])?>">
					</dd>
				</dl>
				<dl>
					<dt class="hv <?=(strpos($lock, 'p_url') !== false ? 'lock' : '') ?>" data-val="p_url">URL</dt>
					<dd>
						<input type="text" class="hv fc" id="p_url" name="p_url" autocomplete="off" placeholder="URL을 입력하세요." value="<?=$p_row['p_url']?>">
					</dd>
				</dl>
			</div>

			<div class="document_zone">
				<div class="document_top">
					<h3>
                        <?php if ($p_row['p_name']) { ?>
                        <span id="doc_title"><?=$p_row['p_name']?></span>
                        <?php } else { ?>
                        <span id="doc_title">제목없음</span>
                        <?php } ?>
                         <span class="dot">&middot;&middot;&middot;</span></h3>
					<div class="btns">
						<button type="button" class="btn" id="review_btn" onclick="review_control()">미리보기</button>
						<button type="button" class="blue save_btn" id="save" onclick="p_submit()">저장</button>
					</div>
				</div>
				<div class="input_zone">
					<!-- 커스텀 우클릭메뉴:S -->
                    <ul id="pop_menu" class="list-group" style="display: none">
						<li class="list-group-item list-group-item-action" id="i_tag" aria-current="true">태그</a>
						<li class="list-group-item list-group-item-action" id="s_tag">태그검색</a>
                    </ul>
					<!-- 커스텀 우클릭메뉴:E -->

					<!-- ckeditor -->
					<textarea name="contents" id="contents" autocomplete="off"><?=$p_row['contents']?></textarea>
					<textarea id="hidden_area" id="hidden_area" name="hidden_area" style="display: none"></textarea>

                    <?php if (!empty($p_tag)) { ?>
                    <div class="tag_wrap">
                        <?php foreach ($p_tag_list as $row): ?>
                        <span class="tag"># <?=$row->p_tag?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php } ?>
				</div>
			</div>

			<div class="new_file_zone">
                <div class="file_list">
                    <ul>
                    	<?php if (!empty($list)) {
                    		$i = '0';
                     		foreach ($list as $row): 
                     			$i++;
                     			if ($row->p_depth == '1' && $row->p_depth_detail == '1') { ?>
                        <li class="main_doc hv" onclick="load_data('<?=$row->ikey?>')">
                            <div class="list_inner">
                                <span class="dot">&middot;&middot;&middot;</span>
                                <p class="name"><?=$row->p_name?></p>
                                <p class="date"><?=date('y년 m월 d일', strtotime($row->p_start))?> ~ <?=date('y년 m월 d일', strtotime($row->p_deadline))?></p>
                                <span class="state <?=($row->p_status == '진행' ? 'proc' : 'comp') ?>"><?=$row->p_status?></span>
                            </div>
                            <div class="tagbox_wrap">
                                <?php 
                                $p_tag_list = $this->Main_m->tag_direct_result($row->t_code, $row->p_code, '0', '3'); // 직접입력 태그 빈도별 3순위
                                foreach ($p_tag_list as $t_row): ?>
                                <span class="tagbox"># <?=trim($t_row->p_tag)?></span>
                                <!-- 문서내 태그 제일 많이쓴거 3개만 -->
                                <?php endforeach; ?>
                            </div>
                        </li>
                        		<?php } else if ($row->p_depth == '1' && $row->p_depth_detail != '1') { ?>
                        <li class="sub_doc hv" onclick="load_data('<?=$row->ikey?>')">
                            <div class="list_inner">
                                <span class="dot">&middot;&middot;&middot;</span>
                                <p class="name"><?=$row->p_name?></p>
                                <p class="date"><?=date('y년 m월 d일', strtotime($row->p_start))?> ~ <?=date('y년 m월 d일', strtotime($row->p_deadline))?></p>
                                <span class="state <?=($row->p_status == '진행' ? 'proc' : 'comp') ?>"><?=$row->p_status?></span>
                            </div>
                            <div class="tagbox_wrap">
                            	<?php
                                $p_tag_list = $this->Main_m->tag_direct_result($row->t_code, $row->p_code, '0', '3'); // 직접입력 태그 빈도별 3순위
                            	foreach ($p_tag_list as $t_row): ?>
                                <span class="tagbox"># <?=trim($t_row->p_tag)?></span>
                                <!-- 문서내 태그 제일 많이쓴거 3개만 -->
                            	<?php endforeach; ?>
                            </div>
                        </li>
                        		<?php } ?>
                    		<?php endforeach;
                    	} ?>
                    </ul>
                </div>
                <div class="new_file_list">
                    <!-- <li class="newfile addtxt hv">
                        <div class="list_inner">
                            <span class="plus">+</span> 
                            <p class="name">제목없음</p>
                            <span class="state red">미정</span>
                        </div>
                        <div class="tagbox_wrap">
                            <span class="tagbox"># 애국가</span>
                            <span class="tagbox"># 애국가 1절</span>
                            <span class="tagbox"># 애국가 1절</span>
                        </div>
                    </li> -->
                    <li class="newfile hv" id="new_file">
                        <div class="list_inner">
                            <span class="plus">+</span> 
                            <p class="name">새로운 문서 작성</p>
                        </div>
                    </li>
                    <div class="option_menu">
                        <ul>
                            <li onclick="location.href='/main/p_index?new=y'">일반 문서 작성</li>
                            <li>엑셀 시트 사용</li>
                            <li>기존 파일 사용</li>
                            <li>제공 양식 사용</li>
                            <li>파일 업로드</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="bottom_line">
		</div>
		<?=form_close()?>
	</div>
	<div class="side_menu">
        <?php $attributes = array('id' => 'right_form', 'name' => 'right_form');
        echo form_open('', $attributes); ?>
        <input type="hidden" id="mc" name="mc" value="">
        <input type="hidden" id="dep" name="dep" value="C">
        <input type="hidden" id="pi" name="pi" value="<?=$this->input->get('i')?>">
        <input type="radio" id="comment" name="radio" checked>
        <label for="comment" class="comment" style="margin:11px 15px 11px 18px;">댓글</label>
        <input type="radio" id="tag" name="radio">
        <label for="tag" class="tag">태그</label>
        <div class="tab tab01">
            <div class="input_zone">
                <input type="text" class="hv fc comment" id="c_contents" name="c_contents" autocomplete="off" placeholder="댓글 달기">
                <button type="button" class="hv fc btn" onclick="comm_i('comment')">등록</button>
            </div>
            <ul class="comment_zone" id="comment_zone">
                <?php if (!empty($p_comment)) { 
                    foreach ($p_comment as $row): ?>
                <li class="hv">
                    <span class="dot">˙˙˙</span>
                    <h2><?=Common::get_column('user_list', $row->reg_ikey, 'username')?> <span><?=$t_name?></span></h2>
                    <p class="date"><?=date('Y년 m월 d일 H시 i분', strtotime($row->reg_dt))?></p>
                    <p class="comment_txt">
                    <?=$row->contents?>
                    </p>
                </li>
                    <?php endforeach;
                } else { ?>
                <li class="hv">
                    <p class="comment_txt">등록된 댓글이 없습니다.</p>
                </li>
                <?php } ?>
                <!-- <li class="hv">
                    <span class="dot">˙˙˙</span>
                    <h2>홍길동 <span>Master</span></h2>
                    <p class="date">2022년 07월 02일 17시 04분</p>
                    <p class="comment_txt">
                    나의 새워 한 어머님, 지나고 아름다운 가을로 거외다. 이 헤는 남은 그리워 덮어 버리었습니다. 이국 이름자 많은 하나에 이름자를 벌써 계십니다. 그러나 하나에 것은 속의 남은 별빛이 봅니다. 오면 어머니, 지나가는 별을 겨울이 봅니다. 차 이 말 어머님, 흙으로 했던 까닭입니다.
                    </p>
                </li> -->
            </ul>
        </div>
        <div class="tab tab02">
            <ul class="tag_list">
                <?php if (!empty($p_tag)) { 
                    foreach ($p_tag as $row): ?>
                <li class="hv">
                    <span class="dot">˙˙˙</span>
                    <p class="date"><?=date('Y년 m월 d일 H시 i분', strtotime($row->reg_dt))?></p>
                    <div class="comment_txt"><?=$row->contents?></div>
                    <div class="tag_zone">
                        <span class="tag_title border"># <?=$row->p_tag?></span> <!-- border: 수동태그 -->
                    </div>
                </li>
                    <?php endforeach;
                } else { ?>
                <li class="hv">
                    <div class="comment_txt">등록된 태그가 없습니다.</div>
                </li>
                <?php } ?>
                
                <!-- <li class="hv">
                    <span class="dot">˙˙˙</span>
                    <p class="date">2022년 07월 02일 17시 04분</p>
                    <div class="comment_txt">동해물과 백두산이 마르고 닳도록 하느님이 보우하사 우리나라 만세</div>
                    <div class="tag_zone">
                        <span class="tag_title"># 애국가 1절</span> borderX: 자동태그
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
    <?=form_close(); ?>
</div>


<div class="select_mb_pop select_pop">
    <div class="inner">
        <ul class="select_person">
            <!-- 개인은 본인만 -->
            <li data-val="<?=Common::get_column2('user_list', array('userid' => $this->session->userdata('id')), 'ikey')?>"><?=Common::get_column2('user_list', array('userid' => $this->session->userdata('id')), 'username')?> </li>
        </ul>
    </div>
</div>
<div class="state_pop select_pop">
    <div class="inner">
        <ul id="p_status">
            <li data-val="E">진행중</li>
            <li data-val="Y">완료</li>
            <!-- <li>대기</li> -->
        </ul>
    </div>
</div>
<div class="tag_pop">
    <div class="inner">
        <?php $attributes = array('id' => 'tag_form', 'name' => 'tag_form');
        echo form_open('', $attributes); ?>
        <input type="hidden" id="drag_p" name="drag_p" value="">
        <input type="hidden" id="drag_w" name="drag_w" value="">
        <input type="text" id="tag_i" name="tag" autocomplete="off" placeholder="태그를 입력해주세요." value="">
        <button type="button" class="btn" onclick="tag_submit()">등록</button>
        <?=form_close()?>
    </div>
</div>
<script>
    if ($('#lock').val()) {
        var lock_arr = $('#lock').val().split(',');
    } else {
	   var lock_arr = new Array();
    }

    var person_arr = new Array(); // 담당자 배열
    var referred_arr = new Array(); // 참조자 배열
    var d_tag_arr = new Array(); // 직접입력태그 배열
    $(document).ready( function() {
        auto_save('p_form', $('#i').val(), CKEDITOR.instances.contents.getData(), ''); // 문서 일단 저장
        
        // 문서를 불러왔을때 담당자가 있을때:S
        if ($('#p_person').val()) {
            if ($('#p_person').val().indexOf(',') == -1) {
                person_arr.push(Number($('#p_person').val()));
            } else {
                var per_arr = $('#p_person').val().split(',');
                for (var i = 0; i < per_arr.length; i++) {
                    person_arr.push(Number(per_arr[i]));
                }
            }
        }
        // 문서를 불러왔을때 담당자가 있을때:E

        // 문서를 불러왔을때 참조자가 있을때:S
        if ($('#p_referred').val()) {
            if ($('#p_referred').val().indexOf(',') == -1) {
                referred_arr.push(Number($('#p_referred').val()));
            } else {
                var ref_arr = $('#p_referred').val().split(',');
                for (var i = 0; i < ref_arr.length; i++) {
                    referred_arr.push(Number(ref_arr[i]));
                }
            }
        }
        // 문서를 불러왔을때 참조자가 있을때:E

        $('.info_zone dl dt').click(function(){
            if ($(this).hasClass('lock') !== false) {
            	$(this).removeClass('lock');
            	lock_arr.splice(lock_arr.indexOf($(this).data('val')), 1);
            } else {
            	$(this).addClass('lock');
            	lock_arr.push($(this).data('val'));
            }
            $('#lock').val(lock_arr);
        });

        // 내용있을때/없을때 저장버튼 색 변경
        if (CKEDITOR.instances.contents.getData() != '') {
            $('#save').css('background-color', '#0176f9');
        } else {
            $('#save').css('background-color', '#9fccff');
        }
    });
    // ckeditor 관련:S
	CKEDITOR.replace('contents', {
        height: 374,
    });

    CKEDITOR.on('instanceReady', function(evt) {
        var body = evt.editor.document.getBody();
        body.setAttribute('id', evt.editor.config.bodyId); // iframe body에 id부여
    });

    setTimeout(function() {
        custom()
    }, 400);
    // ckeditor 관련:E

    setInterval(function() {
        // auto_save('p_form', $('#i').val(), CKEDITOR.instances.contents.getData(), '');
    }, 60000); // 1분마다 자동세이브

    document.addEventListener('contextmenu', function(e) {
        // 본문전체에서 마우스 우클릭
        // e.preventDefault(); // 우클릭 이벤트 무효화
    });

    $(document).on('click', '#cke_34', function() {
        if ($(this).hasClass('on') !== false) {
            $(this).removeClass('on');
            custom();
        } else {
            $(this).addClass('on');
            $('#review_btn').removeClass('on');
            custom();
        }
    });

    $(document).on('click', '#cke_10', function() {
        custom();
    });

    window.addEventListener('beforeunload', function(event) {
        auto_save('p_form', $('#i').val(), CKEDITOR.instances.contents.getData(), '');
    });

    $(function() {
    	$('#new_file').click(function() {
    		if ($('.option_menu').hasClass('on') !== false) {
    			$('.option_menu').removeClass('on');
    		} else {
    			$('.option_menu').addClass('on');
    		}
    	});

        $('.option_menu').mouseleave(function() {
            $('.option_menu').removeClass('on');
        });

        $('#p_name').on('blur', function() {
            $('#doc_title').text($(this).val());
        });

        // 상태값 팝업:S
        $('.open_state_list').off().click(function(){
            $('.state_pop').bPopup({
                modalClose: true
                , opacity: 0
                , positionStyle: 'absolute'
                , speed: 100
                , transition: 'fadeIn'
                , transitionClose: 'fadeOut'
                , zIndex : 100
                //, modalColor:'transparent'
            });
        });

        $('#p_status > li').click(function() {
            $('#status').val($(this).data('val'));

            if ($(this).data('val') == 'Y') {
                $('#status_txt').val('완료');
            } else if ($(this).data('val') == 'E') {
                $('#status_txt').val('진행중');
            }

            $('.state_pop').bPopup().close();
        });
        // 상태값 팝업:E

        // 담당자, 참조자 팝업:S
        $('.open_mb_list').off().click(function(){
            $('.select_mb_pop').bPopup({
                modalClose: true
                , opacity: 0
                , positionStyle: 'absolute'
                , speed: 100
                , transition: 'fadeIn'
                , transitionClose: 'fadeOut'
                , zIndex : 100
                //, modalColor:'transparent'
            });

            $('.select_person').data('val', $(this).attr('id'));

            if ($(this).attr('id') == 'person') {
                var arr = person_arr;
            } else {
                var arr = referred_arr;
            }

            $.each($('.select_person > li'), function() {
                var index_check = arr.indexOf($(this).data('val'));
                if (index_check != -1) {
                    $(this).addClass('on');
                }
            });
        });

        $('.select_person > li').click(function() {
            var id = $('.select_person').data('val');
            var s_id = 'p_' + id;
            var text = '';
            var txt = $('#' + id).val();

            if (id == 'person') {
                text = '담당자';
                var arr = person_arr;
            } else if (id == 'referred') {
                text = '참조자';
                var arr = referred_arr;
            }

            if (arr.indexOf($(this).data('val')) == -1) { // 선택한 담당자가 추가되는경우
                arr.push($(this).data('val'));

                if (txt != '') {
                    txt += ',';
                }
                txt += $(this).text();
                $('#' + id).val(txt);

                $(this).addClass('on');
            } else { // 선택한 담당자가 이미 추가되있는 경우
                arr.splice(arr.indexOf($(this).data('val')), 1);

                var txt_arr = txt.split(',');
                txt_arr.splice(txt_arr.indexOf($(this).text()), 1);
                txt = '';
                for (var i = 0; i < txt_arr.length; i++) {
                    if (i != 0) txt += ',';
                    txt += txt_arr[i];
                }

                $('#' + id).val(txt);
                $(this).removeClass('on');
            }

            $('#' + s_id).val(arr);
        });
        // 담당자, 참조자 팝업:E

        // 우클릭->태그 선택:S
        $('#i_tag').click(function(e) {
            var x = e.clientX;
            var y = e.clientY;

            $('#tag').val('');
            $('.tag_pop').bPopup({
                modalClose: true
                , position: [x, y]
                , opacity: 0
                , positionStyle: 'absolute'
                , speed: 100
                , transition: 'fadeIn'
                , transitionClose: 'fadeOut'
                , zIndex: 100
                //, modalColor:'transparent'
            });
        });
    });

    // 데이터 작업 후 이동할때 사용
	function locate_url(url) {
	    if (history.replaceState) {
	        history.replaceState(null, document.title, url);
	        history.go(0);
	    } else {
	        location.replace(url);
	    }
	}

    // 문서등록/수정:S
    function p_submit() {
    	var data = $('#p_form').serialize() + '&contents=' + CKEDITOR.instances.contents.getData();
    	var contents = CKEDITOR.instances.contents.getData();

        if ($('#mc').val() == 'Y') {
            var url = '/main/u';
        } else {
            var url = '/main/i';
        }

    	$.ajax({
    		type: 'post',
    		url: url,
    		data: data,
            dataType: 'json',
    		success: function(data) {
                if (data.length != 0) {
    				if (data[1] == '1') {
    					alert('저장 되었습니다.');
    					locate_url('/main/p_index?i=' + data[0]);
    				} else if (data[1] == '0') {
    					alert('오류가 발생하였습니다.');
    					return false;
    				}
                }
    		}
    	});
    }
    // 문서등록/수정:E

    // 댓글등록:S
    function comm_i(type) {
        if (type == 'comment') {
            if ($('#c_contents').val().replace(/\s*$/, '').length == 0) {
                alert('댓글을 입력해주세요.');
                $('#c_contents').focus();
                return false;
            } else {
                var data = $('#right_form').serialize();

                $.ajax({
                    type: 'post',
                    url: '/main/comm_i',
                    data: data + '&pc=' + $('#pc').val() + '&tc=' + $('#tc').val(),
                    dataType: 'json',
                    success: function(data) {
                        if (data.length != 0) {
                            if (data[1] == '1') {
                                let txt = '';
                                $.each(data[0], function(k, v) {
                                    txt += '<li class="hv">';
                                    txt += '    <span class="dot">˙˙˙</span>';
                                    txt += '    <h2>' + v['username'] + '<span>' + v['t_name'] + '</span></h2>';
                                    txt += '    <p class="date">' + date_format(v['reg_dt']) + '</p>';
                                    txt += '    <p class="comment_txt">' + v['contents'] + '</p>';
                                    txt += '</li>';
                                });
                                $('#comment_zone').empty();
                                $('#comment_zone').html(txt);
                                $('#c_contents').val('');
                                // alert('등록 되었습니다.');
                                // locate_url('/main/p_index?i=' + data[0]);
                            } else {
                                alert('오류가 발생하였습니다.');
                                return false;
                            }
                        }
                    }
                });
            }
        }
    }
    // 댓글등록:E

    // 직접입력 태그등록:S
    function tag_submit() {
        var data = $('#tag_form').serialize() + '&tc=' + $('#tc').val() + '&pc=' + $('#pc').val() + '&i=' + $('#i').val();

        $.ajax({
            type: 'post',
            url: '/main/tag_i',
            data: data,
            dataType: 'json',
            success: function(data) {
                if (data.length != 0) {
                    $('.tag_wrap').empty();
                    $('.tag_list').empty();

                    var tag_txt = '';
                    var tag_list = '';
                    $.each(data['bottom'], function(k, v) {
                        tag_txt += '<span class="tag">#' + v['p_tag'] + '</span>';
                    });
                    $('.tag_wrap').html(tag_txt);

                    $.each(data['right'], function(k, v) {
                        tag_list += '<li class="hv">';
                        tag_list += '   <span class="dot">˙˙˙</span>';
                        tag_list += '   <p class="date">' + date_format(v['reg_dt']) + '</p>';
                        tag_list += '   <div class="comment_txt">' + v['contents'] + '</div>';
                        tag_list += '   <div class="tag_zone">';
                        tag_list += '       <span class="tag_title border"># ' + v['p_tag'] + '</span>';
                        tag_list += '   </div>';
                        tag_list += '</li>';
                    });
                    $('.tag_list').html(tag_list);

                    if (data['result'] == '1') {
                        $('#drag_p').val('');
                        $('#drag_w').val('');
                        $('#tag_i').val('');
                        $('.tag_pop').bPopup().close();
                    } else if (data['result'] == '0') {
                        alert('오류가 발생하였습니다.');
                        return false;
                    }
                }
            }
        });
    }
    // 직접입력 태그등록:E

    // dateformat 변환 함수:S
    function date_format(val) {
        var d = new Date(val);

        var year = d.getFullYear();
        var month = (d.getMonth() + 1);
        var day = d.getDate();

        var hour = d.getHours();
        var minutes = d.getMinutes();

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

        var result = year + '년 ' + month + '월 ' + day + '일 ' + hour + '시 ' + minutes + '분';

        return result;
    }
    // dateformat 변환 함수:E

    function load_data(ikey) {
        locate_url('/main/p_index?i=' + ikey);

        // 스크립트 문제로 잠시 보류
        // $.ajax({
        //     type: 'post',
        //     url: '/main/load_data',
        //     data: {'ikey': ikey},
        //     dataType: 'json',
        //     success: function(data) {
        //         if (data.length != 0) {
        //             custom();
        //             $('#mc').val('Y');
        //             $.each(data, function(k, v) {
        //                 if (k == 't_code') {
        //                     $('#tc').val(v);
        //                 } else if (k == 'p_depth') {
        //                     $('#dep').val(v);
        //                 } else if (k == 'p_lock') {
        //                     $('#lock').val(v);
        //                 } else if (k == 'p_tag') {
        //                     // var tag = v.replace(/\|/g, ', ');
        //                     $('#p_tag').val(v);
        //                 } else if (k == 'contents') {
        //                     $('#contents').html(v);
        //                     CKEDITOR.instances.contents.setData(v);
        //                 } else if (k == 'p_name') {
        //                     $('#p_name').val(v);
        //                     $('#doc_title').text(v);
        //                 } else if (k == 'ikey') {
        //                     $('#i').val(v);
        //                 } else {
        //                     $('#' + k).val(v);
        //                 }
        //             });
        //         }
        //     }
        // });
    }

    // 새로고침 방지:S
    function not_reload() {
        if ((event.ctrlKey == true && (event.keyCode == 78 || event.keyCode == 82)) || (event.keyCode == 116) ) {
            event.keyCode = 0;
            event.cancelBubble = true;
            event.returnValue = false;
        }

        window.onbeforeunload = function(e) { // 새로고침 버튼 눌렀을때 경고
            return 0;
        };
    }

    // document.onkeydown = not_reload;
    // 새로고침 방지:E

    // 엔터키 submit 방지:S
    document.addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        };
    }, true);
    // 언터키 submit 방지:E
</script>