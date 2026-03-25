<?php
// 测试现代化模板是否正常工作
define('IN_CRONLITE', true);

// 模拟必要的变量
$_GET['modern'] = '1';
$hometitle = '测试现代化模板';
$conf = array(
    'keywords' => '测试关键词',
    'description' => '测试描述',
    'sitename' => '测试站点',
    'footer' => '测试页脚',
    'kfqq' => '123456789'
);
$cdnserver = './';
$siterow = array('class' => '');
$is_fenzhan = false;

// 模拟数据库查询结果
class MockDB {
    public function query($sql) {
        return new MockResult();
    }
}

class MockResult {
    private $data = array(
        array('cid' => 1, 'name' => '测试分类1', 'shopimg' => 'assets/img/Product/default.png'),
        array('cid' => 2, 'name' => '测试分类2', 'shopimg' => 'assets/img/Product/default.png'),
        array('cid' => 3, 'name' => '测试分类3', 'shopimg' => 'assets/img/Product/default.png')
    );
    private $index = 0;
    
    public function fetch() {
        if ($this->index < count($this->data)) {
            return $this->data[$this->index++];
        }
        return false;
    }
}

$DB = new MockDB();

// 包含现代化模板
include 'head_modern.php';
?>

<!-- 测试内容 -->
<div class="container-fluid mt-n7">
  <div class="row justify-content-center">
    <div class="col-xl-10">
      <div class="card">
        <div class="card-header">
          <h3 class="text-success">✅ 现代化模板加载成功！</h3>
        </div>
        <div class="card-body">
          <p>如果您看到这个页面，说明现代化模板已经正确加载。</p>
          <div class="row">
            <div class="col-md-4">
              <div class="card border-primary">
                <div class="card-body text-center">
                  <i class="fas fa-check-circle fa-3x text-primary mb-3"></i>
                  <h5>Bootstrap 5</h5>
                  <p class="small">现代化UI框架</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card border-success">
                <div class="card-body text-center">
                  <i class="fas fa-palette fa-3x text-success mb-3"></i>
                  <h5>现代设计</h5>
                  <p class="small">优雅的视觉效果</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card border-info">
                <div class="card-body text-center">
                  <i class="fas fa-mobile-alt fa-3x text-info mb-3"></i>
                  <h5>响应式</h5>
                  <p class="small">完美适配各种设备</p>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-4 text-center">
            <a href="javascript:history.back()" class="btn btn-primary me-2">
              <i class="fas fa-arrow-left"></i> 返回
            </a>
            <a href="./index.php?modern=1" class="btn btn-success">
              <i class="fas fa-home"></i> 查看完整页面
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="py-4 mt-5 bg-light">
  <div class="container text-center">
    <p class="text-muted small">现代化模板测试页面</p>
  </div>
</footer>

<script src="<?php echo $cdnserver?>assets/js/bootstrap-5.3.0.bundle.min.js"></script>
</body>
</html> 