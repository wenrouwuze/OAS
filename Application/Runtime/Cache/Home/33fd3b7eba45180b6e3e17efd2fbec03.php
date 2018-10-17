<?php if (!defined('THINK_PATH')) exit();?><div class="tab" style="overflow: auto">
    <table class="table table-responsive" style="border: 1px solid #EEEEEE">
        <thead>
        <tr style="background:rgba(246,246,246,1);">
            <th><input type="checkbox" class="pull-left">序号</th>
            <th>姓名</th>
            <th>性别</th>
            <th>职位名称</th>
            <th>部门负责人</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" class="pull-left"><?php echo ($val["em_id"]); ?></td>
                <td class="name"><?php echo ($val["em_username"]); ?></td>
                <td>
                    <?php if($val["em_sex"] == 1): ?>男
                        <?php else: ?>
                        女<?php endif; ?>
                </td>
                <td><?php echo ($val["em_duties"]); ?></td>
                <td><?php echo ($val["department_boss"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

        </tbody>
    </table>
</div>
<div class="page" id="page">
</div>