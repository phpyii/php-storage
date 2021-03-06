<?php

declare (strict_types = 1);

namespace phpyii\storage\drivers;

use phpyii\storage\FileObject;
use phpyii\storage\FileResult;

/**
 * Description of DriverAbstract
 * 存储抽象类
 * @author 最初的梦想
 */
abstract class DriverAbstract {

    /**
     * 文件对象
     * @var FileObject 
     */
    protected $fileObject = null;

    /**
     * 驱动配置
     * @var array 
     */
    protected $config = [
        'domain' => 'http://127.0.0.1',
        'save_path' => ''
    ];

    /**
     * 构建函数
     * FilesInterface constructor.
     * @param $config
     */
    public function __construct(array $config = []) {
        if (!empty($config)) {
            $this->setConfig($config);
        }
    }

    /**
     * 设置配置
     * @param array $config
     */
    public function setConfig($config) {
        if (!empty($config['save_path'])) {
            $config['save_path'] = rtrim(str_replace('\\', '/', $config['save_path']), '/');
        }
        $this->config = array_merge($this->config, $config);
        $this->checkConfig();
    }

    /**
     * 获取配置
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getConfig($key = null, $default = null) {
        if (empty($key)) {
            return $this->config;
        }
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return $default;
    }

    /**
     * 设置文件
     * @param FileObject $fileObject
     */
    public function setFileObject(FileObject $fileObject) {
        $this->fileObject = $fileObject;
    }

    /**
     * 封装GuzzleHttp请求
     * @param type $method
     * @param type $uri
     * @param array $options
     * @return type
     */
    public function request($method, $uri = '', array $options = []) {
        try {
            return (new \GuzzleHttp\Client())->request($method, $uri, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            }
        } catch (\Exception $exc) {
            return false;
        }
        return false;
    }

    /**
     * 上传前检查
     */
    protected function beforeSave() {
        if (empty($this->fileObject->fileData)) {
            return ['success' => false, 'msg' => '上传的文件不存在'];
        }
        if ($this->fileObject->size > $this->fileObject->maxSize) {
            return ['success' => false, 'msg' => '上传文件过大'];
        }
        if(!empty($this->fileObject->allowExts) && !in_array($this->fileObject->ext, $this->fileObject->allowExts)){
            return ['success' => false, 'msg' => '上传文件格式不正确'];
        }
        if (!$this->fileObject->isCover) {
            $fr = $this->has($this->fileObject->filePath);
            if (!$fr->success) {
                return ['success' => false, 'msg' => $fr->msg];
            }
        }
        return ['success' => true, 'msg' => 'ok'];
    }

    /**
     * 检测配置
     * @return bool
     */
    abstract public function checkConfig(): bool;

    /**
     * 保存文件
     * @return FileResult 上传结果
     */
    abstract public function save(): FileResult;

    /**
     * 删除文件
     * @param string $filePath  文件路径
     * @return FileResult
     */
    abstract public function del($filePath = ''): FileResult;

    /**
     * 文件是否存在
     * @param string $filePath 文件路径
     * @return FileResult
     */
    abstract public function has($filePath = ''): FileResult;
}
