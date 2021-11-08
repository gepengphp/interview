# npm 安装

环境：`Centos 7`

1. 安装gcc
    ```sh
    yum install gcc gcc-c++
    ```

2. 下载

    ```sh
    > cd /soft
    > wget https://npm.taobao.org/mirrors/node/v10.14.1/node-v10.14.1-linux-x64.tar.gz
    ```

3. 解压并重命名
    ```sh
    > tar -xvf node-v10.14.1-linux-x64.tar.gz
    > mv node-v10.14.1-linux-x64 node
    > mv node /usr/local/
    ```

4. 添加环境变量
    ```sh
    > vi /etc/profile
    # 添加内容
    export NODE_HOME=/usr/local/node  
    export PATH=$NODE_HOME/bin:$PATH
    > source /etc/profile
    ```

5. 修改镜像源
    ```sh
    > npm config set registry "https://registry.npm.taobao.org"
    # 查看
    > npm config get registry
    https://registry.npm.taobao.org/
    ```

6. Jenkins 执行 npm 报错：node: 没有那个文件或目录
    ```sh
    + /usr/local/node/bin/npm install
    /usr/bin/env: node: 没有那个文件或目录
    Build step 'Execute shell' marked build as failure
    Finished: FAILURE
    ```

    原因：jenkins 调用 node 的时，默认 node 位置在 /usr/bin/node

    添加软链

    ```sh
    > ln -s /usr/local/node/bin/node /usr/bin/node
    > ll /usr/bin/node
    lrwxrwxrwx 1 root root 24 11月  8 14:16 /usr/bin/node -> /usr/local/node/bin/node
    ```
