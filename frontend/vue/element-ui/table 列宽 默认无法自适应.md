# table 列宽 默认无法自适应

element UI table 组件，列宽默认无法自适应问题。

网上搜索的一般都是计算每列宽度，动态设置，麻烦。

其中一个集成非常简单：`zk-table`。只需要安装后重新加载，覆盖原 `el-table` 组件后，添加一个属性 `auto-fit-column` 即可。

这个组件被 `laravel-vue-admin` 项目使用。

过程：

1. 安装组件 [`zk-table`](https://github.com/Kuaizi-co/kz-table)。

    ```sh
    npm install --save @kuaizi/kz-table
    ```

2. 编辑 main.js 文件，重载 el-table 组件。

    ```js
    import kzTable from '@kuaizi/kz-table'
    Vue.use(kzTable)
    ```

3. 给 el-table 组件添加 `auto-fit-column` 属性

    ```html
    <el-table v-loading="loading" :data="tableData" border style="width: 100%" auto-fit-column>
    ```

完成。

`zk-table` 组件项目地址：[https://github.com/Kuaizi-co/kz-table](https://github.com/Kuaizi-co/kz-table)
