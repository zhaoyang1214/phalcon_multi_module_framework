# phalcon多模块框架

## 项目介绍
#### 这是一个phalcon多模块web和单模块cli框架，系统封装了一些比较好用的方法
**主要特点有：**
1. 系统集成了多模块web和单模块cli。
2. 重写封装了部分服务
3. 封装了验证器
4. 在基础控制器中封装了获取get、post、json参数并自动过滤数据
5. 对原转发（forward）做了封装
6. 集成了smarty模板引擎

#### 添加模块很容易
**例如还需要增加一个api模块**
1. 打开config/define.php,把“api”增加到“MODULE_ALLOW_LIST”中define('MODULE_ALLOW_LIST', ['home', 'admin', 'api']);
2. 复制一份module_bak重命名为api
3. 搜索api目录下文件，将“module_bak”替换为“api”，将“Module_bak”替换为“Api”

**只需这三步即可创建新模块**

更多特点可以看博客https://blog.csdn.net/u014691098/article/category/7632913