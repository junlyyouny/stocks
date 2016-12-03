<div class="container-fluid">
    <div style="margin: 40px 0 0;"></div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h1 class="page-header">查询库存</h1>
            <div class="alert-warning error_info <?php if ($errorInfo) echo 'alert'; ?>"><?php echo $errorInfo; ?></div>
            <form class="form-inline sale_from" role="form" method="post">
                <div class="form-group">
                    <label class="sr-only" for="stocksId">商品编码</label>
                    <input type="text" class="form-control" id="stocksId" name="goodsNum" placeholder="商品编码" value=""></div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">-</div>
                        <input class="form-control" type="text" id="barcode" name="barcode" placeholder="条形码"></div>
                </div>
                <button type="submit" class="btn btn-primary">查询</button>
            </form>
            <div style="margin: 25px 0 0;border-bottom: 1px solid #eee;"></div>
        </div>
    </div>
    <?php if ($data) : ?>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h2 class="page-header">库存列表</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>库存编号</th>
                            <th>商品编码</th>
                            <th>条形码</th>
                            <th>库存</th>
                            <th>录入时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $info): ?>
                        <tr>
                            <td><?php echo $info['Stock']['id']; ?></td>
                            <td><?php echo $info['Stock']['goods_num']; ?></td>
                            <td><?php echo $info['Stock']['bar_code']; ?></td>
                            <td><?php echo $info['Stock']['amount']; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $info['Stock']['add_time']); ?></td>
                            <td>
                                <a href="/stocks/delete/<?php echo $info['Stock']['id']; ?>" style="text-decoration:none;" class="do_del">
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
    <?php endif; ?>
</div>
