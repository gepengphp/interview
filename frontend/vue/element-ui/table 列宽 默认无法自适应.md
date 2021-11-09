# table 列宽 默认无法自适应

element UI table 组件，列宽默认无法自适应问题。

安装组件 [`zk-table`](https://github.com/Kuaizi-co/kz-table)。

```sh
npm install --save @kuaizi/kz-table
```

编辑 main.js 文件，重载 el-table 组件。

```js
import kzTable from '@kuaizi/kz-table'
Vue.use(kzTable)
```

给 el-table 组件添加 `auto-fit-column` 属性

```html
<el-table v-loading="loading" :data="tableData" border style="width: 100%" auto-fit-column>
```

完成。

`zk-table` 组件项目地址：[https://github.com/Kuaizi-co/kz-table](https://github.com/Kuaizi-co/kz-table)
