<div class="container-fluid">
    <div style="margin: 40px 0 0;"></div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h1 class="page-header">入库信息</h1>
            <div class="alert-warning error_info"></div>
            <form class="form-inline input_from" role="form" method="post">
                <div class="form-group">
                    <label class="sr-only" for="goodsNum">商品编码</label>
                    <input type="text" class="form-control" id="goodsNum" name="goodsNum" placeholder="商品编码"></div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">-</div>
                        <input class="form-control" type="text" id="barcode" name="barcode" placeholder="条形码"></div>
                </div>
                <button type="submit" class="btn btn-primary">添加</button>
            </form>
            <div style="margin: 25px 0 0;border-bottom: 1px solid #eee;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h2 class="page-header">待入库列表</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>商品编码</th>
                            <th>条形码</th>
                            <th>录入时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>347-2</td>
                            <td>78765443</td>
                            <td>2016-10-12 13:20:23</td>
                            <td>
                                <span class="label label-danger">删除</span>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>347-2</td>
                            <td>78765444</td>
                            <td>2016-10-12 13:20:23</td>
                            <td>
                                <span class="label label-danger">删除</span>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>347-2</td>
                            <td>78765444</td>
                            <td>2016-10-12 13:20:23</td>
                            <td>
                                <span class="label label-danger">删除</span>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>347-2</td>
                            <td>78765444</td>
                            <td>2016-10-12 13:20:23</td>
                            <td>
                                <span class="label label-danger">删除</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div  class="col-xs-7 col-xs-offset-5 col-sm-7 col-sm-offset-5 col-md-7 col-md-offset-5">
        <button type="button" class="btn btn-success">提交</button>
    </div>
</div>