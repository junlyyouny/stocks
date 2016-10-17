<div class="container-fluid">
    <div style="margin: 40px 0 0;"></div>
    <div class="row">
        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1">
            <h1 class="page-header">出库信息</h1>
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label class="sr-only" for="storageNum">库存编号</label>
                    <input type="text" class="form-control" id="storageNum" name="storageNum" placeholder="库存编号"></div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">or</div>
                        <input class="form-control" type="number" name="barcode" placeholder="条形码"></div>
                </div>
                <button type="submit" class="btn btn-default">添加</button>
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
                            <th>库存编号</th>
                            <th>商品编码</th>
                            <th>条形码</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>347-2</td>
                            <td>78765443</td>
                            <td>
                                <span class="label label-danger">删除</span>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>3</td>
                            <td>347-2</td>
                            <td>78765444</td>
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