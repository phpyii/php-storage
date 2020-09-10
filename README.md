# php-storage
文件上传

安装
------------

```
composer require phpyii/php-storage

```

# 简介

php-storage PHP多存储驱动的文件管理类，支持多种云存储平台。

# 支持平台

- 本地服务器
- 腾讯云 COS
- 阿里云 OSS (未实现)
- 七牛云存储 (未实现)
- 又拍云存储 (未实现)

# 使用方法

   ```php
    $fileStorage = new FileStorage();
    $file = new FileObject();

    //本地存储
    $fileStorage->setDriver([
        'type' => 'local',
        'config' => [
            'domain' => 'http://www.baidu.com',
            'save_path' => 'E:/',
        ],
    ]);

    //腾讯cos
    //$fileStorage->setDriver([
    //    'type' => 'cos',
    //    'config' => [
    //        'secret_id' => '',
    //        'secret_key' => '',
    //        'app_id' => '',
    //        'bucket' => '',
    //        'region' => 'ap-beijing',
    //        'domain' => '', //留空自动设置
    //    ],
    //]);

    //上传
    //$file->fileTmpPath = 'E:/a.jpg';
    ////$file->filePath = ''; //新名称带后缀  留空自动生成
    //$file->ext = '.jpg'; //自动生成新名称时用
    //$file->mime = 'image/jpeg';
    //$file->saveDir = 'dev/test'; //保存目录
    //$file->dateDir = true; //是否自动追加日期目录
    //$file->isCover = true; //是否覆盖
    //$fr = $fileStorage->save($file);
    //if($fr->success){
    //    //文件保存路径
    //    //$fr->fileObject->filePath;
    //    //文件访问路径
    //    //$fr->fileObject->fileUrl;
    //}

    //删除
    //$fr = $fileStorage->del('/dev/test/2020/0910/08e87202009101612179540.jpg');

    //文件是否存在
    $fr = $fileStorage->has('/dev/test/2020/0910/0e80b202009101613326313.jpg');

    var_dump($fr);

   ```
