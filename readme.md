# AIRBUS ES WEB UI

## 运行
```


Fr天蓝（odbc驱动版）：
docker network create docker0

docker run --name airbus --network docker0 -d -p 10080:80 -v /home/azure/airbus_web:/var/www joey/php-odbc

docker exec -it airbus bash

vim /etc/odbc.ini 
```

## 离线运行
导出Docker镜像为tar文件，传到离线服务器，导入镜像
```
docker save hitalos/laravel > laravel.tar
docker load < laravel.tar
```

## 常用文件位置
* 网页路由 route
```
routes/web.php
```

* 网页控制器 controller
```
app/Http/Controllers/
```

* 网页视图
```
resources/views/
```

* 网页资源文件
```
public/css/
public/js/
public/vendor/
```
