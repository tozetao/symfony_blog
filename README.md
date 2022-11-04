- list

  查看可执行的命令

- doctrine:database:create

  创建数据库

- doctrine:migrations:migrate

  执行数据库迁移

- doctrine:fixtures:load



项目启用

1. 创建数据库并执行数据库迁移

2. 安装yarn，执行以下命令安装前端依赖包，并启动server

   ```
   yarn install
   yarn encore dev-server
   ```

3. 后台访问地址：http://localhost/symfony_blog/public/index.php/admin

   前台访问地址：http://localhost/symfony_blog/public/index.php/post



symfony是有缓存的，当你在/config目录下面新增了一个文件时，需要重建缓存才会生效。

- cache:clear

  清除缓存。

https://space.bilibili.com/452133624/channel/seriesdetail?sid=355222&ctype=0



## 依赖包

### encore

encore包是webpack的封装。

- composer req encore

  composer安装

- yarn encore dev-server

  通过yarn启动本地服务




### FOSJsRouteingBundle

https://github.com/FriendsOfSymfony/FOSJsRoutingBundle/blob/master/Resources/doc/installation.rst



### Panther





### fakerphp




### fixtures

- symfony console make:fixtures

  创建一个fixtures



### KnpPaginatorBundle



### flash message



### PHPUnit

PHP单元测试

