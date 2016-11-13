<div class="container-fluid">
    <div style="margin: 40px 0 0;"></div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h1 class="page-header">出库信息</h1>
            <div class="alert-warning error_info <?php if ($errorInfo) echo 'alert'; ?>"><?php echo $errorInfo; ?></div>
            <form class="form-inline sale_from" role="form" method="post">
                <div class="form-group">
                    <label class="sr-only" for="stocksId">库存编号</label>
                    <input type="text" class="form-control" id="stocksId" name="stocksId" placeholder="库存编号"></div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">or</div>
                        <input class="form-control" type="text" id="barcode" name="barcode" placeholder="条形码"></div>
                </div>
                <button type="submit" class="btn btn-primary">添加</button>
            </form>
            <div style="margin: 25px 0 0;border-bottom: 1px solid #eee;"></div>
        </div>
    </div>
    <?php if ($saleInfo) : ?>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h2 class="page-header">待出库列表</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>库存编号</th>
                            <th>商品编码</th>
                            <th>条形码</th>
                            <th>数量</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($saleInfo as $key => $info): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $info['goods_num']; ?></td>
                            <td><?php echo $info['bar_code']; ?></td>
                            <td><?php echo $info['amount']; ?></td>
                            <td>
                                <a href="/sales/del/<?php echo $key; ?>" class="do_del" style="text-decoration:none;">
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
    <div  class="col-xs-7 col-xs-offset-5 col-sm-7 col-sm-offset-5 col-md-7 col-md-offset-5">
        <a href="/sales/add">
            <button type="button" class="btn btn-success">提交</button>
        </a>
    </div>
    <?php endif; ?>
</div>