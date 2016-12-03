<div class="container-fluid">
    <div style="margin: 40px 0 0;"></div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h1 class="page-header">查询流水</h1>
            <div class="alert-warning error_info <?php if ($errorInfo) echo 'alert'; ?>"><?php echo $errorInfo; ?></div>
            <form class="form-inline time_from" role="form" method="get">
               <div class="input-group date form_date" data-date-format="yyyy-mm-dd">
                    <input class="form-control" type="text" name="startTime" placeholder="开始时间" value="<?php echo $startTime; ?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <div class="input-group date form_date" data-date-format="yyyy-mm-dd">
                    <div class="input-group-addon">-</div>
                    <input class="form-control" type="text" name="endTime" placeholder="结束时间" value="<?php echo $endTime ; ?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-remove"></span>
                    </span>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary">查询</button>
            </form>
            <div style="margin: 25px 0 0;border-bottom: 1px solid #eee;"></div>
        </div>
    </div>
    <?php if ($data) : ?>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h2 class="page-header">流水列表</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>流水号</th>
                            <th>商品编码</th>
                            <th>条形码</th>
                            <th>数量</th>
                            <th>出库时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data as $info): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $info['Sale']['id']; ?></td>
                            <td><?php echo $info['Sale']['goods_num']; ?></td>
                            <td><?php echo $info['Sale']['bar_code']; ?></td>
                            <td><?php echo $info['Sale']['amount']; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $info['Sale']['add_time']); ?></td>
                            <td>
                                <a href="/sales/refunds/<?php echo $info['Sale']['id']; ?>" class="do_del" style="text-decoration:none;">
                                    <span class="label label-danger">退货</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php echo $page; ?>
    <?php endif; ?>
</div>