<?php

	foreach ($members as $member) {

        $method =   '一般登入';
        if (!is_null($member['fb_id'])) $method = 'facebook登入';
        if (!is_null($member['line_id'])) $method = 'LINE登入';

        $ocount     =   $db->where('mid', $member['id'])->getValue('orders', 'count(*)');
        $addr       =   $member['county'].$member['district'];

        $fbox .= '<tr>
                    <td class="text-left align-middle" style="vertical-align:center">'.$member['id'].'</td>
                    <td class="text-left align-middle" style="vertical-align:center"><a href="member_detail.php?mid='.$member['id'].'" target="_blank">'.$member['mname'].'</a></td>

                    <td class="align-middle text-left" style="vertical-align:center"><a href="tel:'.$member['phone'].'">'.$member['phone'].'</a></td>
                    <td class="align-middle text-left" style="vertical-align:center">'.$method.'</td>
                    <td class="align-middle text-left" style="vertical-align:center"><a>'.$ocount.'</a></td>

                    <td class="align-middle text-left" style="vertical-align:center">'.$addr.'</td>                   

                    <td class="text-right align-middle">
                        <div class="btn-group">
                          <button data-mid='.$member['id'].' data-mobile="'.$member['phone'].'" data-name="'.$member['mname'].'" type="button" class="btn btn-rounded btn-pink btn-sm btn-edit-member">
                          <i class="fas fa-cog fa-fw"></i>
                          <span class="hidden-md-down"> 設定</span></button>

                          <button data-mid='.$member['id'].' type="button" class="btn btn-rounded btn-pink btn-sm btn-del-member"><span class="hidden-md-down">刪除 </span><i class="fa fa-trash fa-fw"></i></button>
                        </div>
                    </td>
                </tr>';
	}

?>