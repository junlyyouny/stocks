<div class="container-fluid">
    <div style="margin: 40px 0 0;"></div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h1 class="page-header">库存列表</h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>商品编码</th>
                            <th>库存编号</th>
                            <th>条形码</th>
                            <th>库存</th>
                            <th>录入时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $info): ?>
                        <tr>
                            <td><?php echo $info['Stock']['goods_num']; ?></td>
                            <td><?php echo $info['Stock']['id']; ?></td>
                            <td><?php echo $info['Stock']['bar_code']; ?></td>
                            <td><?php echo $info['Stock']['amount']; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $info['Stock']['add_time']); ?></td>
                            <td>
                                <a href="/stocks/delete/<?php echo $info['Stock']['id']; ?>" style="text-decoration:none;">
                                    <span class="label label-danger">删除</span>
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
</div>
