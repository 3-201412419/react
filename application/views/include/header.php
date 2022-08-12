<?php
$user_ikey = Common::get_column2('user_list', array('userid' => $this->session->userdata('id')), 'ikey');
// 팀페이지 목록:S

// 팀페이지 목록:E

// 개인페이지 목록:S
$t_code = Common::get_column2('team_auth', array('t_name' => '개인', 't_person' => $user_ikey), 't_code');
$sql = 'SELECT pl.*
        FROM project_list AS pl
            LEFT JOIN team_list AS tl ON pl.t_code = tl.t_code
        WHERE pl.useyn = "Y" AND pl.t_code = "'.$t_code.'"
        ORDER BY ikey ASC, p_depth ASC, p_depth_detail ASC';

$query = $this->db->query($sql);
$p_result = $query->result();
// 개인페이지 목록:E
?>
<link rel="stylesheet" href="/public/css/header.css?<?=time()?>">
<header class="header"></header>
<aside class="aside">
    <div class="logo_zone">
        <a href="/main/l_index" class="logo">TEXT WAY</a>
    </div>
    <div class="search_zone">
        <input type="text" autocomplete="off" placeholder="문서 검색">
    </div>
    <div class="zone setting_zone">
        <ul>
            <h4>설정</h4>
            <?php if ($_SERVER['PATH_INFO'] == '/space_manage') { ?>
                <li class="team_setting hv active">팀 공간 관리 페이지</li>
                <li class="personal_setting hv open_private">개인 공간 관리 페이지</li>
            <?php } else { ?>
                <li class="team_setting hv" onclick="location.href='/space_manage'">팀 공간 관리 페이지</li>
                <li class="personal_setting hv open_private">개인 공간 관리 페이지</li>
            <?php } ?>
        </ul>
    </div>
    <div class="zone team_zone">
        <ul>
            <h4>팀 페이지</h4>
            <li class="new hv">
                <span>+</span>
            새로운 프로젝트 추가
        </li>
        </ul>
    </div>
    <div class="zone personal_zone">
        <ul>
            <h4>개인 페이지</h4>
            <?php if (!empty($p_result)) { 
                foreach ($p_result as $row):
                    if ($row->p_depth_detail != '1') {
                        $class = 'sub_doc';
                    } else {
                        $class = '';
                    } 

                    if (strpos($_SERVER['PHP_SELF'], 'p_index') !== false) { ?>
            <li class="project_name hv <?=$class?>" onclick="auto_save('p_form', '<?=$row->ikey?>', CKEDITOR.instances.contents.getData(), '/main/p_index?i=<?=$row->ikey?>')"><?=$row->p_name?> <span>˙˙˙</span></li>
                    <?php } else { ?>
            <li class="project_name hv <?=$class?>" onclick="location.href='/main/p_index?i=<?=$row->ikey?>'"><?=$row->p_name?> <span>˙˙˙</span></li>
                    <?php } 
                endforeach;
            } ?>
            <li class="new hv" onclick="location.href='/main/p_index?new=y'">
                <span>+</span>
                새로운 프로젝트 추가
            </li>
        </ul>
    </div>
</aside>