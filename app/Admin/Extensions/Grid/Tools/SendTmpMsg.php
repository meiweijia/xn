<?php

namespace App\Admin\Extensions\Grid\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;

class SendTmpMsg extends AbstractTool
{
    /**
     * Render CreateButton.
     *
     * @return string
     */
    public function render()
    {
        $url = route('admin.send_tmp_msg');
        return <<<EOT

<div class="btn-group pull-right grid-create-btn" style="margin-right: 10px">
    <a href="javascript:void(0);" onclick="sendRentLog()" class="btn btn-sm btn-success" title="发送">
        <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;发送</span>
    </a>
</div>
<script>
function sendRentLog(){
    $.get( "/admin.send_tmp_smg", function( data ) {
        console.log(data);
        alert( "发送成功" );
    });
}
</script>
EOT;
    }
}
