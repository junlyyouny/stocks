<div class="container-fluid">
    <div style="margin: 40px 0 0;"></div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h1 class="page-header">流水列表</h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>流水号</th>
                            <th>商品编码</th>
                            <th>条形码</th>
                            <th>数量</th>
                            <th>出库时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $info): ?>
                        <tr>
                            <td><?php echo $info['Sale']['id']; ?></td>
                            <td><?php echo $info['Sale']['goods_num']; ?></td>
                            <td><?php echo $info['Sale']['bar_code']; ?></td>
                            <td><?php echo $info['Sale']['amount']; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $info['Sale']['add_time']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php echo $page; ?>
</div>