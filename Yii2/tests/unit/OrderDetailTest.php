<?php
namespace tests\unit;
use common\models\OrderDetail;
class OrderDetailTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
      $this->assertTrue(2==2);
    }
    public function testM1(){
      $this->assertTrue(2<1);
    }
    //另一个测试
  public function testValidInput()
  {
    $model = new OrderDetail();
    $model->product_id = 9;
    $model->price = 100;
    expect_that($model->validate());
    return $model;
  }
  public function testInvalidInput()
  {
    $model = new OrderDetail();
    $model->product_id = 9;
    $model->price = "";
    expect_not($model->validate());
    $model = new OrderDetail();
    $model->name = '';
    $model->email = 100;
    expect_not($model->validate());
  }
  /**
   * 下面一行表示这里输入的参数值来自testValidInput的输出
   * @depends testValidInput
   */
  public function testModelProperty($model)
  {
    expect($model->name)->equals(9);
  }
}